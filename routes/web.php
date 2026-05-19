<?php


use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   if(Auth::loginUsingId(1)) {
       return redirect()->route('tasks.index');
   }
});

Route::resource('tasks', TasksController::class);
