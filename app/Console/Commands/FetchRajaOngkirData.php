<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Province;
use App\Services\RajaOngkirService;
use Illuminate\Console\Command;

class FetchRajaOngkirData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-raja-ongkir-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data provinsi dan kota dari Rajaongkir API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rajaOngkirService = new RajaOngkirService();
        $this->info('Fetching data provinsi...');
        $provinces = $rajaOngkirService->getProvinces();
        $this->info('Fetching data kota...');
        $cities = $rajaOngkirService->getCities();

        $this->info('Saving data provinsi...');
        foreach ($provinces['rajaongkir']['results'] as $province) {
            Province::updateOrCreate(
                ['id' => $province['province_id']],
                ['name' => $province['province']]
            );
        }

        $this->info('Saving data kota...');
        foreach ($cities['rajaongkir']['results'] as $city) {
            City::updateOrCreate(
                ['id' => $city['city_id']],
                [
                    'province_id' => $city['province_id'],
                    'name' => $city['city_name'],
                    'type' => $city['type'],
                    'postal_code' => $city['postal_code']
                ]
            );
        }

        $this->info('Data provinsi dan kota berhasil diupdate');
    }
}
