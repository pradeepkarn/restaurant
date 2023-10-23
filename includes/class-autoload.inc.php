<?php 
spl_autoload_register('classLoader');
spl_autoload_register('apiControllersLoader');

function classLoader($className){
    $path = RPATH ."/classes/";
    $extension = ".class.php";
    $fullPath = $path . $className . $extension;
    if(file_exists($fullPath)){
        include_once $fullPath;
    }else{
        return false;
    }
}
function apiControllersLoader($className){
    $path = RPATH ."/ctrls/api/";
    $extension = ".api.php";
    $fullPath = $path . $className . $extension;
    
    if(file_exists($fullPath)){
        include_once $fullPath;
    }else{
        return false;
    }
}


?>