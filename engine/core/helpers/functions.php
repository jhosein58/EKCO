<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

// system function
function path($path): string
{
    return ROOT_PATH . $path;
}
function encrypt($in): string
    {
        $ciphering = "AES-128-CTR";
        $options = 0;
        $iv_length = openssl_cipher_iv_length($ciphering);
        $encryption_iv = CONFIG['encryption_iv'];
        $encryption_key = CONFIG['encryption_key'];
        return openssl_encrypt($in, $ciphering, $encryption_key, $options, $encryption_iv);
    }
function decrypt($in): string
    {
        $ciphering = "AES-128-CTR";
        $options = 0;
        $iv_length = openssl_cipher_iv_length($ciphering);
        $decryption_iv = CONFIG['encryption_iv'];
        $decryption_key = CONFIG['encryption_key'];
        return openssl_decrypt($in, $ciphering, $decryption_key, $options, $decryption_iv);
    }
function import_plugin($name): void
{
    if (file_exists(path("engine/library/$name/$name")) . ".php") {
        include_once path("engine/library/$name/$name") . ".php";
    }
}
function add_plugin($name): void
    {
        if (file_exists(path($name)) . ".php") {
            include_once path($name) . ".php";
        }
    }
function get_func_argNames($funcName): array
{
    $f = new ReflectionFunction($funcName);
    $result = array();
    foreach ($f->getParameters() as $param) {
        $result[] = $param->name;
    }
    return $result;
}
function rand_str($length = 10): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}
//function error(): bool{
//    if($_SESSION["error"] == 0){
//        return true;
//    }else{
//        return false;
//    }
//}

// jwt token functions
function createToken($data = []): string
{
    $data['authentication'] = CONFIG['authentication_key'];
    return JWT::encode($data, CONFIG['encryption_key'], 'HS256');
}
function validateToken(string $token)
{
    try {
        return JWT::decode($token, new Key(CONFIG['encryption_key'], 'HS256'));
    }catch (Exception $e){

    }
}

function checkToken(string $token): bool
{
    $token_valid = validateToken($token);
    if($token_valid == null){
        return false;
    }else{
        return true;
    }
}

// api functions
function api_jsonOutput(): void
{
    header('Content-Type: application/json');
}
function api_textOutput(): void
{
    header('Content-Type: text/plain');
}
function api_lock(bool $if = true): void
{
    if(!$if) {
        die('403');
    }
}

// http requests functions
function get($url): object
{
    return WpOrg\Requests\Requests::get($url);
}
function post(string $url, array $data): object
{
    return WpOrg\Requests\Requests::post($url, array(), $data);
}

function receive($data = null, $is_file = false)
{
   if($data == null){
       return $_POST;
   }else{
       if ($is_file) {
           return $_FILES[$data];
       }else{
           return $_POST[$data];
       }
   }
}

// files and storages functions
function storage_path(string $path = ''): string{
    return path('engine/storage/') . $path;
}
function storage_write(string $path, $data): void{
    fwrite(fopen(storage_path($path), "w"), $data);
}
function storage_read($path): string
{
    return file_get_contents(storage_path($path));
}
function storage_uploadImage(string $path, $file, int $max_size = 100): int
{
    $canUpload = true;
    $imageFileType = strtolower(pathinfo(basename($file["name"]),PATHINFO_EXTENSION));
    if (file_exists(storage_path($path))) {
        $canUpload = false;
        return 1;
    }
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $canUpload = false;
        return 1;
    }
    if ($file["size"] > $max_size * 1024) {
        $canUpload = false;
         return 1;
    }
    if($canUpload){
        if(move_uploaded_file($file["tmp_name"], storage_path($path))){
            return 0;
        }else{
            return 1;
        }
    }
}

//view and controller functions
function error($code)
{
    if(file_exists(ROOT_PATH . "engine/views/error/$code.html")){
        include_once ROOT_PATH . "engine/views/error/$code.html";
    }
}
function view($view)
{
    if(file_exists(ROOT_PATH . "engine/views/$view.html")){
        include_once ROOT_PATH . "engine/views/$view.html";
    }
}
function phpView($view)
{
    if(file_exists(ROOT_PATH . "engine/views/$view.php")){
        include_once ROOT_PATH . "engine/views/$view.php";
    }
}
function controller($method, array $data = []): string
{
    if(method_exists(Main::class, $method)){
        return Main::$method(...$data);
    }else{
        return '';
    }
}