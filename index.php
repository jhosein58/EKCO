<?php
require 'engine/core/launcher.php';
$launcher = new Launcher();
if($launcher->start() !== 0){
    die("error");
}



