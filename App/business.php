<?php

namespace App;

class business {

    public static function getDb() {

        $db = new \PDO("pgsql:host=localhost;dbname=bkdwebdev", "postgres", "123456");
        return $db;
    }

}

?>