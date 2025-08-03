<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Index::class);
Route::get('/about', \App\Livewire\About::class);
Route::get('/blog-details2', \App\Livewire\BlogDetails2::class);
Route::get('/booking', \App\Livewire\Booking::class);
Route::get('/confirmation', \App\Livewire\Confirmation::class);
Route::get('/rooms-details', \App\Livewire\RoomsDetails::class);
Route::get('/rooms2', \App\Livewire\Rooms2::class);
Route::get('/blog-details', \App\Livewire\BlogDetails::class);
Route::get('/blog', \App\Livewire\Blog::class);
Route::get('/checkout', \App\Livewire\Checkout::class);
Route::get('/contact', \App\Livewire\Contact::class);
Route::get('/index2', \App\Livewire\Index2::class);
Route::get('/rooms', \App\Livewire\Rooms::class);
