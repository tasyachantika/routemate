<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class UpdateEntranceFeesSeeder extends Seeder
{
    /**
     * Mengisi biaya masuk berdasarkan tarif standar dewasa yang
     * dipublikasikan untuk tiap tempat (sifatnya PERKIRAAN, mata uang
     * mengikuti negara destinasi, sama seperti data awal RouteMate).
     * Tempat yang memang gratis / tanpa tiket resmi (pantai umum, pulau,
     * kuil tanpa tiket) sengaja TIDAK diisi di sini agar tampil sebagai
     * "Gratis / tidak diketahui" — itu data yang benar untuk tempat itu.
     * Aman dijalankan ulang.
     */
    public function run(): void
    {
        $fees = [
            'Candi Borobudur' => 50000,          // Rp, pengunjung domestik
            'Museum Nasional Indonesia' => 25000, // Rp
            'Tanah Lot' => 20000,                 // Rp, pengunjung domestik
            'Kawah Putih' => 28000,               // Rp, pengunjung domestik
            'Tokyo Disneyland' => 8900,           // Yen, kisaran tarif 1 hari
            'Disneyland Paris' => 99,             // Euro, tarif 1 hari standar
            'Disneyland California' => 154,       // USD, tarif 1 hari umum
            'Universal Studios Singapore' => 82,  // SGD, tarif 1 hari dewasa
            'Museum Louvre' => 22,                // Euro, tiket masuk standar
            'Piramida Agung Giza' => 540,         // EGP, tiket area piramida
            'Taj Mahal' => 1100,                  // Rupee, pengunjung asing
            'Patung Liberty' => 25,               // USD, feri + area patung (perkiraan)
            'Menara Miring Pisa' => 20,           // Euro, naik menara
            'Sagrada Familia' => 26,              // Euro, tiket masuk standar
            'Angkor Wat' => 37,                   // USD, Angkor Pass 1 hari
        ];

        foreach ($fees as $name => $fee) {
            $updated = Destination::where('name', $name)->update(['entrance_fee' => $fee]);
            if ($updated) {
                $this->command?->info('Harga diperbarui: ' . $name);
            }
        }
    }
}
