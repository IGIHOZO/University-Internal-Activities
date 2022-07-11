<?php session_start(); require 'config.php'; ?>
<?php 
error_reporting();
$msg = array();
class Action extends Database{
	function runQuery($query,$params){
		$db = parent::connect();
		$data  = $db->prepare($query);
		foreach ($params as $key => $value) {
			$data->bindValue($key+1,$value);
		}
		$data->execute();
		return $data;
	}
	function isValidImage($file){
		$allowed = array('jpg','png','jpeg','bmp','gif');
		$ext = explode('.', $file);
		$ext = end($ext);
		$ext = strtolower($ext);
		$f=false;
		if(in_array($ext, $allowed)){
			$f = uniqid().'.'.$ext;
		}
		return $f;
	}
	public function selectRow($query,$param){
		$db=$this->connect();
		$fetch=$db->prepare($query);
		foreach ($param as $key => $value) {
			$fetch->bindValue($key+1,$value);
		}
		$fetch->execute();
		return $fetch->fetch();
	}
	public function selectRows($query,$param){
		$db=$this->connect();
		$fetch=$db->prepare($query);
		foreach ($param as $key => $value) {
			$fetch->bindValue($key+1,$value);
		}
		$fetch->execute();
		return $fetch->fetchAll();
	}
	public function executeQuery($query,$param){
		$pdo=$this->connect();
		$insert = $pdo->prepare($query);
		foreach ($param as $key => $value) {
			$key=$key+1;
			$insert->bindValue($key,$value);
		}
		$insert->execute();
		return true;
	}
	public function generateCode(){	
		$str = "qwertyuiopasdfghjklzxcvbnm1234567890";
		$newstr = strtoupper(substr(str_shuffle($str), 0,6));
		$code = 'TBL/'.$newstr;
		return $code;
	}
}
?>
