<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitdays', function (Blueprint $table) {
            $table->id();
            $table->string('tag',45);
            $table->integer('frecuency');
            $table->enum('day',
                        ['monday','tuesday','wednesday',
                         'thursday','friday','saturday',
                         'sunday','everyday']);
            $table->time('time',0);
            $table->timestamps();

            $table->foreignId('habit_id')
                  ->constrained('habits')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habitdays');
    }
}
