<?php


class DB
{
    public static function setup(): void
    {
        if(!file_exists(path("engine/database/main.db"))){
            $_SESSION['db_ext'] = 1;
        }
        $db = new PDO("sqlite:" . path("engine/database/main.db"));
        $db->exec("CREATE TABLE IF NOT EXISTS main(a, b);");
        DB::makeUnique('main',"main", 'a');
    }

    public static function newDB($db): void
    {
        $db = new PDO("sqlite:" . path("engine/database/$db.db"));
    }
    public static function newTable($db, $name, array $prm): void
    {
        $db = new PDO("sqlite:" . path("engine/database/$db.db"));
        $sql = "CREATE TABLE IF NOT EXISTS $name (";
        foreach ($prm as $key => $row) {
            $sql .= $row;
            if($key < count($prm) - 1){
                $sql .= ", ";
            }
        }
        $sql .= ");";
        $db->exec($sql);
    }

    public static function insert($db, $name, array $prm): void{
        $db = new PDO("sqlite:" . path("engine/database/$db.db"));
        $sql = "INSERT OR REPLACE INTO $name VALUES(";
        foreach ($prm as $key => $row) {
            $sql .= "'" . $row . "'";
            if($key < count($prm) - 1){
                $sql .= ", ";
            }
        }
        $sql .= ");";
        $db->exec($sql);
    }
    public static function fetchOne($db, $tbl, $prm){
        $db = new PDO("sqlite:" . path("engine/database/$db.db"));
        foreach ($db->query("SELECT * FROM $tbl WHERE $prm") as $row) {
           return $row;
           break;
        }
    }
    public static function makeUnique($db, $tbl, $col): void{
        try {
            $db = new PDO("sqlite:" . path("engine/database/$db.db"));
            $db->exec("CREATE UNIQUE INDEX '$col' ON $tbl($col)");
        }catch (Exception $e){

        }
    }
    public static function set($db, $key, $val){
        DB::insert($db, 'main', [$key, $val]);
    }
    public static function get($db, $key){
        return DB::fetchOne($db, 'main', "a='$key'")['b'];
    }
}