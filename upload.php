<?php require 'driver/dealer.php';
$action = new Action(); 
if(isset($_FILES['file']['name'])){
	$files = $_FILES['file']['name'];
	$n=0;
	foreach ($files as $key => $value) {
		$file = $_FILES['file']['name'][$key];
		$name = explode('.', $file);
		$name = $name[0];
		$name = str_replace(" ", '', $name);
		$sql="SELECT * from student where regnumber_student=? and student_photo!=''";
		$param = array($name);
		$stud = $action->selectRow($sql,$param);
		
		$photo = 'card/photos/'.$_FILES['file']['name'][$key];
		$uplod = move_uploaded_file($_FILES['file']['tmp_name'][$key], $photo);
		echo $uplod;
		if($uplod){

		$sql="UPDATE student set student_photo=? where regnumber_student=?";
		$param = array($photo,$name);
		$stud = $action->runQuery($sql,$param);
		}
	
	}
}else{
	echo 'no';
}

?>

<form method="post" enctype="multipart/form-data">
	<input type="file" multiple="" name="file[]">
	<button>Upload</button>
</form>