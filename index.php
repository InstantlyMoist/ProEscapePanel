<?php

include('./route.php');

// Add base route (startpage)
Route::add('/',function(){
    include ("./views/index.php");
});

// Simple test route that simulates static html file
Route::add('/room/([0-9]*)',function($var1){
    include ("./views/room/index.php");
});

Route::run('/');