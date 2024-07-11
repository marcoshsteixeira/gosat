<?php

use App\Models\Institutions;
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
        Schema::create('modalities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Institutions::class);
            $table->string('name');
            $table->string('code');
            $table->integer('minPortion');
            $table->integer('maxPortion');
            $table->float('minValue');
            $table->float('maxValue');
            $table->float('fess');
            $table->timestamps();
            $table->foreign('institutions_id')->references('id')->on('institutions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modalities');
    }
};
