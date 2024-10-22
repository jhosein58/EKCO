<?php

class debugger
{
    public static function run_debugger(): void
    {
        //ob_clean();
        include_once path("engine/system/debugger_view.php");
    }

    public static function bug_finder($debug): string
    {
        $code = '';
        $real_line = 1;
        $bug_real_line = 1;
        $file = file($debug[0]['file']);
        $line = $debug[0]['line'] -1;
        $i = $line - 4;
        while ($i <= $line + 4) {
            if(isset($file[$i])) {
                $code .= "[" . $i + 1 . "]    ". $file[$i];
                if($i == $line) {
                    $bug_real_line = $real_line - 1;
                }
                $real_line++;
            }
            $i++;
        }
        $_SESSION['error_details']['real_line'] = $bug_real_line;
        return $code;
    }

    public static function setup($debug, $text): void
    {
        if(CONFIG['debug_mode'] == "on") {
            $_SESSION['error'] = 1;
            $_SESSION['error_details']['title'] = $text;
            $_SESSION['error_details']['debug'] = $debug;
            $_SESSION['error_details']['code'] = debugger::bug_finder($debug);
            debugger::run_debugger();
        }
    }
    public static function error_routExist(array $debug): void
    {
        debugger::setup($debug, 'The path you added already exists');
    }
    public static function error_viewNotExist(array $debug): void
    {
        debugger::setup($debug, 'Your selected view does not exist');
    }
    public static function error_methodNotExist(array $debug): void
    {
        debugger::setup($debug, 'Your selected method does not exist on main controller');
    }
    public static function error_routAddCalled(array $debug): void
    {
        debugger::setup($debug, 'You can only add a new rout from the routes.php file');
    }
}

