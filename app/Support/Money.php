<?php

namespace App\Support;

/**
 * Format tampilan uang per mata uang.
 *
 * RouteMate v1 TIDAK melakukan konversi kurs: angka hanya diformat
 * sesuai kebiasaan mata uangnya (simbol, jumlah desimal, pemisah ribuan)
 * supaya Rp100.000 tidak tertukar dengan ¥100.000.
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
     * Format biaya masuk destinasi berdasarkan negara tujuannya.
     * Mengembalikan null bila biaya tidak tercatat.
     */
    public static function entranceFee(float|int|null $amount, ?string $country): ?string
    {
        if ($amount === null) {
            return null;
        }

        $currency = self::$countryCurrencies[$country ?? ''] ?? 'IDR';

        return self::format($amount, $currency);
    }
}
