<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=pos",
			            "jose",
			            "dinamita2008");

		$link->exec("set names utf8");

		return $link;

	}

}
