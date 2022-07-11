<?php 
	$reg = $_POST['reg'];
	$regi = explode('=', $reg);
	$std = end($regi);
	$type = explode('?',$reg);
	$type = end($type);
	$type = explode('=', $type);
	$type = $type[0];
	$pass=false;
	require '../driver/dealer.php';
	$action = new Action(); 
	if($type=='student'){
	$yearr = '2019-2020';

	$sql = "SELECT * from student  where student.regnumber_student=?";
	$param = array($std);
	$stdid = $action->selectRow($sql,$param);
	$sid = $stdid['id'];

	$sql = "SELECT * from student,student_year,academic_year,class,department,faculty,to_be_paid  where student.regnumber_student=? and academic_year.year=? and student_year.id_student=student.id and student_year.id_year=academic_year.id and class.id=student_year.id_class and department.id=class.id_department and faculty.id=class.id_faculty and to_be_paid.paid_deprt=department.id and student_year.section=to_be_paid.paid_section";
	$param = array($std,'2019-2020');
	$student = $action->selectRow($sql,$param);
	if($student){
	$id = $student['id'];
	$sql="SELECT * from academic_year,tuitionfees_tobepaid where academic_year.year=? and tuitionfees_tobepaid.id_year=academic_year.id and tuitionfees_tobepaid.id_student=?";
	$param = array($yearr,$sid);
	$year = $action->selectRow($sql,$param);
	$yearid = $year['id'];

	$sql = "SELECT * from student,payment where student.regnumber_student=? and payment.id_student=student.id and payment.id_academic_year=? and payment.id_fee=0";
	$param = array($std,$yearid);
	$students = $action->selectRows($sql,$param);
	$paid = 0;
	$attendance=false;
	foreach ($students as $key => $value) {
		$paid +=$value['amount_payment'];
	}
	$topay = $year['to_be_paid'];
	$due = $topay-$paid;
	$tobe = $student['paid_amount'];
	$stud = true;
        if($due<$tobe){
        	$pass=true;
        }
}else{
	$sql = "SELECT *,max(id_year) as acyear from student_year where id_student=?";
	$param = array($sid);
	$ac = $action->selectRow($sql,$param);
	$acyear = $ac['acyear'];
	$sql="SELECT * from student_year,year_class,class,faculty where student_year.id_student=? and year_class.id_year=student_year.id_year and class.id=student_year.id_class and faculty.id=class.id_faculty";
	$param = array($sid);
	$student = $action->selectRow($sql,$param);
	$student['firstname_student']=$stdid['firstname_student'];
	$student['lastname_student']=$stdid['lastname_student'];
	$yearid = $student['id'];

	$sql = "SELECT * from student,payment where student.regnumber_student=? and payment.id_student=student.id and payment.id_academic_year=? and payment.id_fee=0";
	$param = array($std,$acyear);
	$students = $action->selectRows($sql,$param);
	$paid = 0;
	$attendance=false;
	foreach ($students as $key => $value) {
		$paid +=$value['amount_payment'];
	}
	$topay = $student['amount_weekend'];
	$due = $topay-$paid;
	$stud=false;
	$tobe = $topay;
        if($due==0){
        	$pass=true;
        }
}
?>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">
<?php if($student){ ?>
          <div class="inner cover">
          	<img src="<?= $student['student_photo']; ?>" style="width: 100px;">
            <h1 class="cover-heading">Payment</h1>
            <b><?= $student['name_faculty_en']; ?></b><br>
            <b><?= $student['name_class_en']; ?></b><br>
            <b><?php if($stud==true){echo $student['name_department_en'];} ?></b><br>
            <?php if($stud){ if($student['section']=='D'){
            	$sec ='Day';
            }else{
            	$sec = 'Evening';
            } ?>
            <b><?= $sec; ?></b><br>
        <?php } ?>
            <b>Roll Number: <?= $std; ?></b><br>
            <p class="lead">
				 <?php 
        if($pass){
        	$attendance=true;
          ?>
          <div class="alert alert-success">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! Congraturation you have successfull cleared payment issues. Now you are allowed to access class and other school services.
            
          </div>
          <hr>
          <?php
          if($due!=0){
            ?>
          You have paid  <b><?= $paid; ?> Rfw</b>. You need to pay <b><?= $due; ?> Rfw</b> to complete your schoolfees of <b><?= $topay; ?> Rfw</b> .
          <br>For more information contact <b>DVC/AF</b>.
            <?php
          }
          $attendance= true;
        }else{
          $date = date('Y-m-d');
          $sql="SELECT * from permission where perm_student =? and perm_to>=?";
          $param = array($sid,$date);
          $perm = $action->selectRow($sql,$param);
          if($perm){
        	$attendance=true;
          ?>
          <div class="alert alert-info">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! You have permission to access class and other school services only from <?= $perm['perm_from']; ?> to <?= $perm['perm_to']; ?>
        </div>
          <hr>
          <br>
           You have paid  <b><?= $paid; ?> Rfw</b>. You need to pay <b><?= $due; ?> Rfw</b> to complete your schoolfees of <b><?= $topay; ?> Rfw</b> .
               <br>For more information contact <b>DVC/AF</b>.
          <?php
        }else{
          ?>
          <div class="alert alert-danger">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! You don't have permission to access class and other school services.
        </div>
          <hr>
          <br>
           You have paid  <b><?= $paid; ?> Rfw</b>. You need to pay <b><?= $due; ?> Rfw</b> to complete your schoolfees of <b><?= $topay; ?> Rfw</b> .
               <br>For more information contact <b>DVC/AF</b>.
          <?php
        }
        }
if($attendance){
	$sql="SELECT att_id from attendance where att_student=? and att_date=?";
	$param = array($sid,date('Y-m-d'));
	$att = $action->selectRow($sql,$param);
	if(!$att){
	$sql="INSERT into attendance set att_student=?, att_date=?, att_time=?";
	date_default_timezone_set('Africa/Kigali');
 	$time = date("h:i");
 	$date = date("Y-m-d");
	$param = array($sid,$date,$time);
	$atte = $action->runQuery($sql,$param);
	}
}
        ?></p>
            <p class="lead">
              <a href="#" class="btn btn-lg btn-secondary">Contact</a>
            </p>
          </div>

          <!-- <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="https://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div> -->
<?php }else{ ?>

          <div class="alert alert-danger">
          Sorry! the QR code scanned not recoginized in our system.
        </div>
    <?php } ?>
        </div>

      </div>

    </div>
<?php }else{ 

 $sid=$std;
  $sql="SELECT * from em_attendance where attend_emp=? and attend_date=?";
  $param = array($sid,date('Y-m-d'));
  $att = $action->selectRow($sql,$param);
    $left = false;
  if(!$att){
  $sql="INSERT into em_attendance set attend_emp=?, attend_date=?, attend_time=?";
  date_default_timezone_set('Africa/Kigali');
  $time = date("h:i");
  $date = date("Y-m-d");
  $param = array($sid,$date,$time);
  $atte = $action->runQuery($sql,$param);
  }
  if($att and $att['attend_left']==0){
  date_default_timezone_set('Africa/Kigali');
  $time = date("h");
  $h = explode(':', $att['attend_time']);
  $h = $h[0];
  $t = $time-$h;
  $time = date("h:i");
  $date = date("Y-m-d");
    $left = true;
  if($t>0){
    $sql="UPDATE em_attendance set attend_left_date=?,attend_left_time=?,attend_left=? where attend_id=?";
    $param = array($date,$time,1,$att['attend_id']);
    $action->runQuery($sql,$param);
  }
  }
  $sql="SELECT * from employees where emp_id=?";
  $param = array($sid);
  $att = $action->selectRow($sql,$param);

?>
   <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="inner cover">
          	<img src="logo.png" style="width: 100px;">
            <h1 class="cover-heading">Attendance</h1>
            <p class="lead">
				 <b><?= $att['emp_names']; ?></b><br>
            <b><?= $att['emp_function']; ?></b><br>
            <b><?= $att['emp_phone']; ?></b><br>
          <div class="alert alert-success">
            <?php if($left){ ?>
          Hello <b><?= $att['emp_names']; ?></b>! You are successful attended for today. <hr> Please remember to tap agian where you leave the campus to confirm your attendance.
          <?php }else{ ?>
          Hello <b><?= $att['emp_names']; ?></b>! You are successful attended for today.
          <hr>
          Thanks you! Hope to see you again.
        <?php } ?>
          </div>
          </div>

          <!-- <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="https://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div> -->

        </div>

      </div>

    </div>
<?php } ?>