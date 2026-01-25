<?php

namespace Database\Seeders;

use App\Dictionaries\ThingTypeDictionary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NetworkThingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('network_things')->truncate();
        $networkThings = DB::table('things')->whereIn('thing_type_id', [
            ThingTypeDictionary::PC, ThingTypeDictionary::ARM, ThingTypeDictionary::FAX, ThingTypeDictionary::KMA,
            ThingTypeDictionary::PRINTER, ThingTypeDictionary::SERVER, ThingTypeDictionary::NETWORK_BORDER, ThingTypeDictionary::MONOPC,
            ThingTypeDictionary::STORAGE
        ])->get();

        foreach ($networkThings as $networkThing) {
            DB::table('network_things')->insert([
                'thing_id' => $networkThing->id,
                'ip_address' => fake()->ipv4(),
                'phone_number' => null,
                'comment' => fake()->text()
            ]);
        }
        $telephones = DB::table('things')->whereIn('thing_type_id', [
            ThingTypeDictionary::TELEPHONE
        ])->get();
        foreach ($telephones as $telephone) {
            DB::table('network_things')->insert([
                'thing_id' => $telephone->id,
                'ip_address' => null,
                'phone_number' => fake()->phoneNumber(),
                'comment' => fake()->text()
            ]);
        }

    }
}
