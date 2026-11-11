<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Ekspansi destinasi Asia Tenggara: 12 tempat (total menjadi 63).
 * Singapura ditambah 3 (Marina Bay Sands, Singapore Flyer, Singapore Zoo),
 * Malaysia +2, Thailand +2, Vietnam +2, Filipina +1, dan dua negara baru:
 * Myanmar (Bagan) dan Laos (Air Terjun Kuang Si).
 *
 * Biaya masuk adalah tarif standar dewasa yang terpublikasi dalam mata
 * uang lokal negara setempat (0 = gratis). Foto menempel otomatis bila
 * file-nya ada di storage/app/public/destinations (satu paket dengan
 * seeder ini). Aman dijalankan ulang: updateOrCreate berdasarkan nama.
 */
class SoutheastAsiaDestinationSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        // [nama, kota, negara, kategori, biaya masuk (mata uang lokal), lat, lng, file foto, deskripsi]
        $rows = [
            ['Marina Bay Sands', 'Singapura', 'Singapura', 'Wisata Hiburan', 32, 1.2836, 103.8607, 'marina-bay-sands.jpg', 'Kompleks resor ikonik dengan tiga menara yang dihubungkan struktur mirip kapal raksasa di puncaknya; dek observasi SkyPark-nya menyajikan panorama teluk dan kota Singapura.'],
            ['Singapore Flyer', 'Singapura', 'Singapura', 'Wisata Hiburan', 40, 1.2893, 103.8631, 'singapore-flyer.jpg', 'Bianglala observasi raksasa setinggi 165 meter; satu putaran kapsulnya selama kurang lebih 30 menit menampilkan pemandangan Marina Bay hingga ke selat.'],
            ['Singapore Zoo', 'Singapura', 'Singapura', 'Wisata Edukasi', 48, 1.4043, 103.7930, 'singapore-zoo.jpg', 'Kebun binatang berkonsep terbuka di tengah hutan Mandai yang menampung ribuan satwa; terkenal dengan kandang alami tanpa pagar kawat dan pertunjukan satwanya.'],
            ['Menara Kuala Lumpur', 'Kuala Lumpur', 'Malaysia', 'Wisata Hiburan', 49, 3.1528, 101.7038, 'menara-kuala-lumpur.jpg', 'Menara telekomunikasi setinggi 421 meter di Bukit Nanas dengan dek observasi dan kotak kaca Sky Box untuk melihat Kuala Lumpur dari ketinggian.'],
            ['Pulau Langkawi', 'Langkawi', 'Malaysia', 'Wisata Alam', 0, 6.3500, 99.8000, 'pulau-langkawi.jpg', 'Kepulauan bebas bea di Laut Andaman yang terkenal dengan Jembatan Langit (Sky Bridge) melengkung di Gunung Mat Cincang dan kereta gantungnya yang curam.'],
            ['Wat Pho', 'Bangkok', 'Thailand', 'Wisata Religi', 300, 13.7466, 100.4927, 'wat-pho.jpg', 'Kompleks kuil Buddha terbesar di Bangkok yang menyimpan patung Buddha Berbaring sepanjang 46 meter berlapis emas dan sekolah pijat tradisional Thailand pertama.'],
            ['Kepulauan Phi Phi', 'Krabi', 'Thailand', 'Wisata Alam', 400, 7.7407, 98.7784, 'kepulauan-phi-phi.jpg', 'Gugusan pulau karst di Laut Andaman dengan Teluk Maya berair turkuois yang dikelilingi tebing kapur menjulang — lokasi film The Beach.'],
            ['Kota Tua Hoi An', 'Hoi An', 'Vietnam', 'Wisata Sejarah', 120000, 15.8801, 108.3380, 'hoi-an.jpg', 'Kota pelabuhan kuno Warisan Dunia UNESCO dengan rumah-rumah kuning berlampion warna-warni di tepi Sungai Thu Bon, paling ramai dan romantis saat malam hari.'],
            ['Terowongan Cu Chi', 'Ho Chi Minh', 'Vietnam', 'Wisata Sejarah', 125000, 11.0619, 106.5267, 'cu-chi.jpg', 'Jaringan terowongan bawah tanah sepanjang lebih dari 250 kilometer peninggalan masa Perang Vietnam; pengunjung dapat mencoba merangkak masuk ke sebagian rutenya.'],
            ['Chocolate Hills', 'Bohol', 'Filipina', 'Wisata Alam', 100, 9.8297, 124.1399, 'chocolate-hills.jpg', 'Lebih dari 1.200 bukit kapur berbentuk kerucut seragam yang berubah warna menjadi cokelat saat musim kemarau hingga tampak seperti deretan cokelat raksasa.'],
            ['Bagan', 'Bagan', 'Myanmar', 'Wisata Sejarah', 25000, 21.1717, 94.8585, 'bagan.jpg', 'Dataran kuno di tepi Sungai Irrawaddy dengan lebih dari 2.000 candi dan pagoda Buddha dari abad ke-11 hingga ke-13; terkenal dengan pemandangan matahari terbit berkabut.'],
            ['Air Terjun Kuang Si', 'Luang Prabang', 'Laos', 'Wisata Alam', 25000, 19.7494, 101.9920, 'kuang-si.jpg', 'Air terjun bertingkat dengan kolam-kolam alami berwarna turkuois di tengah hutan dekat Luang Prabang; pengunjung dapat berenang di kolam bagian bawahnya.'],
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

        $this->command?->info('Ekspansi Asia Tenggara selesai. Total destinasi: ' . Destination::count());
    }
}
