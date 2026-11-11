<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Ekspansi dunia: 10 destinasi — 5 dari negara mayoritas Muslim dan
 * 5 dari negara mayoritas non-Muslim (total menjadi 73).
 *
 * Biaya masuk adalah tarif standar dewasa yang terpublikasi dalam mata
 * uang lokal negara setempat (0 = gratis, misalnya masjid yang memang
 * tidak memungut tiket masuk). Foto menempel otomatis bila file-nya ada
 * di storage/app/public/destinations. Aman dijalankan ulang.
 */
class WorldDestinationsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        // [nama, kota, negara, kategori, biaya masuk (mata uang lokal), lat, lng, file foto, deskripsi]
        $rows = [
            // --- Negara mayoritas Muslim ---
            ['Masjid Biru', 'Istanbul', 'Turki', 'Wisata Religi', 0, 41.0054, 28.9768, 'masjid-biru.jpg', 'Masjid kekaisaran Ottoman abad ke-17 di Istanbul yang dijuluki Masjid Biru karena lebih dari 20.000 keping ubin Iznik biru menghiasi interiornya; masih aktif digunakan untuk beribadah hingga kini.'],
            ['Masjid Agung Sheikh Zayed', 'Abu Dhabi', 'Uni Emirat Arab', 'Wisata Religi', 0, 24.4129, 54.4749, 'sheikh-zayed.jpg', 'Masjid terbesar di Uni Emirat Arab dengan 82 kubah marmer putih, salah satu karpet tenun tangan terbesar di dunia, dan lampu gantung kristal raksasa; terbuka bagi wisatawan melalui tur berpemandu gratis.'],
            ['Museum Seni Islam Doha', 'Doha', 'Qatar', 'Wisata Edukasi', 50, 25.2953, 51.5392, 'museum-doha.jpg', 'Museum rancangan arsitek I. M. Pei di pulau buatan tepi Teluk Doha yang menyimpan koleksi seni Islam dari 14 abad — keramik, manuskrip, dan perhiasan dari tiga benua.'],
            ['Hegra AlUla', 'AlUla', 'Arab Saudi', 'Wisata Sejarah', 95, 26.8143, 37.9472, 'hegra.jpg', 'Situs Warisan Dunia UNESCO pertama di Arab Saudi: kota kuno bangsa Nabatea sekelas Petra, dengan makam-makam monumental yang dipahat pada tebing batu pasir di gurun AlUla.'],
            ['Masjid Hassan II', 'Casablanca', 'Maroko', 'Wisata Religi', 80, 33.6083, -7.6328, 'hassan-ii.jpg', 'Masjid terbesar di Afrika dengan menara setinggi 210 meter — tertinggi di dunia — yang berdiri menjorok ke Samudra Atlantik di Casablanca; sebagian lantainya terbuat dari kaca di atas air laut.'],
            // --- Negara mayoritas non-Muslim ---
            ['Machu Picchu', 'Cusco', 'Peru', 'Wisata Sejarah', 152, -13.1631, -72.5450, 'machu-picchu.jpg', 'Kota batu bangsa Inca dari abad ke-15 di pegunungan Andes pada ketinggian sekitar 2.430 meter; Warisan Dunia UNESCO dan salah satu Tujuh Keajaiban Dunia modern.'],
            ['Kristus Penebus', 'Rio de Janeiro', 'Brasil', 'Wisata Religi', 122, -22.9519, -43.2105, 'kristus-penebus.jpg', 'Patung Yesus setinggi 38 meter dengan tangan terentang di puncak Gunung Corcovado yang memandang Kota Rio de Janeiro; ikon Brasil dan salah satu Tujuh Keajaiban Dunia modern.'],
            ['Matterhorn', 'Zermatt', 'Swiss', 'Wisata Alam', 0, 45.9763, 7.6585, 'matterhorn.jpg', 'Gunung berbentuk piramida setinggi 4.478 meter di perbatasan Swiss dan Italia, salah satu puncak paling dikenali di dunia; desa Zermatt di kakinya bebas kendaraan bermotor.'],
            ['Milford Sound', 'Fiordland', 'Selandia Baru', 'Wisata Alam', 0, -44.6414, 167.8974, 'milford-sound.jpg', 'Fjord megah di Taman Nasional Fiordland dengan tebing curam yang menjulang dari air, air terjun Stirling, dan air berwarna gelap kehijauan; sering disebut keajaiban dunia kedelapan.'],
            ['Gunung Meja', 'Cape Town', 'Afrika Selatan', 'Wisata Alam', 395, -33.9628, 18.4098, 'gunung-meja.jpg', 'Gunung berpuncak datar setinggi 1.085 meter yang menjadi latar ikonik Cape Town; puncaknya dapat dicapai dengan kereta gantung yang lantainya berputar atau lewat jalur pendakian.'],
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

        $this->command?->info('Ekspansi dunia selesai. Total destinasi: ' . Destination::count());
    }
}
