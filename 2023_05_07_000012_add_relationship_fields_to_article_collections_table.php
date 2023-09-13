<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToArticleCollectionsTable extends Migration
{
    public function up()
    {
        Schema::table('article_collections', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_8446131')->references('id')->on('categories');
        });
    }
}
