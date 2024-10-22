<?php

class logger
{
    public static function init(): void
    {
        if(CONFIG["logger"] == "on" and !isset($_SESSION["LOG_INIT"])){
        fwrite(fopen(ROOT_PATH . "engine/log.txt","w"),
"
log Created at " . date("d-m-Y H:i:s") . "
--------------------");
        $_SESSION["LOG_INIT"] = true;
            }
    }

    public static function add($class, $message): void
    {
        if(CONFIG["logger"] == "on" and isset($_SESSION["LOG_INIT"])){
            fwrite(fopen(ROOT_PATH . "engine/log.txt","a"),
"         
*$class* log add at " . date("d-m-Y H:i:s") . "

log message: " . $message . "
--------------------");

        }
 }
}