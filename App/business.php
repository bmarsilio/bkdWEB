<?php

namespace App;

class business
{
	public static function getDb()
	{

		$db = new \PDO("pgsql:host=localhost;dbname=bkdwebdev","postgres","1234567");

		return $db;
	}
}
?>