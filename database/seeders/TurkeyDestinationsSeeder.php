<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Tambahan khusus Turki: 3 destinasi (total menjadi 76).
 * Melengkapi Masjid Biru dari WorldDestinationsSeeder sehingga Turki
 * memiliki 4 destinasi: Hagia Sophia, Kapadokia, dan Grand Bazaar.
 *
 * Biaya masuk: Hagia Sophia mengenakan tiket wisatawan asing EUR 25
 * yang dibayar dalam lira (disimpan setara ±TRY 1.200); kawasan
 * Kapadokia dan Grand Bazaar gratis dikunjungi (museum dan wahana
 * balon di Kapadokia berbayar terpisah di lokasi).
 */
class TurkeyDestinationsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        // [nama, kota, negara, kategori, biaya masuk (TRY), lat, lng, file foto, deskripsi]
        $rows = [
            ['Hagia Sophia', 'Istanbul', 'Turki', 'Wisata Sejarah', 1200, 41.0086, 28.9802, 'hagia-sophia.jpg', 'Bangunan megah berusia hampir 1.500 tahun di Istanbul yang pernah menjadi gereja terbesar di dunia, lalu masjid kekaisaran Ottoman; kubah raksasanya dianggap mahakarya arsitektur Bizantium dan kini berfungsi sebagai masjid dengan area kunjungan wisata.'],
            ['Kapadokia', 'Göreme', 'Turki', 'Wisata Alam', 0, 38.6400, 34.8289, 'kapadokia.jpg', 'Lembah batu vulkanik di Anatolia tengah dengan formasi cerobong peri, rumah dan gereja gua kuno, serta pemandangan puluhan balon udara yang beterbangan saat matahari terbit di atas Göreme.'],
            ['Grand Bazaar', 'Istanbul', 'Turki', 'Wisata Budaya', 0, 41.0106, 28.9680, 'grand-bazaar.jpg', 'Salah satu pasar tertutup tertua dan terbesar di dunia, dibuka tahun 1461, dengan lebih dari 4.000 toko di 60-an lorong beratap di Istanbul — menjual karpet, lampu mozaik, keramik, hingga perhiasan.'],
        ];

        foreach ($rows as [$name, $city, $country, $category, $fee, $lat, $lng, $file, $description]) {
            $destination = Destination::updateOrCreate(
                ['name' => $name],
                [
                    'category_id' => $categories[$category] ?? null,
                    'description' => $description,
                    'city' => $city,
                    'country' => $country,
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'entrance_fee' => $fee,
                ]
            );

            if (Storage::disk('public')->exists('destinations/' . $file)) {
                $destination->photo = 'destinations/' . $file;
                $destination->save();
                $this->command?->info("Foto terpasang: {$name}");
            } else {
                $this->command?->warn("File foto belum ada di storage, dilewati: {$file}");
            }
        }

        $this->command?->info('Tambahan Turki selesai. Total destinasi: ' . Destination::count());
    }
}
