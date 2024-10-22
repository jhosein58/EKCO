<?php

namespace Core\Router;

class Route
{
    private static function urlToArray($url): array
    {
        $parsed_url = parse_url($url);
        $url_array = explode("/", $parsed_url['path']);
        return array_values(array_filter($url_array, fn($value) => !is_null($value) && $value !== ''));
    }
    private static function process($url, $func): void
    {
        $old_url = $url;
        $request_url = self::urlToArray($_SERVER['REQUEST_URI']);
        $url = self::urlToArray($url);
        $load = true;
        $i = 0;
        $arg = [];
        if(!str_contains($old_url, '{')
            and !str_contains($old_url, '}')
            and !str_contains($old_url, '*')){
            if($request_url == $url){
                if(gettype($func) == 'object'){
                    echo $func(...$arg);
                }
                exit();
            }
        }else{
            if(count($request_url) == count($url) and !str_contains($old_url, "*")){
            while ($i < count($url)) {
                if($url[$i] != $request_url[$i]){
                    if(str_starts_with($url[$i], "{") and str_ends_with($url[$i], "}")){
                        $arg[] = $request_url[$i];
                    }else{
                        $load = false;
                        break;
                    }
                }
                $i++;
            }
            if ($load) {
                if(gettype($func) == 'object'){
                    echo $func(...$arg);
                }
                exit();
            }
        }elseif (str_contains($old_url, "*")){
            while (true) {
                if($url[$i] == '*'){
                    break;
                }elseif($url[$i] != $request_url[$i]){
                    if(str_starts_with($url[$i], "{") and str_ends_with($url[$i], "}")){
                        $arg[] = $request_url[$i];
                    }else{
                        $load = false;
                        break;
                    }
                }
                $i++;
            }
            if ($load) {
                if(gettype($func) == 'object'){
                    echo $func(...$arg);
                }
                exit();
            }
        }}

    }

    public static function get($url, $func): void
    {
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            self::process($url, $func);
        }
    }
    public static function post($url, $func): void
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            self::process($url, $func);
        }
    }
}