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
     * Format biaya masuk destinasi dalam mata uang negara tujuannya.
     * Mengembalikan null bila biaya tidak tercatat, dan teks "Gratis"
     * (diterjemahkan mengikuti bahasa antarmuka) bila biayanya 0.
     */
    public static function entranceFee(float|int|null $amount, ?string $country): ?string
    {
        if ($amount === null) {
            return null;
        }

        if ((float) $amount === 0.0) {
            return __('Gratis');
        }

        $currency = self::$countryCurrencies[$country ?? ''] ?? 'IDR';

        return self::format($amount, $currency);
    }
}
