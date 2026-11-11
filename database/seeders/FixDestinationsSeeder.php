<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

/**
 * Membersihkan data destinasi bayangan bernama Inggris yang merupakan
 * duplikat dari data resmi seeder:
 *   'Gyeongbokgung Palace'  -> resmi: 'Istana Gyeongbokgung'
 *   'Petronas Twin Towers'  -> resmi: 'Menara Kembar Petronas'
 *   'Grand Palace Bangkok'  -> resmi: 'Grand Palace'
 *
 * Ketiganya tidak dipakai itinerary mana pun (terverifikasi dari laporan
 * admin: jumlah itinerary = 0), jadi aman dihapus. Setelah penghapusan,
 * seeder resmi dijalankan ulang agar data kanonis lengkap (51 destinasi,
 * termasuk 'Menara Kembar Petronas' bila sempat terhapus), tarif lokal
 * terisi, dan foto menempel ke data yang benar.
 */
class FixDestinationsSeeder extends Seeder
{
    public function run(): void
    {
        $shadows = ['Gyeongbokgung Palace', 'Petronas Twin Towers', 'Grand Palace Bangkok'];

        foreach ($shadows as $name) {
            $deleted = Destination::where('name', $name)->delete();
            $this->command?->info($deleted > 0
                ? "Data bayangan dihapus: {$name}"
                : "Tidak ditemukan (sudah bersih): {$name}");
        }

        $this->call([
            DestinationSeeder::class,
            FamousDestinationSeeder::class,
            LocalEntranceFeesSeeder::class,
            DestinationPhotoSeeder::class,
        ]);

        $this->command?->info('Total destinasi sekarang: ' . Destination::count() . ' (target: 51)');
    }
}
