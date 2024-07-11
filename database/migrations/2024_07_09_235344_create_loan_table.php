<?php

use App\Models\Cpf;
use App\Models\Institutions;
use App\Models\Modalities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Institutions::class);
            $table->foreignIdFor(Modalities::class);
            $table->foreignIdFor(Cpf::class);
            $table->timestamps();
            $table->foreign('institutions_id')->references('id')->on('institutions');
            $table->foreign('modalities_id')->references('id')->on('modalities');
            $table->foreign('cpf_id')->references('id')->on('cpfs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
