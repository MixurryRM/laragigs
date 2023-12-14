<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;

//All Listings
Route::get('/',[ListingController::class,'index']);

//Show Create Form
Route::get('/listings/create',[ListingController::class,'create'])->middleware('auth');

//Store Listings Data
Route::post('/listings',[ListingController::class,'store'])->middleware('auth');

//Show Edit Form
Route::get('/listings/{listing}/edit',[ListingController::class,'edit'])->middleware('auth');

//Update Listings
Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');

//Delete Listings
Route::delete('/listings/{listing}',[ListingController::class,'delete'])->middleware('auth');

//Manage Listings
Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');

//Single Listnig
Route::get('/listings/{id}',[ListingController::class,'showList']);

//Show Register/Create Form
Route::get('/register',[UserController::class,'create'])->middleware('guest');

//Create New User
Route::post('/users',[UserController::class,'store']);

//Logout User
Route::post('/logout',[UserController::class,'logout']);

//Show Login
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');

//Authenticate Login User
Route::post('/users/authenticate',[UserCOntroller::class,'authenticate']);

