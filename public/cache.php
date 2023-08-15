<?php
try {
    $name = md5($_SERVER['REQUEST_URI']).'.php';
    $path = __DIR__.'/page-cache/'.$name;
    if (file_exists($path)){
        @require_once $path;
    }else{
        require_once "index.php";
    }
}catch (\Exception $exception){
    require_once "index.php";
}




