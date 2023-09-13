<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCollectionsTable extends Migration
{
    public function up()
    {
        Schema::create('article_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->longText('details');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
