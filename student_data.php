<?php
require 'driver/dealer.php';
date_default_timezone_set('Africa/Kigali');
$action = new Action();
$std=$_GET['student'];

$sql = "SELECT * from student  where student.regnumber_student=?";
$param = array($std);
$stdid = $action->selectRow($sql,$param);
$sid = $stdid['id'];

$sql = "SELECT *,max(id_year) as acyear from student_year where id_student=?";
$param = array($sid);
$ac = $action->selectRow($sql,$param);
$acyear = $ac['acyear'];
$att_y = $acyear;
$sqll = "SELECT * from student,student_year,academic_year,class,department,faculty,to_be_paid  where student.regnumber_student=? and student_year.id_student=student.id and student_year.id_year=academic_year.id and class.id=student_year.id_class and department.id=class.id_department and faculty.id=class.id_faculty and to_be_paid.paid_deprt=department.id and student_year.section=to_be_paid.paid_section";
$param = array($std);
$student = $action->selectRow($sql,$param);
if ($student){
    echo "<table>";
    echo "<tr>";
    echo "<td>Roll-number</td><td>First-Name</td><td>Last-Name</td><td>Facult</td><td>Department</td><td>Section</td><td>Ac-Year</td>";
    while ($row = $sqll->) {
        $section = "";
        switch ($row['paid_section']){
            case "D":
                $section = "Day";
                break;
            case "W":
                $section = "Week";
                break;
            case "E":
                $section = "Evening";
                break;
            default:
                $section = "-";

        }
        echo "<tr>";

        echo "<td>". $row['roll_number'] ."</td>";
        echo "<td>". $row['firstname_student'] ."</td>";
        echo "<td>". $row['lastname_student'] ."</td>";
        echo "<td>". $row['name_faculty_en'] ."</td>";
        echo "<td>". $row['name_department_en'] ."</td>";
        echo "<td>". $row['year'] ."</td>";
        echo "<td>". $section ."</td>";
//        echo "<td>". $row['year'] ."</td>";

        echo "</tr>";
    }
}else{
    echo "<div style=\"text-align: center;\"><h1>Student not found ...</h1></div>";
}

?>