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
        DB::newTable('q_bank', 'questions', ['name', 'id', 'lesson', 'keyword', 'designer',
             'title_text', 'title_img',
             'o1_text', 'o1_img',
             'o2_text', 'o2_img',
             'o3_text', 'o3_img',
             'o4_text', 'o4_img',
             ]);
        DB::makeUnique('q_bank', 'questions', 'id');

    }
    public static function doSignUp(): string | int
    {
        api_textOutput();
        if(!isset($_POST['user'], $_POST['pass'], $_POST['firstname'], $_POST['lastname'])){
            return -1;
        }
        $user = DB::fetchOne('users', 'users', "user='" . $_POST['user'] . "'");
        if($user == null){
            $token = createToken(['user' => $_POST['user'], 'pass' => $_POST['pass']]);
            DB::insert('users', 'users', [$_POST['user'], $_POST['pass'], $token, $_POST['firstname'], $_POST['lastname']]);
            return $token;
        }else{
            return 1;
        }
    }
    public static function doLogin(): string | int
    {
        if(!isset($_POST['user'], $_POST['pass'])){
            return -1;
        }
        $user = DB::fetchOne('users', 'users', "user='" . $_POST['user'] . "'");
        $admin = DB::fetchOne('users', 'admins', "user='" . $_POST['user'] . "'");
        if($user == null and $admin == null){
            return 1;
        }elseif (isset($admin['pass']) and $_POST['pass'] == $admin['pass']){
            api_jsonOutput();
            return json_encode([
                'token' => $admin['token'],
                'role' => 'admin',
            ]);
        }else{
            if (isset($user['pass']) and $_POST['pass'] == $user['pass']){
                api_jsonOutput();
                return json_encode([
                    'token' => $user['token'],
                    'role' => 'user',
                ]);
            }else{
                api_textOutput();
                return 1;
            }
        }
    }
    public static function makeNewQuestion($token): string
    {
        api_lock(checkToken($token));
        $admin = DB::fetchOne('users', 'admins', "user='" . validateToken($token)->user . "'");
        api_lock($admin != null and validateToken($token)->pass == $admin['pass']);
        $_SESSION['p'] = $_POST;
        $_SESSION['f'] = $_FILES;
        if(!isset($_POST['name'], $_POST['lesson'], $_POST['keyword'], $_POST['designer'])){
            return -1;
        }
        if(!isset($_POST['title_text']) and !isset($_FILES['title_img'])){
            return -1;
        }
        if(!isset($_POST['o1_text']) and !isset($_FILES['o1_img'])){
            return -1;
        }
        if(!isset($_POST['o2_text']) and !isset($_FILES['o2_img'])){
            return -1;
        }
        if(!isset($_POST['o3_text']) and !isset($_FILES['o3_img'])){
            return -1;
        }
        if(!isset($_POST['o4_text']) and !isset($_FILES['o4_img'])){
            return -1;
        }
        $title_text = '';
        $title_img = '';
        $o1_text = '';
        $o2_text = '';
        $o3_text = '';
        $o4_text = '';
        $o1_img = '';
        $o2_img = '';
        $o3_img = '';
        $o4_img = '';

        if(isset($_POST['title_text'])){
            $title_text = $_POST['title_text'];
        }
        if(isset($_FILES['title_img'])){
            $file_name = 'title_' . uniqid() . '.jpg';
            if(storage_uploadImage($file_name,$_FILES['title_img']) == 0){
                $title_img = $file_name;
            }
        }
        if(isset($_POST['o1_text'])){
            $o1_text = $_POST['o1_text'];
        }
        if(isset($_FILES['o1_img'])){
            $file_name = 'o1_' . uniqid() . '.jpg';
            if(storage_uploadImage($file_name,$_FILES['o1_img']) == 0){
                $o1_img = $file_name;
            }
        }
        if(isset($_POST['o2_text'])){
            $o2_text = $_POST['o2_text'];
        }
        if(isset($_FILES['o2_img'])){
            $file_name = 'o2_' . uniqid() . '.jpg';
            if(storage_uploadImage($file_name,$_FILES['o2_img']) == 0){
                $o2_img = $file_name;
            }
        }
        if(isset($_POST['o3_text'])){
            $o3_text = $_POST['o3_text'];
        }
        if(isset($_FILES['o3_img'])){
            $file_name = 'o3_' . uniqid() . '.jpg';
            if(storage_uploadImage($file_name,$_FILES['o3_img']) == 0){
                $o3_img = $file_name;
            }
        }
        if(isset($_POST['o4_text'])){
            $o4_text = $_POST['o4_text'];
        }
        if(isset($_FILES['o4_img'])){
            $file_name = 'o4_' . uniqid() . '.jpg';
            if(storage_uploadImage($file_name,$_FILES['o4_img']) == 0){
                $o4_img = $file_name;
            }
        }
        DB::insert('q_bank', 'questions', [$_POST['name'], uniqid(),
            $_POST['lesson'], $_POST['keyword'], $_POST['designer'],
            $title_text, $title_img,
            $o1_text, $o1_img,
            $o2_text, $o2_img,
            $o3_text, $o3_img,
            $o4_text, $o4_img,
        ]);
        return 0;
    }

}