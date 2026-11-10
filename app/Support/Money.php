<?php

namespace App\Support;

/**
 * Format tampilan uang per mata uang.
 *
 * Anggaran trip TIDAK dikonversi: total ditampilkan terpisah per mata
 * uang yang dipakai pengguna. Khusus BIAYA MASUK destinasi, kebijakan
 * tampilannya (keputusan pemilik aplikasi): destinasi Indonesia dalam
 * Rupiah, destinasi luar negeri dalam Dolar AS — nilai Dolar-nya adalah
 * setara perkiraan dari tarif lokal terpublikasi, disimpan di database
 * oleh seeder harga, dan selalu ditampilkan dengan label perkiraan.
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
     * Format biaya masuk destinasi: Indonesia dalam Rupiah, negara lain
     * dalam Dolar AS (nilai yang tersimpan untuk destinasi luar negeri
     * memang sudah Dolar AS — lihat UsdEntranceFeesSeeder). Nilai 0
     * berarti tempatnya gratis. Mengembalikan null bila biaya memang
     * belum tercatat.
     */
    public static function entranceFee(float|int|null $amount, ?string $country): ?string
    {
        if ($amount === null) {
            return null;
        }

        if ((float) $amount === 0.0) {
            return __('Gratis');
        }

        $currency = ($country === 'Indonesia') ? 'IDR' : 'USD';

        return self::format($amount, $currency);
    }
}
