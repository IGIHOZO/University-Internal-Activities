<?php require 'dealer.php'; ?>
<?php 
header("Content-type:text/json");
$response = array();
$action = new Action();

if(isset($_POST['payment'])){
	$sql = "SELECT * from student  where student.regnumber_student=?";
	$param = array($_POST['reg']);
	$stdid = $action->selectRow($sql,$param);
	$sid = $stdid['id'];

	$sql = "SELECT * from payment order by id desc limit 1";
	$param = array();
	$stdid = $action->selectRow($sql,$param);
	$next = $stdid['id']+1;
	$sql="INSERT into payment set id=?,id_student=?, id_academic_year=?,id_bank=?,slip_payment=?,date_payment=?,date_recording=?,amount_payment=?,comment_payment=?,id_user=?";
	$param = array($next,$sid,$_POST['year'],$_POST['bank'],$_POST['slip'],$_POST['paid'],$_POST['recording'],$_POST['amount'],$_POST['comment'],$_SESSION['user']);
	$payment = $action->runQuery($sql,$param);
	if($payment){
		$response['status']='successful';
	}else{
		$response['status']='fail';
	}
	echo json_encode($response);
}

if(isset($_POST['login'])){
	if($_POST['type']==1){
		$sql = "SELECT * from user  where login_user=? and password_user=?";
		$pass = crypt($_POST['password'],12);
		$param = array($_POST['username'],$pass);
		$stdid = $action->selectRow($sql,$param);
		$sid = $stdid['id'];
		$_SESSION['user']=$sid;
		if($sid){
			$response['status']='successful';
			$response['page']='payment';
		}else{
			$response['status']='fail';
		}
	}else{
		$sql = "SELECT * from users  where u_user=? and u_pass=?";
		$pass = crypt($_POST['password'],12);
		$param = array($_POST['username'],$pass);
		$stdid = $action->selectRow($sql,$param);
		$sid = $stdid['u_id'];
		$_SESSION['users']=$sid;
		$_SESSION['type']=$stdid['u_type'];
		if($sid){
			$response['status']='successful';
			if($stdid['u_type']==2){
				$response['page']='scan';
			}
			else if($stdid['u_type']==3){
				$_SESSION['print']=true;
				$response['page']='qr';
			}
			else if($stdid['u_type']==4){
				$_SESSION['invigirator']=true;
				$response['page']='logged';
			}else{
				$response['page']='permissions';
				$_SESSION['finance']=true;
			}
		}else{
			$response['status']='fail';
		}
	}
	echo json_encode($response);
}
if(isset($_POST['permission'])){
	$sql = "SELECT * from student  where student.regnumber_student=?";
	$param = array($_POST['reg']);
	$stdid = $action->selectRow($sql,$param);
	$sid = $stdid['id'];

	$sql="INSERT into permission set perm_student=?, perm_year=?,perm_from=?,perm_to=?,perm_comment=?";
	$param = array($sid,$_POST['year'],$_POST['from'],$_POST['to'],$_POST['comment']);
	$payment = $action->runQuery($sql,$param);
	if($payment){
		$response['status']='successful';
	}else{
		$response['status']='fail';
	}
	echo json_encode($response);
}
if(isset($_POST['module'])){
	$sql="INSERT into modules set mod_name=?, mod_code=?,mod_faculty=?,mod_depart=?,mod_class=?,mod_section=?,mod_date=?";
	$param = array($_POST['name'],$_POST['code'],$_POST['faculty'],$_POST['department'],$_POST['class'],$_POST['section'],$_POST['date']);
	$payment = $action->runQuery($sql,$param);
	if($payment){
		$response['status']='successful';
	}else{
		$response['status']='fail';
	}
	echo json_encode($response);
}

if (isset($_POST['student']) && isset($_POST['modulee'])) {
            //============= VERFYING IF ARLEADY ATTENDED
			$module_id =  $_POST['modulee'];
			$real_student = $_POST['student'];
			$boooklet = $_POST['booklet'];
            $cnt_qry = "SELECT * FROM exam_attendance WHERE attendance_module = ? AND attendance_student = ? AND attendance_exam_time = ? AND attendance_status = ?";
            $cnt_param = array($module_id,$real_student,date('Y-m-d'),"E");
            $cnt_attendance = $action->selectRow($cnt_qry,$cnt_param);  
            //$number_of_att = $cnt_attendance['num_att'];
             		//echo $cnt_attendance;

            if (!$cnt_attendance) {
              //============= RECORD EXAM ATTENDANCE
              $qryyy = "INSERT INTO exam_attendance(attendance_module,attendance_student,attendance_exam_time,attendance_booklet,attendance_status) VALUES(?,?,?,?,?)";
              $paramm = array($module_id,$real_student,date('Y-m-d'),$boooklet,"E");
              $attendance = $action->executeQuery($qryyy,$paramm);
             	if ($attendance) {
		$response['status']='attendance done !';
             	}else{
		$response['status']='attendance not recorded ...';
             	}
            }else{
		$response['status']='Arleady attednded !';
            }
            echo json_encode($response);
}else{
	//echo "Noooo";
}
?>
