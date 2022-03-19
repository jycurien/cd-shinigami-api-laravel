<?php

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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['numeric', 'material']);
            $table->integer('center_code');
            $table->integer('card_code');
            $table->integer('check_sum');
            $table->dateTime('activated_at')->nullable();
            $table->unique(['center_code', 'card_code']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
};
