<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReliableSourcesTable extends Migration
{
    public function up()
    {
        Schema::create('reliable_sources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('source_url')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
