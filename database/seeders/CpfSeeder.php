<?php

namespace Database\Seeders;

use App\Models\Cpf;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CpfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cpfs = array(
            '11111111111',
            '12312312312',
            '22222222222'
        );

        foreach ($cpfs as $cpf) {

           Cpf::create([
                'cpf' => $cpf,
            ]);
        }

    }
}
