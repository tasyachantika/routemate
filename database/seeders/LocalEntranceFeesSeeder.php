<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

/**
 * Menetapkan biaya masuk SELURUH destinasi dalam MATA UANG LOKAL negara
 * masing-masing (tarif standar dewasa yang terpublikasi; nilai 0 berarti
 * tempatnya memang gratis, misalnya museum/pantai/ruang publik tanpa
 * tiket). Biaya ditampilkan apa adanya tanpa konversi kurs, dengan label
 * perkiraan di tampilan karena tarif dapat berubah.
 *
 * Aman dijalankan ulang: nilai ditulis berdasarkan nama destinasi.
 */
class LocalEntranceFeesSeeder extends Seeder
{
    public function run(): void
    {
        $fees = [
            // Indonesia (Rupiah)
            'Monumen Nasional (Monas)' => 20000,
            'Candi Borobudur' => 50000,
            'Pantai Kuta' => 0,
            'Kawah Ijen' => 10000,
            'Gunung Bromo' => 29000,
            'Candi Prambanan' => 50000,
            'Danau Toba' => 0,
            'Pulau Padar' => 50000,
            'Gili Trawangan' => 0,
            'Raja Ampat' => 500000,
            'Gunung Rinjani' => 50000,
            'Museum Nasional Indonesia' => 25000,
            'Pantai Pink' => 50000,
            'Tanah Lot' => 20000,
            'Kawah Putih' => 28000,
            // Jepang (Yen)
            'Tokyo Tower' => 1200,
            'Fushimi Inari Taisha' => 0,
            'Kastil Osaka' => 600,
            'Pagoda Chureito dan Gunung Fuji' => 0,
            'Tokyo Disneyland' => 8900,
            // Korea Selatan (Won)
            'Istana Gyeongbokgung' => 3000,
            'N Seoul Tower' => 21000,
            'Desa Budaya Gamcheon' => 0,
            // Malaysia (Ringgit)
            'Menara Kembar Petronas' => 127,
            'Batu Caves' => 0,
            // Singapura (Dolar Singapura)
            'Merlion Park' => 0,
            'Gardens by the Bay' => 46,
            'Universal Studios Singapore' => 82,
            // Thailand (Baht)
            'Grand Palace' => 500,
            'Wat Arun' => 100,
            // Vietnam (Dong)
            'Ha Long Bay' => 290000,
            // Filipina (Peso)
            'El Nido' => 200,
            // Tiongkok (Yuan)
            'Tembok Besar Mutianyu' => 45,
            // Prancis (Euro)
            'Menara Eiffel' => 36.7,
            'Disneyland Paris' => 99,
            'Museum Louvre' => 22,
            // Inggris (Pound)
            'Big Ben dan Istana Westminster' => 0,
            'British Museum' => 0,
            // Italia (Euro)
            'Colosseum' => 18,
            'Menara Miring Pisa' => 20,
            // Spanyol (Euro)
            'Sagrada Familia' => 26,
            // Yunani (Euro)
            'Santorini' => 0,
            // Uni Emirat Arab (Dirham)
            'Burj Khalifa' => 189,
            // Australia (Dolar Australia)
            'Sydney Opera House' => 43,
            // Amerika Serikat (Dolar AS)
            'Disneyland California' => 154,
            'Patung Liberty' => 25,
            'Pantai Waikiki' => 0,
            'Air Terjun Niagara' => 0,
            // Mesir (Pound Mesir)
            'Piramida Agung Giza' => 540,
            // India (Rupee)
            'Taj Mahal' => 1100,
            // Kamboja (Dolar AS)
            'Angkor Wat' => 37,
        ];

        $updated = 0;
        foreach ($fees as $name => $fee) {
            $updated += Destination::where('name', $name)->update(['entrance_fee' => $fee]);
        }

        $this->command->info("LocalEntranceFeesSeeder: {$updated} destinasi diperbarui biaya masuknya (mata uang lokal).");
    }
}
