<?php 
@session_destroy();
  require 'driver/dealer.php';
  date_default_timezone_set('Africa/Kigali');
  $action = new Action();

  $sql = "SELECT * from student_year,modules,exam_attendance where mod_class=71 and student_year.id_student=attendance_student and student_year.id_class=mod_class";
  $param = array();
  $student = $action->selectRows($sql,$param);
  echo count($student);
foreach ($student as $key => $value) {
$sql="UPDATE exam_attendance set attendance_module=8 where attendance_id=?";
$param = array($value['attendance_id']);
$action->runQuery($sql,$param);
}