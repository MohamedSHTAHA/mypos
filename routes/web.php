<?php

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

use App\User;

Auth::routes(['register' => false, 'verify' => true]);

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/testemail', 'HomeController@testemail')->name('testemail');
Route::get('/testjobs', 'HomeController@testjobs')->name('testjobs');


Route::get('login/{provider}', 'Auth\LoginController@redirect')->name('sologin');
Route::get('login/{provider}/callback', 'Auth\LoginController@callback')->name('socallback');


Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm'); //->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout'); //->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});



//collection

Route::get('/collection', function () {
  $users = User::get();
  echo "<pre>";
  //dd($users);
  //dd($user->all());

  //dd($user->avg('id'));

  //dd($users->chunk(10));
  //dd($users->chunk(3)[0][0]->id);

  //$users = $users->chunk(10);
  //dd($users->collapse());

  //dd($users->combine(['', '', '']));

  //dd($users->contains('first_name', 'Super'));

  /*$data = [['Warsaw' => 'Poland', 'Berlin' => 'Germany'], ['Moscow' => 'Russia']];
  $collection = collect($data);
  dd($collection);
  $result = $collection->contains('Moscow', 'Russia');
  dd($result);*/

  //dd($users->pluck('id', 'first_name'));

  /*$users->contains(function ($value, $key) {
    var_dump($value->first_name);
  });*/

  //dd($users->count());

  /*$users->each(function ($value, $key) {
    var_dump($value->first_name);
    //return false;
  });*/

  /*$every = $users->every(function ($value, $key) {
    //var_dump($value->first_name);
    return $value->first_name = 'Super';
  });
  dd($every);*/

  /*$filter = $users->filter(function ($value, $key) {
    //var_dump($value->first_name);
    return $value->id < 10;
  });
  dd($filter);*/

  //$collection = collect(['product_id' => 1, 'name' => 'Desk', 'price' => 100, 'discount' => false]);
  //dd($collection->only(['product_id', 'name']));

  //dd($users[0]->only(['id', 'first_name']));


  //dd($users->keyBy('first_name'));

  //dd($users->search('Super'));


  //$collection = collect([2, 4, 6, 8]);
  //dd($collection->search(4));


  /*$r = $users->search(function ($item, $key) {
    var_dump($item->first_name);
    return $item->first_name === 'السيد زكي الامام';
    //return $item->id == 10;
  });
  dd($r);*/
});