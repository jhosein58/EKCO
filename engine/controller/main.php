<?php

class Main
{
    // write your code here
    public static function setup(): void
    {
        // import packages
        import_plugin('apiUnitTester');

        // setup database
        DB::newDB('users');
        DB::newTable('users', 'users', ['user', 'pass', 'token', 'firstname', 'lastname']);
        DB::makeUnique('users', 'users', 'user');

        DB::newTable('users', 'admins', ['user', 'pass', 'token', 'firstname', 'lastname']);
        DB::makeUnique('users', 'admins', 'user');

        DB::insert('users', 'admins', ['master', '123456',
            createToken([
                'user' => 'master',
                'pass' => '123456',
            ]),
            'default firstname',
            'default lastname'
            ]);

        DB::newDB('q_bank');
         DB::newTable('q_bank', 'questions', ['name', 'serial', 'lesson', 'keyword', 'designer',
             'title_text', 'title_img',
             'o1_text', 'o1_img',
             'o2_text', 'o2_img',
             'o3_text', 'o3_img',
             'o4_text', 'o4_img',
             ]);
    }
    public static function doSignUp(): string | int
    {
        api_textOutput();
        if(!isset(REQUESTS['user'], REQUESTS['pass'], REQUESTS['firstname'], REQUESTS['lastname'])){
            die('اطلاعات ناقص است');
        }
        $user = DB::fetchOne('users', 'users', "user='" . REQUESTS['user'] . "'");
        if($user == null){
            $token = createToken(['user' => REQUESTS['user'], 'pass' => REQUESTS['pass']]);
            DB::insert('users', 'users', [REQUESTS['user'], REQUESTS['pass'], $token, REQUESTS['firstname'], REQUESTS['lastname']]);
            return $token;
        }else{
            return 1;
        }
    }
    public static function doLogin(): string | int
    {
        api_textOutput();
        if(!isset(REQUESTS['user'], REQUESTS['pass'])){
            die('اطلاعات ناقص است');
        }
        $user = DB::fetchOne('users', 'users', "user='" . REQUESTS['user'] . "'");
        $admin = DB::fetchOne('users', 'admins', "user='" . REQUESTS['user'] . "'");
        if($user == null and $admin == null){
            return 1;
        }elseif (isset($admin['pass']) and REQUESTS['pass'] == $admin['pass']){
            return $admin['token'];
        }else{
            if (isset($user['pass']) and REQUESTS['pass'] == $user['pass']){
                return $user['token'];
            }else{
                return 1;
            }
        }
    }
    public static function makeNewQuestion($token): string
    {
        api_lock(checkToken($token));
        $admin = DB::fetchOne('users', 'admins', "user='" . validateToken($token)->user . "'");
        api_lock($admin != null and validateToken($token)->pass == $admin['pass']);


    }

}