<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $destinations = [
            // ---------- Indonesia ----------
            ['category' => 'Sejarah', 'name' => 'Monumen Nasional (Monas)', 'country' => 'Indonesia', 'city' => 'Jakarta', 'description' => 'Monumen setinggi 132 meter yang menjadi ikon Jakarta, dengan museum sejarah dan pelataran puncak untuk melihat panorama kota.', 'address' => 'Gambir, Jakarta Pusat', 'latitude' => -6.1753924, 'longitude' => 106.8271528, 'entrance_fee' => 20000],
            ['category' => 'Budaya', 'name' => 'Candi Borobudur', 'country' => 'Indonesia', 'city' => 'Magelang', 'description' => 'Candi Buddha terbesar di dunia dari abad ke-9 dengan relief dan stupa yang menjadi Warisan Dunia UNESCO.', 'address' => 'Borobudur, Magelang, Jawa Tengah', 'latitude' => -7.6078738, 'longitude' => 110.2037512, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Pantai Kuta', 'country' => 'Indonesia', 'city' => 'Bali', 'description' => 'Pantai populer di Bali dengan ombak ramah untuk belajar selancar dan pemandangan matahari terbenam yang terkenal.', 'address' => 'Kuta, Badung, Bali', 'latitude' => -8.7183798, 'longitude' => 115.1693405, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Kawah Ijen', 'country' => 'Indonesia', 'city' => 'Banyuwangi', 'description' => 'Kawah vulkanik dengan danau asam berwarna toska dan fenomena api biru yang langka di malam hari.', 'address' => 'Licin, Banyuwangi, Jawa Timur', 'latitude' => -8.0583818, 'longitude' => 114.2429059, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Gunung Bromo', 'country' => 'Indonesia', 'city' => 'Probolinggo', 'description' => 'Gunung berapi aktif di kaldera Tengger yang terkenal dengan pemandangan matahari terbit di atas lautan pasir.', 'address' => 'Taman Nasional Bromo Tengger Semeru, Jawa Timur', 'latitude' => -7.9425, 'longitude' => 112.953, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Candi Prambanan', 'country' => 'Indonesia', 'city' => 'Yogyakarta', 'description' => 'Kompleks candi Hindu terbesar di Indonesia dari abad ke-9 dengan menara-menara tinggi yang menjulang anggun.', 'address' => 'Prambanan, Sleman, Daerah Istimewa Yogyakarta', 'latitude' => -7.752, 'longitude' => 110.4915, 'entrance_fee' => 50000],
            ['category' => 'Wisata Alam', 'name' => 'Danau Toba', 'country' => 'Indonesia', 'city' => 'Parapat', 'description' => 'Danau vulkanik terbesar di dunia dengan Pulau Samosir di tengahnya dan budaya Batak yang kental.', 'address' => 'Parapat, Simalungun, Sumatera Utara', 'latitude' => 2.6631, 'longitude' => 98.9307, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Pulau Padar', 'country' => 'Indonesia', 'city' => 'Labuan Bajo', 'description' => 'Pulau di Taman Nasional Komodo dengan bukit pandang terkenal ke arah tiga teluk berwarna berbeda.', 'address' => 'Taman Nasional Komodo, Nusa Tenggara Timur', 'latitude' => -8.6533, 'longitude' => 119.5753, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Gili Trawangan', 'country' => 'Indonesia', 'city' => 'Lombok', 'description' => 'Pulau kecil bebas kendaraan bermotor dengan air jernih, snorkeling bersama penyu, dan suasana santai.', 'address' => 'Gili Indah, Lombok Utara, Nusa Tenggara Barat', 'latitude' => -8.3507, 'longitude' => 116.0498, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Raja Ampat', 'country' => 'Indonesia', 'city' => 'Waisai', 'description' => 'Kepulauan dengan keanekaragaman hayati laut terkaya di dunia dan gugusan pulau karst yang memukau.', 'address' => 'Waisai, Raja Ampat, Papua Barat Daya', 'latitude' => -0.4289, 'longitude' => 130.8278, 'entrance_fee' => null],

            // ---------- Jepang ----------
            ['category' => 'Hiburan', 'name' => 'Tokyo Tower', 'country' => 'Jepang', 'city' => 'Tokyo', 'description' => 'Menara komunikasi berwarna oranye setinggi 333 meter yang menjadi salah satu simbol kota Tokyo.', 'address' => 'Minato, Tokyo', 'latitude' => 35.6585805, 'longitude' => 139.7454329, 'entrance_fee' => 1200],
            ['category' => 'Religi', 'name' => 'Fushimi Inari Taisha', 'country' => 'Jepang', 'city' => 'Kyoto', 'description' => 'Kuil Shinto terkenal dengan ribuan gerbang torii merah yang membentuk terowongan menaiki gunung Inari.', 'address' => 'Fushimi, Kyoto', 'latitude' => 34.9676944, 'longitude' => 135.7726836, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Kastil Osaka', 'country' => 'Jepang', 'city' => 'Osaka', 'description' => 'Kastil bersejarah dari abad ke-16 dengan museum di dalamnya dan taman luas yang ramai saat musim sakura.', 'address' => 'Chuo, Osaka', 'latitude' => 34.6873, 'longitude' => 135.5259, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Pagoda Chureito dan Gunung Fuji', 'country' => 'Jepang', 'city' => 'Fujiyoshida', 'description' => 'Pagoda lima tingkat dengan latar Gunung Fuji yang menjadi salah satu sudut foto paling ikonik di Jepang.', 'address' => 'Fujiyoshida, Yamanashi', 'latitude' => 35.5015, 'longitude' => 138.8015, 'entrance_fee' => null],

            // ---------- Korea Selatan ----------
            ['category' => 'Sejarah', 'name' => 'Istana Gyeongbokgung', 'country' => 'Korea Selatan', 'city' => 'Seoul', 'description' => 'Istana utama Dinasti Joseon dengan arsitektur megah dan upacara pergantian penjaga yang bisa disaksikan pengunjung.', 'address' => 'Jongno, Seoul', 'latitude' => 37.579617, 'longitude' => 126.977041, 'entrance_fee' => 3000],
            ['category' => 'Hiburan', 'name' => 'N Seoul Tower', 'country' => 'Korea Selatan', 'city' => 'Seoul', 'description' => 'Menara observasi di puncak Gunung Namsan dengan panorama kota Seoul dan area gembok cinta yang populer.', 'address' => 'Yongsan, Seoul', 'latitude' => 37.5512, 'longitude' => 126.9882, 'entrance_fee' => null],
            ['category' => 'Budaya', 'name' => 'Desa Budaya Gamcheon', 'country' => 'Korea Selatan', 'city' => 'Busan', 'description' => 'Permukiman lereng bukit penuh rumah warna-warni, mural, dan gang seni yang dijuluki Santorini-nya Korea.', 'address' => 'Saha, Busan', 'latitude' => 35.0975, 'longitude' => 129.0106, 'entrance_fee' => null],

            // ---------- Malaysia & Singapura ----------
            ['category' => 'Hiburan', 'name' => 'Menara Kembar Petronas', 'country' => 'Malaysia', 'city' => 'Kuala Lumpur', 'description' => 'Menara kembar setinggi 452 meter dengan jembatan langit dan dek observasi, ikon modern Malaysia.', 'address' => 'Kuala Lumpur City Centre, Kuala Lumpur', 'latitude' => 3.1578421, 'longitude' => 101.7118014, 'entrance_fee' => null],
            ['category' => 'Religi', 'name' => 'Batu Caves', 'country' => 'Malaysia', 'city' => 'Selangor', 'description' => 'Kompleks gua dan kuil Hindu di bukit kapur dengan patung Murugan raksasa dan 272 anak tangga berwarna.', 'address' => 'Gombak, Selangor', 'latitude' => 3.2379, 'longitude' => 101.6839, 'entrance_fee' => null],
            ['category' => 'Budaya', 'name' => 'Merlion Park', 'country' => 'Singapura', 'city' => 'Singapura', 'description' => 'Taman tepi teluk dengan patung Merlion, ikon Singapura, berlatar Marina Bay dan gedung-gedung pusat kota.', 'address' => 'Marina Bay, Singapura', 'latitude' => 1.2868, 'longitude' => 103.8545, 'entrance_fee' => null],
            ['category' => 'Hiburan', 'name' => 'Gardens by the Bay', 'country' => 'Singapura', 'city' => 'Singapura', 'description' => 'Taman futuristik dengan Supertree raksasa dan rumah kaca berbentuk kubah di tepi Marina Bay.', 'address' => 'Marina Bay, Singapura', 'latitude' => 1.2816, 'longitude' => 103.8636, 'entrance_fee' => null],

            // ---------- Thailand, Vietnam, Filipina, Tiongkok ----------
            ['category' => 'Budaya', 'name' => 'Grand Palace', 'country' => 'Thailand', 'city' => 'Bangkok', 'description' => 'Kompleks istana kerajaan Thailand dengan Wat Phra Kaew yang menyimpan Buddha Zamrud yang dihormati.', 'address' => 'Phra Nakhon, Bangkok', 'latitude' => 13.7500415, 'longitude' => 100.4912615, 'entrance_fee' => 500],
            ['category' => 'Religi', 'name' => 'Wat Arun', 'country' => 'Thailand', 'city' => 'Bangkok', 'description' => 'Kuil Fajar di tepi Sungai Chao Phraya dengan menara berhiaskan porselen yang berkilau saat matahari terbit dan terbenam.', 'address' => 'Bangkok Yai, Bangkok', 'latitude' => 13.7437, 'longitude' => 100.4889, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'Ha Long Bay', 'country' => 'Vietnam', 'city' => 'Quang Ninh', 'description' => 'Teluk Warisan Dunia UNESCO dengan ribuan pulau kapur menjulang dari perairan hijau zamrud.', 'address' => 'Ha Long, Quang Ninh', 'latitude' => 20.9101, 'longitude' => 107.1839, 'entrance_fee' => null],
            ['category' => 'Wisata Alam', 'name' => 'El Nido', 'country' => 'Filipina', 'city' => 'Palawan', 'description' => 'Kawasan laguna dan tebing kapur dengan air sebening kaca yang sering disebut surga tropis Filipina.', 'address' => 'El Nido, Palawan', 'latitude' => 11.1795, 'longitude' => 119.3921, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Tembok Besar Mutianyu', 'country' => 'Tiongkok', 'city' => 'Beijing', 'description' => 'Salah satu ruas Tembok Besar Tiongkok yang terawat baik, membentang hijau di punggungan pegunungan dekat Beijing.', 'address' => 'Huairou, Beijing', 'latitude' => 40.4319, 'longitude' => 116.5704, 'entrance_fee' => null],

            // ---------- Eropa, Timur Tengah, Australia ----------
            ['category' => 'Sejarah', 'name' => 'Menara Eiffel', 'country' => 'Prancis', 'city' => 'Paris', 'description' => 'Menara besi setinggi 330 meter dari tahun 1889 yang menjadi simbol Paris dan Prancis di seluruh dunia.', 'address' => 'Champ de Mars, Paris', 'latitude' => 48.8584, 'longitude' => 2.2945, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Big Ben dan Istana Westminster', 'country' => 'Inggris', 'city' => 'London', 'description' => 'Menara jam dan gedung parlemen bergaya gotik di tepi Sungai Thames yang menjadi ikon kota London.', 'address' => 'Westminster, London', 'latitude' => 51.5007, 'longitude' => -0.1246, 'entrance_fee' => null],
            ['category' => 'Sejarah', 'name' => 'Colosseum', 'country' => 'Italia', 'city' => 'Roma', 'description' => 'Amfiteater raksasa peninggalan Kekaisaran Romawi yang menjadi saksi sejarah gladiator dan simbol kota Roma.', 'address' => 'Piazza del Colosseo, Roma', 'latitude' => 41.8902, 'longitude' => 12.4922, 'entrance_fee' => null],
            ['category' => 'Hiburan', 'name' => 'Burj Khalifa', 'country' => 'Uni Emirat Arab', 'city' => 'Dubai', 'description' => 'Gedung tertinggi di dunia setinggi 828 meter dengan dek observasi dan air mancur menari di kakinya.', 'address' => 'Downtown Dubai, Dubai', 'latitude' => 25.1972, 'longitude' => 55.2744, 'entrance_fee' => null],
            ['category' => 'Budaya', 'name' => 'Sydney Opera House', 'country' => 'Australia', 'city' => 'Sydney', 'description' => 'Gedung pertunjukan berbentuk cangkang layar di tepi pelabuhan Sydney dan Warisan Dunia UNESCO.', 'address' => 'Bennelong Point, Sydney', 'latitude' => -33.8568, 'longitude' => 151.2153, 'entrance_fee' => null],
        ];

        foreach ($destinations as $data) {
            $categoryName = $data['category'];
            unset($data['category']);
            $data['category_id'] = $categories[$categoryName] ?? null;

            Destination::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
