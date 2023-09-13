<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockIpsTable extends Migration
{
    public function up()
    {
        Schema::create('block_ips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
