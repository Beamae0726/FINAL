<?php


// use Phpml\Classification\KNearestNeighbors;

// Route::get('/predict', function () {
//     // Create a new instance of the K-Nearest Neighbors classifier
//     $classifier = new KNearestNeighbors();

//     // Train the classifier with sample data
//     $samples = [[5, 1], [10, 2], [3, 3], [2, 8], [7, 9]];
//     $labels = ['a', 'b', 'c', 'd', 'e'];
//     $classifier->train($samples, $labels);

//     // Make a prediction
//     $prediction = $classifier->predict([4, 5]);

//     // Return the prediction
//     return $prediction;
// });


Route::get('/','ChatBotController@index');
Route::get('/test','ChatBotController@ai');
Route::post('/ask','ChatBotController@ask')->name('question');
// Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Reliable Source
    Route::delete('reliable-sources/destroy', 'ReliableSourceController@massDestroy')->name('reliable-sources.massDestroy');
    Route::post('reliable-sources/parse-csv-import', 'ReliableSourceController@parseCsvImport')->name('reliable-sources.parseCsvImport');
    Route::post('reliable-sources/process-csv-import', 'ReliableSourceController@processCsvImport')->name('reliable-sources.processCsvImport');
    Route::resource('reliable-sources', 'ReliableSourceController');

    // Category
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/parse-csv-import', 'CategoryController@parseCsvImport')->name('categories.parseCsvImport');
    Route::post('categories/process-csv-import', 'CategoryController@processCsvImport')->name('categories.processCsvImport');
    Route::resource('categories', 'CategoryController');

    // Article Collection
    Route::delete('article-collections/destroy', 'ArticleCollectionController@massDestroy')->name('article-collections.massDestroy');
    Route::post('article-collections/media', 'ArticleCollectionController@storeMedia')->name('article-collections.storeMedia');
    Route::post('article-collections/ckmedia', 'ArticleCollectionController@storeCKEditorImages')->name('article-collections.storeCKEditorImages');
    Route::resource('article-collections', 'ArticleCollectionController');

    // Offensive Words
    Route::delete('offensive-words/destroy', 'OffensiveWordsController@massDestroy')->name('offensive-words.massDestroy');
    Route::post('offensive-words/parse-csv-import', 'OffensiveWordsController@parseCsvImport')->name('offensive-words.parseCsvImport');
    Route::post('offensive-words/process-csv-import', 'OffensiveWordsController@processCsvImport')->name('offensive-words.processCsvImport');
    Route::resource('offensive-words', 'OffensiveWordsController');

    // Block Ip
    Route::delete('block-ips/destroy', 'BlockIpController@massDestroy')->name('block-ips.massDestroy');
    Route::post('block-ips/parse-csv-import', 'BlockIpController@parseCsvImport')->name('block-ips.parseCsvImport');
    Route::post('block-ips/process-csv-import', 'BlockIpController@processCsvImport')->name('block-ips.processCsvImport');
    Route::resource('block-ips', 'BlockIpController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});
