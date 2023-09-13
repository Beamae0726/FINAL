<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Reliable Source
    Route::apiResource('reliable-sources', 'ReliableSourceApiController');

    // Category
    Route::apiResource('categories', 'CategoryApiController');

    // Article Collection
    Route::post('article-collections/media', 'ArticleCollectionApiController@storeMedia')->name('article-collections.storeMedia');
    Route::apiResource('article-collections', 'ArticleCollectionApiController');

    // Offensive Words
    Route::apiResource('offensive-words', 'OffensiveWordsApiController');

    // Block Ip
    Route::apiResource('block-ips', 'BlockIpApiController');
});
