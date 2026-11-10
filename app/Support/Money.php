<?php

namespace App\Support;

/**
 * Format tampilan uang per mata uang.
 *
 * RouteMate v1 TIDAK melakukan konversi kurs:
 * - Anggaran trip tidak dikonversi; total ditampilkan terpisah per mata
 *   uang yang dipakai pengguna, apa adanya.
 * - Biaya masuk destinasi ditampilkan dalam mata uang negara destinasi
 *   itu sendiri (Indonesia: Rupiah, Jepang: Yen, dan seterusnya), sesuai
 *   tarif yang tercatat di database.
 * Nilai biaya masuk 0 berarti tempatnya gratis.
 */
class Money
{
    /**
     * Kode mata uang => [simbol, jumlah desimal, pemisah desimal, pemisah ribuan]
     *
     * @var array<string, array{string, int, string, string}>
     */
    private static array $formats = [
        'IDR' => ['Rp', 0, ',', '.'],
        'JPY' => ['¥', 0, '.', ','],
        'USD' => ['$', 2, '.', ','],
        'KRW' => ['₩', 0, '.', ','],
        'MYR' => ['RM', 2, '.', ','],
        'SGD' => ['S$', 2, '.', ','],
        'EUR' => ['€', 2, '.', ','],
        'GBP' => ['£', 2, '.', ','],
        'THB' => ['฿', 2, '.', ','],
        'VND' => ['₫', 0, ',', '.'],
        'PHP' => ['₱', 2, '.', ','],
        'CNY' => ['¥', 2, '.', ','],
        'AED' => ['AED ', 2, '.', ','],
        'AUD' => ['A$', 2, '.', ','],
        'CAD' => ['C$', 2, '.', ','],
        'EGP' => ['E£', 2, '.', ','],
        'INR' => ['₹', 0, '.', ','],
    ];

    /**
     * Negara destinasi => mata uang lokal untuk biaya masuk.
     * Biaya masuk destinasi selalu dicatat dalam mata uang negara setempat.
     *
     * @var array<string, string>
     */
    private static array $countryCurrencies = [
        'Indonesia' => 'IDR',
        'Jepang' => 'JPY',
        'Korea Selatan' => 'KRW',
        'Malaysia' => 'MYR',
        'Singapura' => 'SGD',
        'Thailand' => 'THB',
        'Vietnam' => 'VND',
        'Filipina' => 'PHP',
        'Tiongkok' => 'CNY',
        'Prancis' => 'EUR',
        'Inggris' => 'GBP',
        'Italia' => 'EUR',
        'Spanyol' => 'EUR',
        'Yunani' => 'EUR',
        'Uni Emirat Arab' => 'AED',
        'Australia' => 'AUD',
        'Amerika Serikat' => 'USD',
        'Kanada' => 'CAD',
        'Mesir' => 'EGP',
        'India' => 'INR',
        'Kamboja' => 'USD',
    ];

    public static function format(float|int|null $amount, string $currency): string
    {
        if ($amount === null) {
            return '-';
        }

        $currency = strtoupper($currency);
        [$symbol, $decimals, $decimalSep, $thousandsSep] = self::$formats[$currency]
            ?? [$currency . ' ', 2, '.', ','];

        return $symbol . number_format((float) $amount, $decimals, $decimalSep, $thousandsSep);
    }

    /**
     * Bahasa antarmuka => mata uang tampilan biaya masuk.
     * Keputusan pemilik aplikasi: mata uang mengikuti bahasa yang dipilih
     * pengunjung (Indonesia=Rupiah, English=Dolar AS, Jepang=Yen,
     * Korea=Won, Mandarin=Yuan, Melayu=Ringgit).
     *
     * @var array<string, string>
     */
    private static array $localeCurrencies = [
        'id' => 'IDR',
        'en' => 'USD',
        'ja' => 'JPY',
        'ko' => 'KRW',
        'zh' => 'CNY',
        'ms' => 'MYR',
    ];

    /**
     * Kurs perkiraan TETAP: nilai 1 USD dalam tiap mata uang
     * (patokan November 2026, dibulatkan). Hanya untuk tampilan biaya
     * masuk agar pengunjung melihat angka dalam mata uang yang familiar;
     * bukan kurs transaksi. Harga yang tersimpan di database selalu
     * tarif lokal aslinya dan tidak pernah diubah tabel ini.
     *
     * @var array<string, float>
     */
    private static array $usdRates = [
        'IDR' => 15600,
        'JPY' => 156,
        'USD' => 1,
        'KRW' => 1400,
        'MYR' => 4.2,
        'SGD' => 1.30,
        'THB' => 33,
        'VND' => 26000,
        'PHP' => 59,
        'CNY' => 7.1,
        'EUR' => 0.86,
        'GBP' => 0.75,
        'AED' => 3.67,
        'AUD' => 1.52,
        'CAD' => 1.39,
        'EGP' => 48,
        'INR' => 88,
    ];

    /**
     * Format biaya masuk destinasi. Nilai tersimpan adalah tarif lokal
     * negara destinasi; tampilan dikonversi dengan kurs perkiraan ke
     * mata uang yang mengikuti bahasa antarmuka aktif. Mengembalikan
     * null bila biaya tidak tercatat, dan teks "Gratis" (diterjemahkan
     * mengikuti bahasa antarmuka) bila biayanya 0.
     */
    public static function entranceFee(float|int|null $amount, ?string $country): ?string
    {
        if ($amount === null) {
            return null;
        }

        if ((float) $amount === 0.0) {
            return __('Gratis');
        }

        $source = self::$countryCurrencies[$country ?? ''] ?? 'IDR';
        $display = self::$localeCurrencies[app()->getLocale()] ?? 'IDR';
        $value = (float) $amount;

        if ($source !== $display) {
            // Konversi lewat USD sebagai mata uang jembatan.
            $value = $value / self::$usdRates[$source] * self::$usdRates[$display];

            // Bulatkan wajar untuk mata uang bernominal besar.
            $value = match ($display) {
                'IDR' => round($value / 500) * 500,
                'KRW', 'VND' => round($value / 100) * 100,
                'JPY' => round($value / 10) * 10,
                default => $value,
            };
        }

        return self::format($value, $display);
    }
}
