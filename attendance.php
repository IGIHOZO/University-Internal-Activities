<?php require 'driver/dealer.php';
  $action = new Action(); 
  $sid=$_GET['employee'];
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
  if($t>0){
    $sql="UPDATE em_attendance set attend_left_date=?,attend_left_time=?,attend_left=? where attend_id=?";
    $param = array($date,$time,1,$att['attend_id']);
    $action->runQuery($sql,$param);
    $left = true;
  }
  }
  $sql="SELECT * from employees where emp_id=?";
  $param = array($sid);
  $att = $action->selectRow($sql,$param);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Employee Attendance</title>
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

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">ULK</h3>
              
            </div>
          </div>

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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
