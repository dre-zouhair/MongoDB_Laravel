<?php



Route::get('/', function () {
    return view('index');
});


Route::get('/get', 'MedicineController@index')->name('getMedicines');

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('user/profile', 'UserController@show')->name('usershow');
    Route::post('user/profile', 'UserController@show')->name('userprofile');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/medicines', 'MedicineController@View')->name('medicines');
    Route::get('users', 'UserController@View')->name('users')->middleware('admin');

    Route::group(['middleware' => ['ajax']], function () {
        Route::get('/medicine', 'MedicineController@index')->name('medicine');//
        Route::post('user/profile/changepassword', 'UserController@ChangePassowrd')->name('changepassword');//
        Route::post('user/profile/changeemail', 'UserController@ChangeEmail')->name('changemail');//
        Route::post('user/store', 'UserController@store')->name('userstore');//
        Route::post('medicine/store', 'MedicineController@store')->name('medicinetstore');//
        Route::get('medicine/destroy', 'MedicineController@destroy')->name('medicinedestroy');//
        Route::get('medicine/show', 'MedicineController@show')->name('medicineshow');//
        Route::get('dashboard/chart', 'HomeController@chart')->name('chart');//
        Route::get('dashboard/chartuser', 'HomeController@chartuser')->name('chartuser');//
        Route::get('dashboard/chartmedicines', 'HomeController@chartmedicines')->name('chartmedicines');//
        Route::group(['middleware' => ['admin']], function () {
            Route::get('user', 'UserController@index')->name('user');//
            Route::get('user/destroy', 'UserController@destroy')->name('userdestroy');//
        });
    });

});





