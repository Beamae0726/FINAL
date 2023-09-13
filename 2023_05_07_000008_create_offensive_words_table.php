<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffensiveWordsTable extends Migration
{
    public function up()
    {
        Schema::create('offensive_words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('word');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
