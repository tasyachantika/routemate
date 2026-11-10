<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class FamousDestinationSeeder extends Seeder
{
    /**
     * Batch tambahan: tempat-tempat terkenal Indonesia dan dunia.
     * Aman dijalankan ulang: updateOrCreate berdasarkan nama.
     * Tidak menyentuh kolom photo (foto dipasang DestinationPhotoSeeder).
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $destinations = [
            // ---------- Indonesia ----------
            ['category' => 'Wisata Alam', 'name' => 'Gunung Rinjani', 'country' => 'Indonesia', 'city' => 'Lombok', 'description' => 'Gunung berapi tertinggi kedua di Indonesia dengan kaldera dan Danau Segara Anak yang memukau di dekat puncaknya.', 'address' => 'Sembalun, Lombok Timur, Nusa Tenggara Barat', 'latitude' => -8.4113, 'longitude' => 116.4573, 'entrance_fee' => null],
            ['category' => 'Edukasi', 'name' => 'Museum Nasional Indonesia', 'country' => 'Indonesia', 'city' => 'Jakarta', 'description' => 'Museum terbesar di Indonesia dengan koleksi arca, prasasti, dan benda bersejarah dari seluruh nusantara; dikenal juga sebagai Museum Gajah.', 'address' => 'Jl. Medan Merdeka Barat, Jakarta Pusat', 'latitude' => -6.1761, 'longitude' => 106.8219, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Pantai Pink', 'country' => 'Indonesia', 'city' => 'Labuan Bajo', 'description' => 'Pantai langka berpasir merah muda di kawasan Taman Nasional Komodo, salah satu dari sedikit pantai berpasir pink di dunia.', 'address' => 'Pulau Komodo, Manggarai Barat, Nusa Tenggara Timur', 'latitude' => -8.5936, 'longitude' => 119.4847, 'entrance_fee' => null],
            ['category' => 'Religi', 'name' => 'Tanah Lot', 'country' => 'Indonesia', 'city' => 'Bali', 'description' => 'Pura di atas batu karang di tepi laut yang menjadi ikon wisata Bali, terutama menjelang matahari terbenam.', 'address' => 'Beraban, Tabanan, Bali', 'latitude' => -8.6213, 'longitude' => 115.0868, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Kawah Putih', 'country' => 'Indonesia', 'city' => 'Bandung', 'description' => 'Danau kawah berwarna putih kehijauan di Ciwidey dari letusan Gunung Patuha, berkabut dan sangat fotogenik.', 'address' => 'Ciwidey, Kabupaten Bandung, Jawa Barat', 'latitude' => -7.1662, 'longitude' => 107.3998, 'entrance_fee' => null],

            // ---------- Taman hiburan & tempat wisata dunia ----------
            ['category' => 'Hiburan', 'name' => 'Tokyo Disneyland', 'country' => 'Jepang', 'city' => 'Urayasu', 'description' => 'Taman hiburan Disney pertama di Asia dengan kastil Cinderella dan wahana ikonik untuk semua usia.', 'address' => 'Maihama, Urayasu, Chiba', 'latitude' => 35.6329, 'longitude' => 139.8804, 'entrance_fee' => null],
            ['category' => 'Hiburan', 'name' => 'Disneyland Paris', 'country' => 'Prancis', 'city' => 'Marne-la-Vallée', 'description' => 'Resor Disney satu-satunya di Eropa dengan kastil Sleeping Beauty dan dua taman hiburan.', 'address' => 'Marne-la-Vallée, Île-de-France', 'latitude' => 48.8674, 'longitude' => 2.7834, 'entrance_fee' => null],
            ['category' => 'Hiburan', 'name' => 'Disneyland California', 'country' => 'Amerika Serikat', 'city' => 'Anaheim', 'description' => 'Taman Disneyland pertama di dunia yang dibuka Walt Disney pada tahun 1955, dengan kastil Sleeping Beauty yang ikonik.', 'address' => 'Anaheim, California', 'latitude' => 33.8121, 'longitude' => -117.919, 'entrance_fee' => null],
            ['category' => 'Hiburan', 'name' => 'Universal Studios Singapore', 'country' => 'Singapura', 'city' => 'Singapura', 'description' => 'Taman hiburan bertema film di Pulau Sentosa dengan wahana dari film-film populer Universal.', 'address' => 'Resorts World Sentosa, Singapura', 'latitude' => 1.254, 'longitude' => 103.8238, 'entrance_fee' => null],

            // ---------- Museum & situs sejarah dunia ----------
            ['category' => 'Edukasi', 'name' => 'Museum Louvre', 'country' => 'Prancis', 'city' => 'Paris', 'description' => 'Museum seni terbesar dan paling banyak dikunjungi di dunia, rumah bagi lukisan Mona Lisa, dengan piramida kaca ikoniknya.', 'address' => 'Rue de Rivoli, Paris', 'latitude' => 48.8606, 'longitude' => 2.3376, 'entrance_fee' => null],
            ['category' => 'Edukasi', 'name' => 'British Museum', 'country' => 'Inggris', 'city' => 'London', 'description' => 'Museum sejarah dan budaya manusia dengan koleksi jutaan artefak dari seluruh peradaban dunia; masuknya gratis.', 'address' => 'Great Russell Street, London', 'latitude' => 51.5194, 'longitude' => -0.127, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Piramida Agung Giza', 'country' => 'Mesir', 'city' => 'Giza', 'description' => 'Satu-satunya keajaiban dunia kuno yang masih berdiri: makam Raja Khufu berusia lebih dari 4.500 tahun di tepi Kairo.', 'address' => 'Al Haram, Giza', 'latitude' => 29.9792, 'longitude' => 31.1342, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Taj Mahal', 'country' => 'India', 'city' => 'Agra', 'description' => 'Mausoleum marmer putih peninggalan Kekaisaran Mughal yang disebut permata seni Islam dan Warisan Dunia UNESCO.', 'address' => 'Agra, Uttar Pradesh', 'latitude' => 27.1751, 'longitude' => 78.0421, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Patung Liberty', 'country' => 'Amerika Serikat', 'city' => 'New York', 'description' => 'Patung hadiah dari Prancis yang menjadi simbol kebebasan dan gerbang selamat datang di Pelabuhan New York.', 'address' => 'Liberty Island, New York', 'latitude' => 40.6892, 'longitude' => -74.0445, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Menara Miring Pisa', 'country' => 'Italia', 'city' => 'Pisa', 'description' => 'Menara lonceng katedral Pisa yang miring akibat tanah lunak; ikon Italia dan Warisan Dunia UNESCO.', 'address' => 'Piazza dei Miracoli, Pisa', 'latitude' => 43.723, 'longitude' => 10.3966, 'entrance_fee' => null],
            ['category' => 'Budaya', 'name' => 'Sagrada Familia', 'country' => 'Spanyol', 'city' => 'Barcelona', 'description' => 'Basilika rancangan Antoni Gaudí yang dibangun sejak 1882 dan masih berlanjut; mahakarya arsitektur modernisme Katalan.', 'address' => 'Eixample, Barcelona', 'latitude' => 41.4036, 'longitude' => 2.1744, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Angkor Wat', 'country' => 'Kamboja', 'city' => 'Siem Reap', 'description' => 'Kompleks candi terbesar di dunia peninggalan Kekaisaran Khmer abad ke-12 dan simbol nasional Kamboja.', 'address' => 'Angkor, Siem Reap', 'latitude' => 13.4125, 'longitude' => 103.867, 'entrance_fee' => null],

            // ---------- Alam terkenal dunia ----------
            ['category' => 'Wisata Alam', 'name' => 'Santorini', 'country' => 'Yunani', 'city' => 'Oia', 'description' => 'Pulau vulkanik di Laut Aegea dengan desa Oia berdinding putih dan kubah biru di tebing kaldera; terkenal untuk matahari terbenam.', 'address' => 'Oia, Santorini', 'latitude' => 36.4618, 'longitude' => 25.3753, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Air Terjun Niagara', 'country' => 'Kanada', 'city' => 'Niagara Falls', 'description' => 'Kelompok air terjun raksasa di perbatasan Kanada dan Amerika Serikat, salah satu air terjun paling terkenal di dunia.', 'address' => 'Niagara Falls, Ontario', 'latitude' => 43.0962, 'longitude' => -79.0377, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Pantai Waikiki', 'country' => 'Amerika Serikat', 'city' => 'Honolulu', 'description' => 'Pantai paling terkenal di Hawaii dengan latar Diamond Head, pusat selancar dan wisata kota Honolulu.', 'address' => 'Waikiki, Honolulu, Hawaii', 'latitude' => 21.2793, 'longitude' => -157.8292, 'entrance_fee' => null],
        ];

        foreach ($destinations as $data) {
            $categoryName = $data['category'];
            unset($data['category']);
            $data['category_id'] = $categories[$categoryName] ?? null;

            Destination::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
