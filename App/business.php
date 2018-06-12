<?php

namespace App;

class business {

    public static function getDb() {

        $db = new \PDO("mysql:host=localhost;dbname=bkdwebdev", "root", "");
        return $db;
    }

}

?>