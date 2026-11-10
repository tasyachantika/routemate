<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DestinationPhotoSeeder extends Seeder
{
    /**
     * Memasang foto ke destinasi yang namanya cocok dengan kata kunci.
     * File foto harus sudah disalin ke: storage/app/public/destinations/
     * Aman dijalankan ulang: hanya mengisi/menimpa kolom photo.
     * Versi lengkap: 51 destinasi (31 batch awal + 20 tempat terkenal).
     */
    public function run(): void
    {
        $photos = [
            // Batch awal (31)
            'Monas' => 'monas.jpg',
            'Borobudur' => 'borobudur.jpg',
            'Kuta' => 'pantai-kuta.jpg',
            'Ijen' => 'kawah-ijen.jpg',
            'Bromo' => 'gunung-bromo.jpg',
            'Prambanan' => 'prambanan.jpg',
            'Toba' => 'danau-toba.jpg',
            'Padar' => 'pulau-padar.jpg',
            'Gili Trawangan' => 'gili-trawangan.jpg',
            'Raja Ampat' => 'raja-ampat.jpg',
            'Tokyo Tower' => 'tokyo-tower.jpg',
            'Fushimi' => 'fushimi-inari.jpg',
            'Osaka' => 'kastil-osaka.jpg',
            'Chureito' => 'chureito-fuji.jpg',
            'Gyeongbokgung' => 'gyeongbokgung.jpg',
            'Seoul Tower' => 'n-seoul-tower.jpg',
            'Gamcheon' => 'gamcheon.jpg',
            'Petronas' => 'petronas.jpg',
            'Batu Caves' => 'batu-caves.jpg',
            'Merlion' => 'merlion.jpg',
            'Gardens by the Bay' => 'gardens-by-the-bay.jpg',
            'Grand Palace' => 'grand-palace.jpg',
            'Wat Arun' => 'wat-arun.jpg',
            'Ha Long' => 'ha-long-bay.jpg',
            'El Nido' => 'el-nido.jpg',
            'Tembok Besar' => 'tembok-besar.jpg',
            'Eiffel' => 'menara-eiffel.jpg',
            'Big Ben' => 'big-ben.jpg',
            'Colosseum' => 'colosseum.jpg',
            'Burj Khalifa' => 'burj-khalifa.jpg',
            'Sydney Opera' => 'sydney-opera-house.jpg',
            // Batch tempat terkenal (20)
            'Rinjani' => 'rinjani.jpg',
            'Museum Nasional' => 'museum-nasional.jpg',
            'Pantai Pink' => 'pantai-pink.jpg',
            'Tanah Lot' => 'tanah-lot.jpg',
            'Kawah Putih' => 'kawah-putih.jpg',
            'Tokyo Disneyland' => 'tokyo-disneyland.jpg',
            'Disneyland Paris' => 'disneyland-paris.jpg',
            'Disneyland California' => 'disneyland-california.jpg',
            'Universal Studios' => 'universal-studios.jpg',
            'Louvre' => 'louvre.jpg',
            'British Museum' => 'british-museum.jpg',
            'Piramida' => 'piramida-giza.jpg',
            'Taj Mahal' => 'taj-mahal.jpg',
            'Patung Liberty' => 'patung-liberty.jpg',
            'Santorini' => 'santorini.jpg',
            'Niagara' => 'niagara.jpg',
            'Pisa' => 'menara-pisa.jpg',
            'Sagrada' => 'sagrada-familia.jpg',
            'Waikiki' => 'waikiki.jpg',
            'Angkor Wat' => 'angkor-wat.jpg',
        ];

        foreach ($photos as $keyword => $file) {
            $destination = Destination::where('name', 'like', '%' . $keyword . '%')->first();

            if ($destination && Storage::disk('public')->exists('destinations/' . $file)) {
                $destination->photo = 'destinations/' . $file;
                $destination->save();
                $this->command?->info('Foto terpasang: ' . $destination->name);
            }
        }
    }
}
