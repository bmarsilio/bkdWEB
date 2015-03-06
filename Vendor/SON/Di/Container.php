<?php

namespace SON\Di;

class Container
{
	public static function getClass($name)
	{
		$str_class = "\\App\\Models\\".ucfirst($name);

		$class = new $str_class(\App\Init::getDb());

		return $class;
	}

	public static function trataData($data)
	{
		if(strpos($data,'/') > 0){
			$resultado = implode( '-', array_reverse( explode( '/', $data ) ) );
		}else{
			$resultado = implode( '/', array_reverse( explode( '-', $data ) ) );
		}

		return $resultado;
	}
}