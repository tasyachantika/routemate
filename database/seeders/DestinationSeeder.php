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
            [
                'category' => 'Wisata Sejarah', 'name' => 'Monumen Nasional (Monas)',
                'country' => 'Indonesia', 'city' => 'Jakarta',
                'description' => 'Monumen ikonik setinggi 132 meter, simbol kemerdekaan Indonesia.',
                'address' => 'Gambir, Jakarta Pusat',
                'latitude' => -6.1753924, 'longitude' => 106.8271528, 'entrance_fee' => 20000,
            ],
            [
                'category' => 'Wisata Sejarah', 'name' => 'Candi Borobudur',
                'country' => 'Indonesia', 'city' => 'Magelang',
                'description' => 'Candi Buddha terbesar di dunia, warisan budaya UNESCO.',
                'address' => 'Borobudur, Magelang, Jawa Tengah',
                'latitude' => -7.6078738, 'longitude' => 110.2037513, 'entrance_fee' => 50000,
            ],
            [
                'category' => 'Wisata Alam', 'name' => 'Pantai Kuta',
                'country' => 'Indonesia', 'city' => 'Bali',
                'description' => 'Pantai terkenal di Bali dengan pemandangan matahari terbenam.',
                'address' => 'Kuta, Kabupaten Badung, Bali',
                'latitude' => -8.7184118, 'longitude' => 115.1692986, 'entrance_fee' => null,
            ],
            [
                'category' => 'Wisata Alam', 'name' => 'Kawah Ijen',
                'country' => 'Indonesia', 'city' => 'Banyuwangi',
                'description' => 'Kawah vulkanik dengan danau asam dan fenomena api biru.',
                'address' => 'Banyuwangi, Jawa Timur',
                'latitude' => -8.0582115, 'longitude' => 114.2426595, 'entrance_fee' => 100000,
            ],
            [
                'category' => 'Wisata Hiburan', 'name' => 'Tokyo Tower',
                'country' => 'Jepang', 'city' => 'Tokyo',
                'description' => 'Menara komunikasi dan observasi ikonik di Tokyo.',
                'address' => 'Minato, Tokyo',
                'latitude' => 35.6585805, 'longitude' => 139.7454329, 'entrance_fee' => 1200,
            ],
            [
                'category' => 'Wisata Budaya', 'name' => 'Fushimi Inari Taisha',
                'country' => 'Jepang', 'city' => 'Kyoto',
                'description' => 'Kuil Shinto terkenal dengan ribuan gerbang torii berwarna merah.',
                'address' => 'Fushimi, Kyoto',
                'latitude' => 34.9671402, 'longitude' => 135.7726830, 'entrance_fee' => null,
            ],
            [
                'category' => 'Wisata Sejarah', 'name' => 'Gyeongbokgung Palace',
                'country' => 'Korea Selatan', 'city' => 'Seoul',
                'description' => 'Istana utama Dinasti Joseon, terbesar di antara lima istana di Seoul.',
                'address' => 'Jongno, Seoul',
                'latitude' => 37.5796170, 'longitude' => 126.9770410, 'entrance_fee' => 3000,
            ],
            [
                'category' => 'Wisata Hiburan', 'name' => 'Petronas Twin Towers',
                'country' => 'Malaysia', 'city' => 'Kuala Lumpur',
                'description' => 'Menara kembar ikonik Malaysia dengan jembatan penghubung di ketinggian.',
                'address' => 'Kuala Lumpur City Centre',
                'latitude' => 3.1578850, 'longitude' => 101.7116010, 'entrance_fee' => 98,
            ],
            [
                'category' => 'Wisata Hiburan', 'name' => 'Merlion Park',
                'country' => 'Singapura', 'city' => 'Singapura',
                'description' => 'Taman dengan patung Merlion, simbol negara Singapura.',
                'address' => 'Marina Bay, Singapura',
                'latitude' => 1.2868000, 'longitude' => 103.8545000, 'entrance_fee' => null,
            ],
            [
                'category' => 'Wisata Sejarah', 'name' => 'Grand Palace Bangkok',
                'country' => 'Thailand', 'city' => 'Bangkok',
                'description' => 'Kompleks istana bersejarah, bekas kediaman raja Thailand.',
                'address' => 'Phra Nakhon, Bangkok',
                'latitude' => 13.7500000, 'longitude' => 100.4913000, 'entrance_fee' => 500,
            ],
        ];

        foreach ($destinations as $data) {
            Destination::updateOrCreate(
                ['name' => $data['name'], 'country' => $data['country']],
                [
                    'category_id' => $categories[$data['category']] ?? null,
                    'city' => $data['city'],
                    'description' => $data['description'],
                    'address' => $data['address'],
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'entrance_fee' => $data['entrance_fee'],
                ]
            );
        }
    }
}
