<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
       return redirect()->route('dashboard.index');
});

Auth::routes(['register' => false]);
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/hh', function () {
 $categories = Category::where('id','=','11')->first();
return $categories;

    foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
      return   $localeCode . '=========' . $properties['native'];
});

Route::view('/hu','wel');



