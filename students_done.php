<?php require 'driver/dealer.php'; 
$action = new Action();
    $sql="SELECT * from masters_students,masters_modules_done,masters_faculties,masters_modules where ms_id=done_student and modules_id=done_module and facult_id=modules_facult group by ms_id";
    $param = array();
    $year = $action->selectRows($sql,$param);
    $n = 0;
?>
<center><h2>Master's Studnts and Modules done</h2></center>
 <table class="table" cellpadding="3" cellspacing="0" border="1">
  <thead class=" text-primary">
  <td>#</td>
  <th>Name</th>
  <th>Roll Number</th>
  <th>Faculty</th>
  <th>Class</th>
  <th>Modules</th>
  </thead>
  <?php 
foreach ($year as $std) {
	$n+=1;
?>
<tr>
  <td><?= $n; ?></td>
  <td><?= $std['ms_names']; ?></td>
  <td><?= $std['ms_rollnumber']; ?></td>
  <td><?= $std['facult_name']; ?></td>
  <td><?= $std['ms_classes']; ?></td>
  <td>
  	<?php 
 $sql="SELECT * from masters_modules,masters_modules_done where done_student=? and modules_id=done_module group by done_module";
    $param = array($std['ms_id']);
    $mods = $action->selectRows($sql,$param);
    $r=0;
	foreach ($mods as $k) {
		$r+=1;
		echo $r.'. '.$k['modules_name'].'<br>';
	}
  	?>

  </td>

</tr>
<?php } ?>