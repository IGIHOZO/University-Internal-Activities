<!DOCTYPE html>
<html lang="en">
<?php require 'driver/dealer.php';
$action = new Action(); ?>

<?php 

if(isset($_SESSION['user'])){
  $sql = "SELECT * from user  where id=?";
  $param = array($_SESSION['user']);
  $stdid = $action->selectRow($sql,$param);
  echo $stdid['nom_user'].' '.$stdid['prenom_user'];
}
?>
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
  <style type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"></style>
</head>

<body class="dark-edition">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="black" data-image="assets/img/sidebar-2.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
        
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active">
            <a class="nav-link" href="index">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./scan">
              <i class="material-icons">person</i>
              <p>Scan</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./all_students">
              <i class="material-icons">supervisor_account</i>
              <p>All Students</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./qr">
              <i class="material-icons">supervisor_account</i>
              <p>Print</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./payment">
              <i class="material-icons">supervisor_account</i>
              <p>Payment</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./permissions">
              <i class="material-icons">supervisor_account</i>
              <p>Permissions</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./attendance_student">
              <i class="material-icons">supervisor_account</i>
              <p>Attendance</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./modules">
              <i class="material-icons">supervisor_account</i>
              <p>Exam Module</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./exam_attendance">
              <i class="material-icons">supervisor_account</i>
              <p>Exam Attendance</p>
            </a>
          </li>
          <!-- <li class="nav-item ">
            <a class="nav-link" href="./typography.html">
              <i class="material-icons">library_books</i>
              <p>Typography</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./icons.html">
              <i class="material-icons">bubble_chart</i>
              <p>Icons</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./map.html">
              <i class="material-icons">location_ons</i>
              <p>Maps</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./notifications.html">
              <i class="material-icons">notifications</i>
              <p>Notifications</p>
            </a>
          </li> -->
          <!-- <li class="nav-item active-pro ">
                <a class="nav-link" href="./upgrade.html">
                    <i class="material-icons">unarchive</i>
                    <p>Upgrade to PRO</p>
                </a>
            </li> -->
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:void(0)">Payment</a>
          </div>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="javscript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="javascript:void(0)">Settings</a>
                  <a class="dropdown-item" href="?logout">Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <?php 
      if(isset($_GET['logout'])){
        session_destroy();
          echo '<script type="text/javascript">window.location="login";</script>';
      }
      ?>
      <!-- End Navbar -->