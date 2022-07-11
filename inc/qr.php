<?php 
	require '../driver/dealer.php';
	$action = new Action(); 
	header("Content-type:application/json");
	if(isset($_POST['reg'])){
	$reg = $_POST['reg'];
	$sts = array();
	$sql = "SELECT * from student  where regnumber_student=?";
	$param = array($reg);
	$std = $action->selectRow($sql,$param);
	if($std){
		$stdreg = $std['regnumber_student'];
		$stdname = $std['firstname_student'].' '.$std['lastname_student'];
		$sts['found']='yes';
		$sts['reg']=$stdreg;
		$sts['names']=$stdname;
	}else{
		$sts['found']='no';
	}
}else{
	$reg = $_POST['phone'];
	$sts = array();
	$sql = "SELECT * from employees  where emp_names like'%$reg%'";
	$param = array($reg);
	$std = $action->selectRow($sql,$param);
	if($std){
		$stdreg = $std['emp_id'];
		$stdname = $std['emp_names'];
		$sts['found']='yes';
		$sts['reg']=$stdreg;
		$sts['names']=$stdname;
	}else{
		$sts['found']='no';
	}
	}
	echo json_encode($sts);
?>