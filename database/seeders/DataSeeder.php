<?php

namespace Database\Seeders;

use \App\Models\Institutions;
use \App\Models\Modalities;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = array(
            'Tapita Bank',
            'Uilho Bank',
            'Kkroto Bank',
            'Elingoles Bank',
            'Botelho Bank',
            'Inconvenientemar Bank',
        );

        $modalities = array(
            'Consignado',
            'Pessoal',
            'Garantia Imóvel'
        );

        foreach ($banks as $bank) {
            $institution = Institutions::create([
                'name' => $bank,
            ]);

            $minPortion = rand(6, 12);
            $maxPortion = rand($minPortion, 60);

            foreach ($modalities as $modality) {
                $minValue = rand(100, 2000);
                $maxValue  = rand($minValue, 100000);

                Modalities::create([
                    'institutions_id' => $institution->id,
                    'name' => $modality,
                    'code' => md5($bank . ' ' . $modality),
                    'minPortion' => $minPortion,
                    'maxPortion' => $maxPortion,
                    'minValue' => $minValue,
                    'maxValue' => $maxValue,
                    'fess' => rand(20, 70) / 10
                ]);
            }
        }
    }
}
