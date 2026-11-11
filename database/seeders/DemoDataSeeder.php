<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Data contoh (dummy) BESAR untuk demonstrasi & screenshot laporan:
 * - 4 trip untuk akun user demo utama (dari .env DEMO_USER_EMAIL).
 * - 5 akun user dummy (@routemate.test, password semuanya: password)
 *   masing-masing dengan 2 trip berisi itinerary + anggaran.
 *
 * Aman dijalankan berulang: hanya menghapus & membuat ulang trip dengan
 * judul persis milik seeder ini pada akun-akun di atas; data lain tidak
 * disentuh. Seluruhnya data contoh, bukan data asli.
 */
class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $demoUser = null;
        if (env('DEMO_USER_EMAIL')) {
            $demoUser = User::where('email', env('DEMO_USER_EMAIL'))->first();
        }
        $demoUser ??= User::where('role', 'user')->orderBy('id')->first();

        if ($demoUser) {
            $this->seedTrips($demoUser, $this->mainDemoTrips());
        } else {
            $this->command?->warn('Akun user demo utama tidak ditemukan; bagian itu dilewati.');
        }

        foreach ($this->dummyUsers() as $info) {
            $user = User::updateOrCreate(
                ['email' => $info['email']],
                [
                    'name' => $info['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );
            $this->seedTrips($user, $info['trips']);
            $this->command?->info("Akun dummy siap: {$info['email']} (password: password)");
        }
    }

    private function seedTrips(User $user, array $trips): void
    {
        Trip::where('user_id', $user->id)
            ->whereIn('title', array_column($trips, 'title'))
            ->delete();

        foreach ($trips as $data) {
            $details = $data['details'];
            $budgets = $data['budgets'];
            unset($data['details'], $data['budgets']);

            $trip = new Trip($data);
            $trip->user_id = $user->id;
            $trip->save();

            $sort = 1;
            foreach ($details as [$name, $date, $time]) {
                $destination = Destination::where('name', $name)->first();
                if (! $destination) {
                    $this->command?->warn("Destinasi tidak ditemukan, dilewati: {$name}");
                    continue;
                }
                $trip->details()->create([
                    'destination_id' => $destination->id,
                    'sort_order' => $sort++,
                    'visit_date' => $date,
                    'visit_time' => $time,
                ]);
            }

            foreach ($budgets as [$name, $category, $amount, $currency]) {
                $trip->budgets()->create([
                    'name' => $name,
                    'category' => $category,
                    'amount' => $amount,
                    'currency' => $currency,
                ]);
            }
        }
    }

    private function trip(array $base, array $details, array $budgets): array
    {
        return $base + ['details' => $details, 'budgets' => $budgets, 'notes' => 'Data contoh untuk demonstrasi.'];
    }

    private function mainDemoTrips(): array
    {
        return [
            $this->trip(
                ['title' => 'Liburan ke Jepang', 'destination_country' => 'Jepang', 'start_date' => '2026-12-18', 'end_date' => '2026-12-22', 'currency' => 'JPY', 'timezone' => 'Asia/Tokyo', 'status' => 'planned'],
                [['Tokyo Disneyland', '2026-12-19', '09:00'], ['Tokyo Tower', '2026-12-19', '15:00'], ['Kastil Osaka', '2026-12-21', '10:00'], ['Fushimi Inari Taisha', '2026-12-22', '08:00']],
                [['Tiket pesawat Jakarta-Tokyo', 'transportasi', 85000, 'JPY'], ['Hotel di Asakusa (4 malam)', 'penginapan', 52000, 'JPY'], ['Makan dan jajan', 'makanan', 30000, 'JPY'], ['Tiket Tokyo Disneyland', 'tiket', 8900, 'JPY'], ['Oleh-oleh', 'belanja', 15000, 'JPY']]
            ),
            $this->trip(
                ['title' => 'Jelajah Jawa dan Bali', 'destination_country' => 'Indonesia', 'start_date' => '2026-08-14', 'end_date' => '2026-08-20', 'currency' => 'IDR', 'timezone' => 'Asia/Jakarta', 'status' => 'done'],
                [['Candi Borobudur', '2026-08-15', '07:00'], ['Candi Prambanan', '2026-08-15', '13:00'], ['Pantai Kuta', '2026-08-18', '16:00'], ['Tanah Lot', '2026-08-19', '17:00']],
                [['Bus dan kereta antar kota', 'transportasi', 750000, 'IDR'], ['Penginapan Yogyakarta dan Bali', 'penginapan', 1800000, 'IDR'], ['Makanan selama perjalanan', 'makanan', 950000, 'IDR'], ['Tiket masuk Borobudur', 'tiket', 50000, 'IDR'], ['Tiket masuk Prambanan', 'tiket', 50000, 'IDR']]
            ),
            $this->trip(
                ['title' => 'Impian ke Eropa', 'destination_country' => 'Prancis', 'start_date' => '2027-04-10', 'end_date' => '2027-04-14', 'currency' => 'EUR', 'timezone' => 'Europe/Paris', 'status' => 'draft'],
                [['Menara Eiffel', '2027-04-11', '10:00'], ['Museum Louvre', '2027-04-11', '14:00'], ['Disneyland Paris', '2027-04-13', '09:00']],
                [['Tiket pesawat ke Paris', 'transportasi', 780, 'EUR'], ['Hotel di Paris (4 malam)', 'penginapan', 460, 'EUR'], ['Makan dan kafe', 'makanan', 210, 'EUR'], ['Tiket Museum Louvre', 'tiket', 22, 'EUR']]
            ),
            $this->trip(
                ['title' => 'Short Trip Tokyo', 'destination_country' => 'Jepang', 'start_date' => '2027-01-05', 'end_date' => '2027-01-07', 'currency' => 'JPY', 'timezone' => 'Asia/Tokyo', 'status' => 'planned'],
                [['Tokyo Disneyland', '2027-01-06', '09:00'], ['Tokyo Tower', '2027-01-06', '16:00']],
                [['Hotel kapsul Shinjuku', 'penginapan', 18000, 'JPY'], ['Makan dan transportasi kota', 'makanan', 9000, 'JPY']]
            ),
        ];
    }

    private function dummyUsers(): array
    {
        return [
            [
                'name' => 'Budi Santoso', 'email' => 'budi@routemate.test',
                'trips' => [
                    $this->trip(
                        ['title' => 'Backpacking Bali dan Lombok', 'destination_country' => 'Indonesia', 'start_date' => '2026-09-03', 'end_date' => '2026-09-08', 'currency' => 'IDR', 'timezone' => 'Asia/Makassar', 'status' => 'done'],
                        [['Pantai Kuta', '2026-09-03', '15:00'], ['Tanah Lot', '2026-09-04', '17:00'], ['Gili Trawangan', '2026-09-06', '09:00']],
                        [['Feri dan bus', 'transportasi', 620000, 'IDR'], ['Hostel dan homestay', 'penginapan', 1250000, 'IDR'], ['Makan warung dan kafe', 'makanan', 780000, 'IDR'], ['Sewa motor', 'transportasi', 300000, 'IDR']]
                    ),
                    $this->trip(
                        ['title' => 'Impian ke Jepang', 'destination_country' => 'Jepang', 'start_date' => '2027-03-15', 'end_date' => '2027-03-20', 'currency' => 'JPY', 'timezone' => 'Asia/Tokyo', 'status' => 'planned'],
                        [['Tokyo Disneyland', '2027-03-16', '09:00'], ['Pagoda Chureito dan Gunung Fuji', '2027-03-18', '08:00'], ['Fushimi Inari Taisha', '2027-03-19', '09:00']],
                        [['Tiket pesawat promo', 'transportasi', 79000, 'JPY'], ['Hotel bisnis Tokyo', 'penginapan', 45000, 'JPY'], ['Makan dan jajan', 'makanan', 26000, 'JPY'], ['Oleh-oleh', 'belanja', 12000, 'JPY']]
                    ),
                ],
            ],
            [
                'name' => 'Sari Wulandari', 'email' => 'sari@routemate.test',
                'trips' => [
                    $this->trip(
                        ['title' => 'Wisata Sejarah Jawa', 'destination_country' => 'Indonesia', 'start_date' => '2026-07-11', 'end_date' => '2026-07-14', 'currency' => 'IDR', 'timezone' => 'Asia/Jakarta', 'status' => 'done'],
                        [['Monumen Nasional (Monas)', '2026-07-11', '09:00'], ['Museum Nasional Indonesia', '2026-07-11', '13:00'], ['Candi Borobudur', '2026-07-13', '07:00'], ['Candi Prambanan', '2026-07-13', '13:00']],
                        [['Kereta antar kota', 'transportasi', 540000, 'IDR'], ['Hotel Yogyakarta', 'penginapan', 900000, 'IDR'], ['Makanan khas daerah', 'makanan', 620000, 'IDR'], ['Tiket masuk candi', 'tiket', 100000, 'IDR']]
                    ),
                    $this->trip(
                        ['title' => 'Seoul Seru', 'destination_country' => 'Korea Selatan', 'start_date' => '2027-05-06', 'end_date' => '2027-05-10', 'currency' => 'KRW', 'timezone' => 'Asia/Seoul', 'status' => 'planned'],
                        [['Istana Gyeongbokgung', '2027-05-07', '10:00'], ['N Seoul Tower', '2027-05-07', '18:00'], ['Desa Budaya Gamcheon', '2027-05-09', '09:00']],
                        [['Transportasi T-money', 'transportasi', 95000, 'KRW'], ['Hotel Myeongdong', 'penginapan', 420000, 'KRW'], ['Makan dan street food', 'makanan', 180000, 'KRW'], ['Tiket N Seoul Tower', 'tiket', 21000, 'KRW']]
                    ),
                ],
            ],
            [
                'name' => 'Andi Pratama', 'email' => 'andi@routemate.test',
                'trips' => [
                    $this->trip(
                        ['title' => 'Keliling Eropa Barat', 'destination_country' => 'Italia', 'start_date' => '2027-06-02', 'end_date' => '2027-06-12', 'currency' => 'EUR', 'timezone' => 'Europe/Rome', 'status' => 'planned'],
                        [['Colosseum', '2027-06-03', '09:00'], ['Menara Eiffel', '2027-06-07', '10:00'], ['Museum Louvre', '2027-06-08', '09:00'], ['Sagrada Familia', '2027-06-11', '11:00']],
                        [['Kereta antar negara', 'transportasi', 320, 'EUR'], ['Hotel dan apartemen', 'penginapan', 890, 'EUR'], ['Makan', 'makanan', 410, 'EUR'], ['Tiket masuk atraksi', 'tiket', 96, 'EUR']]
                    ),
                    $this->trip(
                        ['title' => 'Singapura Singkat', 'destination_country' => 'Singapura', 'start_date' => '2026-10-17', 'end_date' => '2026-10-19', 'currency' => 'SGD', 'timezone' => 'Asia/Singapore', 'status' => 'done'],
                        [['Merlion Park', '2026-10-17', '16:00'], ['Gardens by the Bay', '2026-10-18', '10:00'], ['Universal Studios Singapore', '2026-10-18', '13:00']],
                        [['MRT dan bus', 'transportasi', 45, 'SGD'], ['Hotel Bugis', 'penginapan', 260, 'SGD'], ['Makan hawker', 'makanan', 110, 'SGD'], ['Tiket USS', 'tiket', 82, 'SGD']]
                    ),
                ],
            ],
            [
                'name' => 'Dewi Lestari', 'email' => 'dewi@routemate.test',
                'trips' => [
                    $this->trip(
                        ['title' => 'London dan Paris', 'destination_country' => 'Inggris', 'start_date' => '2027-02-14', 'end_date' => '2027-02-19', 'currency' => 'GBP', 'timezone' => 'Europe/London', 'status' => 'planned'],
                        [['Big Ben dan Istana Westminster', '2027-02-15', '10:00'], ['British Museum', '2027-02-15', '14:00'], ['Menara Eiffel', '2027-02-18', '10:00']],
                        [['Hotel London', 'penginapan', 380, 'GBP'], ['Makan dan teh sore', 'makanan', 120, 'GBP'], ['Tiket Eurostar ke Paris', 'transportasi', 89, 'EUR'], ['Tiket Menara Eiffel', 'tiket', 37, 'EUR']]
                    ),
                    $this->trip(
                        ['title' => 'Bulan Madu Santorini', 'destination_country' => 'Yunani', 'start_date' => '2027-09-20', 'end_date' => '2027-09-24', 'currency' => 'EUR', 'timezone' => 'Europe/Athens', 'status' => 'draft'],
                        [['Santorini', '2027-09-21', '16:00']],
                        [['Villa di Oia', 'penginapan', 620, 'EUR'], ['Makan malam romantis', 'makanan', 180, 'EUR'], ['Sewa mobil', 'transportasi', 150, 'EUR']]
                    ),
                ],
            ],
            [
                'name' => 'Rizky Ramadhan', 'email' => 'rizky@routemate.test',
                'trips' => [
                    $this->trip(
                        ['title' => 'Petualangan Indonesia Timur', 'destination_country' => 'Indonesia', 'start_date' => '2027-01-12', 'end_date' => '2027-01-19', 'currency' => 'IDR', 'timezone' => 'Asia/Jayapura', 'status' => 'planned'],
                        [['Raja Ampat', '2027-01-13', '08:00'], ['Pulau Padar', '2027-01-16', '06:00'], ['Pantai Pink', '2027-01-16', '11:00'], ['Gunung Bromo', '2027-01-19', '03:00']],
                        [['Pesawat domestik', 'transportasi', 4200000, 'IDR'], ['Kapal dan perahu', 'transportasi', 1500000, 'IDR'], ['Penginapan dan homestay', 'penginapan', 2600000, 'IDR'], ['Makan dan logistik', 'makanan', 1300000, 'IDR']]
                    ),
                    $this->trip(
                        ['title' => 'Kuala Lumpur Trip', 'destination_country' => 'Malaysia', 'start_date' => '2026-12-05', 'end_date' => '2026-12-07', 'currency' => 'MYR', 'timezone' => 'Asia/Kuala_Lumpur', 'status' => 'planned'],
                        [['Menara Kembar Petronas', '2026-12-05', '11:00'], ['Batu Caves', '2026-12-06', '09:00']],
                        [['Hotel KL Sentral', 'penginapan', 540, 'MYR'], ['Makan dan transportasi', 'makanan', 260, 'MYR'], ['Tiket Petronas', 'tiket', 127, 'MYR']]
                    ),
                ],
            ],
        ];
    }
}
