<?php
  require 'driver/dealer.php';
  date_default_timezone_set('Africa/Kigali');
  $action = new Action();

  $std=$_GET['student'];
  $yearr = '2019-2020';
  $y = '2019-2020,020-021';

  $sql = "SELECT * from student  where student.regnumber_student=?";
  $param = array($std);
  $stdid = $action->selectRow($sql,$param);
  $sid = $stdid['id'];

  $sql = "SELECT *,max(id_year) as acyear from student_year where id_student=?";
  $param = array($sid);
  $ac = $action->selectRow($sql,$param);
  $acyear = $ac['acyear'];
  $att_y = $acyear;

  $sql = "SELECT * from student,student_year,academic_year,class,department,faculty,to_be_paid  where student.regnumber_student=? and (academic_year.year=? OR academic_year.year=?) and student_year.id_student=student.id and student_year.id_year=academic_year.id and class.id=student_year.id_class and department.id=class.id_department and faculty.id=class.id_faculty and to_be_paid.paid_deprt=department.id and student_year.section=to_be_paid.paid_section";
  $param = array($std,'2019-2020','020-021');
  $student = $action->selectRow($sql,$param);
  $pass = false;

  if($student){
  $id = $student['id'];
  $sql="SELECT * from academic_year,tuitionfees_tobepaid where academic_year.year=? and tuitionfees_tobepaid.id_year=academic_year.id and tuitionfees_tobepaid.id_student=?";
  $param = array($yearr,$sid);
  $year = $action->selectRow($sql,$param);
  $yearid = $year['id'];
  $att_y = $yearid;
  $sql = "SELECT * from student,payment where student.regnumber_student=? and payment.id_student=student.id and payment.id_academic_year=? and payment.id_fee=0";
  $param = array($std,$yearid);
  $students = $action->selectRows($sql,$param);
  $paid = 0;
  $attendance=false;
  foreach ($students as $key => $value) {
    $paid +=$value['amount_payment'];
  }
  //============= SELECTING STUDENT MODULE
  $qry = "SELECT * FROM modules WHERE mod_class=? AND mod_date=?";
  $param = array($student['id_class'],date('Y-m-d'));
  $modules = $action->selectRow($qry,$param);

  $topay = $year['to_be_paid'];
  $due = $topay-$paid;
  $tobe = $student['paid_amount'];
  $stud = true;
$cls_level = str_replace(" ","",$student['code_class_en']);   //class level

$facult = $student['id_faculty'];
$study_program = $student['section'];

// if (substr($cls_level, 0,2)=="Y1" AND $acyear==40) {
//   if (($facult==3) OR ($facult==2) OR ($facult==4)) {     //====== EBS & Social sciences & Law

//     if ($study_program == "D") {
//       $annual_payment = 600000;
//     }else if (($study_program == "E") OR ($study_program == "W")) {
//       $annual_payment = 660000;
//     }else{
//       $annual_payment = $year['to_be_paid'];
//     }

//   }else if ($facult==1) {                     //==================== SCIENCE AND TECHNOLOGY

//     if ($study_program == "D") {
//       $annual_payment = 690000;
//     }else if (($study_program == "E")) {
//       $annual_payment = 750000;
//     }else{
//       $annual_payment = $year['to_be_paid'];
//     }

//   }else if (($facult==8) OR ($facult==9) OR ($facult==7)) {   //================ CIVIL ENGINEERING / & / ELECTRICAL, Electronics and ICT

//     if ($study_program == "D") {
//       $annual_payment = 690000;
//     }else if (($study_program == "E")) {
//       $annual_payment = 750000;
//     }else{
//       $annual_payment = $year['to_be_paid'];
//     }

//   }else{
//     $annual_payment = $year['to_be_paid'];
//   }
// }else{

//   $annual_payment = $year['to_be_paid'];
// }
//  if (($facult==8) OR ($facult==9) OR ($facult==7)) {   //================ EXCLUDING TERMS VERIFICATION ON POLYTHECNICS
//     $topay = $annual_payment;
//     $due = $topay-$paid;
//    // echo "$paid";

//   }else{

// switch (substr($cls_level, 0,2)) {          //================== CALCULATING amount to pay according to semesters & Study LEVELS
//   case 'Y1':
//     if (($facult==8) OR ($facult==9) OR ($facult==7)) {
//       $topay = $annual_payment;
//     }else{
//       if ($acyear==40) {
//         $topay = $annual_payment*2/3;
//         $due = $topay-$paid;
//       }else{
//         $topay = $year['to_be_paid']*2/3;
//         $annual_payment = $year['to_be_paid'];
//         $due = $topay-$paid;
//       }
//     }
//     break;

//   case 'Y2':
//       if ($facult == 3) {
//         if ($study_program == "D") {
//           $topay = 321000;
//         }else if ($study_program == "E") {
//           $topay = 361000;
//         }else{
//           $topay = round($annual_payment*2/3);
//         }
//       }else if (($facult == 1) OR ($facult == 2) OR ($facult == 4)) {
//         if ($study_program == "D") {
//           $topay = 401000;
//         }else if ($study_program == "E") {
//           $topay = 441000;
//         }else{
//           $topay = round($annual_payment*2/3);
//         }
//       }else{
//         $topay = round($annual_payment*2/3);
//       }
//     break;

//   default:
//       $topay = $annual_payment;
//       $due = $topay-$paid;
//     break;
// }

// }
//echo "$topay";

        if($paid>=$topay){
          $pass=true;
           $real_student = $student['id_student'];
           $module_id = $modules['mod_id'];
        }
}else{


  $sql = "SELECT *,max(id_year) as acyear from student_year where id_student=?";
  $param = array($sid);
  $ac = $action->selectRow($sql,$param);
  $acyear = $ac['acyear'];
  $att_y = $acyear;

  $sql="SELECT * from student_year,year_class,class,faculty where student_year.id_student=? and year_class.id_year=student_year.id_year and class.id=student_year.id_class and faculty.id=class.id_faculty";
  $param = array($sid);
  $student = $action->selectRow($sql,$param);
  $student['firstname_student']=$stdid['firstname_student'];
  $student['lastname_student']=$stdid['lastname_student'];
  $yearid = $student['id'];
  $st = $student['id_student'];


  if($acyear==38 or $acyear==31 or $acyear==37 or $acyear==41){
    $sql="SELECT  distinct(done_module) from masters_students,masters_modules_done where ms_rollnumber=? and done_student=ms_id";
    $param = array($stdid['regnumber_student']);
    $mods = $action->selectRows($sql,$param);
    $mods['allmod'] = count($mods);
    $amount = $mods['allmod']*160000;
    $sql = "SELECT distinct(id_academic_year) from payment where  payment.id_student=? and payment.id_fee=0";
    $param = array($st);
    $posts = $action->selectRows($sql,$param);
    $amount+=30000*count($posts);

    //============= SELECTING STUDENT MODULE
    $qry = "SELECT * FROM modules WHERE mod_class=? AND mod_date=?";
    $param = array($student['id_class'],date('Y-m-d'));
    $modules = $action->selectRow($qry,$param);
    $sql = "SELECT * from payment where  payment.id_student=? and payment.id_fee=0";
    $param = array($st);
    $students = $action->selectRows($sql,$param);
    $paid = 0;
    foreach ($students as $key => $value) {
      $paid +=$value['amount_payment'];
    }
    $topay = $amount;
    $due = $topay-$paid;
    $stud=false;
    $tobe = $topay;

    if($paid>=$amount){
      $pass=true;
      $real_student = $student['id_student'];
      $module_id = $modules['mod_id'];
    }
  }else{
    //============= SELECTING STUDENT MODULE
    $qry = "SELECT * FROM modules WHERE mod_class=? AND mod_date=?";
    $param = array($student['id_class'],date('Y-m-d'));
    $modules = $action->selectRow($qry,$param);

    $sql = "SELECT * from payment where  payment.id_student=?  and payment.id_academic_year=? and payment.id_fee=0";
    $param = array($st,$acyear);
    $students = $action->selectRows($sql,$param);
    $paid = 0;
    foreach ($students as $key => $value) {
      $paid +=$value['amount_payment'];
    }

    $sql="SELECT to_be_paid from tuitionfees_tobepaid where id_student=? and id_year=?";
    $param = array($st,$acyear);
    $tobe = $action->selectRow($sql,$param);
    $topay = $tobe['to_be_paid'];

    $cls_level = str_replace(" ","",$student['code_class_en']);   //class level

    $facult = $student['id_faculty'];
    $study_program = $student['section'];

// if ((substr($cls_level, 0,2)=="Y1") AND ($acyear=40)) {
//   if (($facult==3) OR ($facult==2) OR ($facult==4)) {     //====== EBS & Social sciences & Law

//     if ($study_program == "D") {
//       $annual_payment = 600000;
//     }else if (($study_program == "E") OR ($study_program == "W")) {
//       $annual_payment = 660000;
//     }else{
//       $annual_payment = $year['to_be_paid'];
//     }

//   }else if ($facult==1) {                     //==================== SCIENCE AND TECHNOLOGY

//     if ($study_program == "D") {
//       $annual_payment = 690000;
//     }else if (($study_program == "E")) {
//       $annual_payment = 750000;
//     }else{
//       $annual_payment = $year['to_be_paid'];
//     }

//   }else if (($facult==8) OR ($facult==9)) {   //================ CIVIL ENGINEERING / & / ELECTRICAL, Electronics and ICT

//     if ($study_program == "D") {
//       $annual_payment = 690000;
//     }else if (($study_program == "E")) {
//       $annual_payment = 750000;
//     }else{
//       $annual_payment = $year['to_be_paid'];
//     }

//   }else{
//     $annual_payment = $year['to_be_paid'];
//   }
// }else{

//   $annual_payment = $year['to_be_paid'];
// }

//  if (($facult==8) OR ($facult==9) OR ($facult==7)) {   //================ EXCLUDING TERMS VERIFICATION ON POLYTHECNICS
//     $topay = $annual_payment;
//     $due = $topay-$paid;
//     //echo "$topay";

//   }else{
// switch (substr($cls_level, 0,2)) {          //================== CALCULATING amount to pay according to semesters & Study LEVELS
//   case 'Y1':
//     if (($facult==8) OR ($facult==9) OR ($facult==7)) {
//       $topay = $annual_payment;
//     }else{
//       if ($acyear==40) {
//         $topay = $annual_payment*2/3;
//         $due = $topay-$paid;
//       }else{
//         $topay = $year['to_be_paid']*2/3;
//         $annual_payment = $year['to_be_paid'];
//         $due = $topay-$paid;
//       }
//     }
//     break;

//   case 'Y2':
//       if ($facult == 3) {
//         if ($study_program == "D") {
//           $topay = 321000;
//         }else if ($study_program == "E") {
//           $topay = 361000;
//         }else{
//           $topay = round($annual_payment*2/3);
//         }
//       }else if (($facult == 1) OR ($facult == 2) OR ($facult == 4)) {
//         if ($study_program == "D") {
//           $topay = 401000;
//         }else if ($study_program == "E") {
//           $topay = 441000;
//         }else{
//           $topay = round($annual_payment*2/3);
//         }
//       }else{
//         $topay = round($annual_payment*2/3);
//       }
//     break;

//   default:
//       $topay = $annual_payment;
//       $due = $topay-$paid;
//     break;
// }
//   }


    $due = $topay-$paid;
    $stud=false;
    $tobe = $topay;

    if($paid>=$topay){
      $pass=true;
      $real_student = $student['id_student'];
      $module_id = $modules['mod_id'];
    }
  }

}
if (isset($annual_payment)) {
  $topay = $annual_payment;
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Payment Status</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/cover/">

    <!-- Bootstrap core CSS -->
    <link href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://v4-alpha.getbootstrap.com/examples/cover/cover.css" rel="stylesheet">
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

<?php
//echo "<h1>Year: $acyear</h1>";
if($student){
  $class = $student['id_class'];
 ?>
          <div class="inner cover">
            <img src="<?= $student['student_photo']; ?>" style="width: 100px;">
            <h1 class="cover-heading">Payment</h1>
            <b><?= $student['name_faculty_en']; ?></b><br>
            <b><?= $student['name_class_en']; ?></b><br>
            <b><?php if($stud==true){echo $student['name_department_en'];} ?></b><br>
            <?php
              if($student['section']=='D'){
              $sec ='Day';
            }else if($student['section']=='W'){
              $sec ='Weekend';
            }else{
              $sec = 'Evening';
            } ?>
            <b><?= $sec; ?></b><br>
            <b>Roll Number: <?= $std; ?></b><br>
            <p class="lead">
         <?php
        if($pass){
          if($due>0){
            if(isset($mods) and $mods['allmod']==0){      //this is for masters who don;t registerd modules
              ?><div class="alert alert-danger">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! Sorry you have not yet registered your modules.
          <br>
          <br>
          <a href="https://masters.inkuge.com" target="_blank" class="btn btn-primary">Register Module</a>


        </div>
            <?php
          }else{
            ?>
            <div class="alert alert-success">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! Congraturation you have successfull cleared payment issues. Now you are allowed to access class and other school services.

          </div>
          <hr>
          You have paid  <b><?= $paid; ?> Rfw</b>. <?php if($due<0){ echo ' You have exceeded <b>'. (round($due)*-1).' Rfw</b> on ';}else{ ?>You need to pay <b><?= round($due); ?> Rfw</b> to complete <?php } ?> your schoolfees of <b><?= round($topay); ?> Rfw</b> <?php if(isset($mods) and $mods['allmod']>0){ echo ' of <b>'.$mods['allmod'].' modules</b> attended';} ?>.
               <br>For more information contact <b>DVC/AF</b>.
            <?php
          }
          }else{
            if(isset($mods) and $mods['allmod']==0){      //this is for masters who don;t registerd modules
              ?><div class="alert alert-danger">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! Sorry you have not yet registered your modules.
          <br>
          <br>
          <a href="https://masters.inkuge.com" target="_blank" class="btn btn-primary">Register Module</a>


        </div>
            <?php
          }else{
            ?>
            <div class="alert alert-success">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! Congraturation you have successfull cleared payment issues. Now you are allowed to access class and other school services.

          </div>
          <hr>
<!--  -->
            <?php
          }
          }
          $attendance= true;

        }else{
          $date = date('Y-m-d');
          $sql="SELECT * from permission where perm_student =? and perm_to>=?";
          $param = array($sid,$date);
          $perm = $action->selectRow($sql,$param);
          if($perm){
          $attendance=true;
          $real_student = $student['id_student'];
          $module_id = $modules['mod_id'];
          ?>
          <div class="alert alert-info">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! You have permission to access class and other school services only from <?= $perm['perm_from']; ?> to <?= $perm['perm_to']; ?>
        </div>
          <hr>
          <br>
           You have paid  <b><?= $paid; ?> Rfw</b>. <?php if($due<0){ echo ' You have exceeded <b>'. (round($due)*-1).' Rfw</b> on ';}else{ ?>You need to pay <b><?= round($due); ?> Rfw</b> to complete <?php } ?> your schoolfees of <b><?= round($topay); ?> Rfw</b> .
               <br>For more information contact <b>DVC/AF</b>.
          <?php
        }else{
          ?>
          <div class="alert alert-danger">
          Hello <b><?= $student['firstname_student'].' '.$student['lastname_student']; ?></b>! You don't have permission to access class and other school services.
        </div>
          <hr>
          <br>
           You have paid  <b><?= $paid; ?> Rfw</b>. <?php if($due<0){ echo ' You have exceeded <b>'. (round($due)*-1).' Rfw</b> on ';}else{ ?>You need to pay <b><?= round($due); ?> Rfw</b> to complete <?php } ?> your schoolfees of <b><?= round($topay); ?> Rfw</b> <?php if(isset($mods) and $mods['allmod']>0){ echo ' of <b>'.$mods['allmod'].' modules</b> attended';} ?> .
               <br>For more information contact <b>DVC/AF</b>.
          <?php
        }
        }
          $sql="SELECT att_id from attendance where att_student=? and att_date=?";
          $param = array($sid,date('Y-m-d'));
          $att = $action->selectRow($sql,$param);
          if(!$att){
          $sql="INSERT into attendance set att_student=?, att_date=?, att_time=?,att_year=?,att_status=?";
          date_default_timezone_set('Africa/Kigali');
          $time = date("h:i");
          $date = date("Y-m-d");
          $param = array($sid,$date,$time,$att_y,$pass);
          $atte = $action->runQuery($sql,$param);
  }
  ?>
  <br>
    <label id="response"></label>
          <?php
          if (isset($_SESSION['invigirator'])) {
         if (isset($real_student)) {

          ?>
          <input type="text" id="booklet" class="form-control" placeholder="Enter book number">
          <br>
<!--           <input type="hidden" value="<?=$real_student?>" id="student">
          <input type="hidden" value="<?=$module_id?>" id="module"> -->
          <button class="btn btn-primary" onclick="return makeAttend('<?=$real_student?>','<?=$module_id?>');">Give Attendance</button>
          <?php


          }
          }
          ?>
  <?php
  if(isset($_SESSION['invigirator']) and $pass==1){ ?>
  <div class="row">
    <div class="col-12 mx-auto">
     <!--  <a href="?takeattend=<?= $sid; ?>&year=<?= $att_y; ?>&pass=<?= $pass; ?>&class=<?= $class; ?>&section=<?= $student['id_class']; ?>" class="btn btn-primary">Give Attendance</a> -->
    </div>

  </div>
<?php } ?>


  <?php
      }else{ ?>
          <div class="alert alert-danger">
          Sorry! the QR code scanned not recoginized in our system.
        </div>
    <?php } ?>
        </div>
</p>

<?php if(isset($_GET['takeattend'])){
  $sql="SELECT att_id from attendance where att_student=? and att_date=? and att_exam=1";
          $param = array($sid,date('Y-m-d'));
          $att = $action->selectRow($sql,$param);
          if(!$att){
          $sql="INSERT into attendance set att_student=?, att_date=?, att_time=?,att_year=?,att_status=?,att_exam=?";
          date_default_timezone_set('Africa/Kigali');
          $time = date("h:i");
          $date = date("Y-m-d");
          $param = array($_GET['takeattend'],$date,$time,$_GET['year'],$_GET['pass'],1);
          $atte = $action->runQuery($sql,$param);
}
}?>

          <!-- <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="https://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div> -->

        </div>

      </div>

    </div>
<?php?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript">
  function makeAttend(student,modulee){
$( document ).ready(function() {
  var booklet = $("#booklet").val();
  //var  booklet= 0;
    $.ajax({
        url:'driver/action.php',
        method:'POST',
        data:{student:student,modulee:modulee,booklet:booklet},
        success:function(res){
            $('#response').text(res.status).addClass('alert alert-info');
            //document.getElementById("response").innerHTML=res;
        }
    })
});

}
</script>

  </body>
</html>
