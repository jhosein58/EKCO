<?php

class Launcher
{
    public function start(): int{
        return $this->autoloader();
    }
    protected function hashKeyGenerator(): void{
        $configURL = $_SERVER['DOCUMENT_ROOT'].'/engine/config.php';
        $config = file($configURL);
        $oldConfig = "";
        $newConfig = "";
        foreach($config as $value){
            $oldConfig .= $value;
            if(str_contains($value, '"encryption_iv" => "***AUTOGENERATE***"')){
                    $value = str_replace('***AUTOGENERATE***', rand_str(16), $value);
            }
            if (str_contains($value, '"encryption_key" => "***AUTOGENERATE***"')){
                    $value = str_replace('***AUTOGENERATE***', rand_str(32), $value);
            }
            if (str_contains($value, '"authentication_key" => "***AUTOGENERATE***"')){
                $value = str_replace('***AUTOGENERATE***', rand_str(8), $value);
            }
            $newConfig .= $value;
        }
        if($oldConfig != $newConfig){
            fwrite(fopen($configURL, 'w'), $newConfig);
        }
    }
    public function initClient(): void{
        if(!isset($_COOKIE['client'])){
            $client_id = uniqid();
            setcookie('client', $client_id, time() + 999999999);
            $_SESSION['client_id'] = $client_id;
        }else{
            $_SESSION['client_id'] = $_COOKIE['client'];
        }
    }
    private function setupCorsApi(): void{
        if (@$_SERVER['HTTP_ORIGIN']) {
            //header("Origin: http://localhost");
            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Max-Age: 1000');
            header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        }
        if (isset($_SERVER['HTTP_ORIGIN'])) {
                header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');
            }
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

                exit(0);
            }
    }
    private function autoloader(): int
    {
        $this->setupCorsApi();
        session_start();
        $_SESSION ['db_ext'] = 0;
        $_SESSION['error'] = 0;
        $_SESSION['error_details'] = [];
        $this->initClient();

        // add constants
        define("CONFIG", include $_SERVER['DOCUMENT_ROOT'] . "/engine/config.php");
        define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'].'/');
        define('MAIN_DB_PATH', ROOT_PATH . 'engine/database/main.db');
        //define("REQUESTS", json_decode(file_get_contents('php://input'), true));

        // load composer packages
        include_once ROOT_PATH . 'engine/vendor/autoload.php';

        // load important library's and helpers
        include_once ROOT_PATH . 'engine/core/helpers/functions.php';
        $this->hashKeyGenerator();

        // initialize logger
        include_once ROOT_PATH . 'engine/core/logger.php';
        logger::init();

        // include and initialize database
        include_once ROOT_PATH . 'engine/core/db.php';
        DB::setup();

        // include cores, library and controllers
        include_once ROOT_PATH . 'engine/core/debugger.php';
        include_once ROOT_PATH . 'engine/controller/main.php';
        include_once ROOT_PATH . 'engine/core/router.php';
        if(method_exists(Main::class, 'setup')){
            Main::setup();
        }
        include_once ROOT_PATH . 'engine/routes.php';
        //error(404);
        return 0;

    }
}