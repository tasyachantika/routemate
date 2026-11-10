<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

/**
 * Menyelesaikan biaya masuk SEMUA destinasi (keputusan pemilik aplikasi,
 * 10 Nov 2026):
 * - Destinasi luar negeri: entrance_fee disimpan dalam DOLAR AS, yaitu
 *   setara perkiraan dari tarif standar dewasa yang terpublikasi dalam
 *   mata uang lokalnya (kurs perkiraan November 2026, dibulatkan).
 * - Destinasi Indonesia yang masih kosong: diisi tarif domestik
 *   terpublikasi dalam Rupiah.
 * - Tempat yang memang gratis (museum/pantai/ruang publik tanpa tiket)
 *   diisi 0 dan tampil sebagai "Gratis".
 * Setelah seeder ini, tidak ada destinasi tanpa keterangan harga.
 * Aman dijalankan ulang: nilai ditulis berdasarkan nama destinasi.
 */
class UsdEntranceFeesSeeder extends Seeder
{
    public function run(): void
    {
        // Destinasi luar negeri -> Dolar AS (setara perkiraan tarif lokal).
        $usd = [
            'Tokyo Tower' => 8,                    // ¥1.200
            'Fushimi Inari Taisha' => 0,           // gratis
            'Kastil Osaka' => 4,                   // ¥600
            'Pagoda Chureito dan Gunung Fuji' => 0, // gratis
            'Tokyo Disneyland' => 57,              // ¥8.900
            'Istana Gyeongbokgung' => 2,           // ₩3.000
            'N Seoul Tower' => 15,                 // ₩21.000 (observatorium)
            'Desa Budaya Gamcheon' => 0,           // gratis
            'Menara Kembar Petronas' => 30,        // RM127 (pengunjung asing)
            'Batu Caves' => 0,                     // gratis
            'Merlion Park' => 0,                   // gratis
            'Gardens by the Bay' => 35,            // S$46 (dua konservatorium)
            'Universal Studios Singapore' => 63,   // S$82
            'Grand Palace' => 15,                  // ฿500
            'Wat Arun' => 3,                       // ฿100
            'Ha Long Bay' => 11,                   // ₫290.000 (tiket rute wisata)
            'El Nido' => 3,                        // ₱200 (biaya lingkungan ETDF)
            'Tembok Besar Mutianyu' => 6,          // ¥45
            'Menara Eiffel' => 43,                 // €36,70 (lift ke puncak)
            'Disneyland Paris' => 115,             // €99
            'Museum Louvre' => 26,                 // €22
            'Big Ben dan Istana Westminster' => 0, // gratis dari luar
            'British Museum' => 0,                 // gratis
            'Colosseum' => 21,                     // €18
            'Menara Miring Pisa' => 23,            // €20
            'Sagrada Familia' => 30,               // €26
            'Santorini' => 0,                      // gratis
            'Burj Khalifa' => 51,                  // AED 189 (At The Top 124/125)
            'Sydney Opera House' => 28,            // A$43 (tur standar)
            'Disneyland California' => 154,        // memang USD
            'Patung Liberty' => 25,                // memang USD
            'Pantai Waikiki' => 0,                 // gratis
            'Air Terjun Niagara' => 0,             // gratis dari sisi publik
            'Piramida Agung Giza' => 11,           // E£540
            'Taj Mahal' => 12,                     // ₹1.100
            'Angkor Wat' => 37,                    // memang USD
        ];

        // Destinasi Indonesia yang masih kosong -> Rupiah (tarif domestik).
        $idr = [
            'Pantai Kuta' => 0,        // gratis
            'Kawah Ijen' => 10000,     // tarif masuk kawasan wisata alam
            'Gunung Bromo' => 29000,   // domestik hari kerja (TNBTS)
            'Danau Toba' => 0,         // kawasan terbuka, gratis
            'Pulau Padar' => 50000,    // TN Komodo, domestik hari kerja
            'Gili Trawangan' => 0,     // gratis
            'Raja Ampat' => 500000,    // kartu jasa pemeliharaan lingkungan domestik
            'Gunung Rinjani' => 50000, // jalur utama, domestik hari kerja (tarif Nov 2025)
            'Pantai Pink' => 50000,    // TN Komodo, domestik hari kerja
        ];

        $updated = 0;
        foreach (array_merge($usd, $idr) as $name => $fee) {
            $updated += Destination::where('name', $name)->update(['entrance_fee' => $fee]);
        }

        $free = Destination::where('entrance_fee', 0)->count();
        $filled = Destination::whereNotNull('entrance_fee')->count();
        $total = Destination::count();
        $this->command->info("Biaya masuk diperbarui: {$updated} destinasi. Terisi harga: {$filled} dari {$total} (termasuk {$free} gratis).");
    }
}
