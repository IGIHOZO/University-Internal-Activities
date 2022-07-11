<?php 
class Database{
	public static function connect(){
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=cards','root','');
			return $pdo;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}
?>