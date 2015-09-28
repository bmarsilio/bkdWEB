<?php

namespace App;

class business {

    public static function getDb() {

        $db = new \PDO("pgsql:host=192.168.33.11;dbname=bkdweb", "postgres", "123456");
        return $db;
    }

}

?>