<?php require 'dealer.php'; ?>
<?php 
$response = array();
$action = new Action();
if(isset($_POST['faculty'])){
	?>
<option></option>
<?php 
$sql="SELECT * from department where id_faculty=?";
$param = array($_POST['faculty']);
$facults = $action->selectRows($sql,$param);
foreach ($facults as $fac) {
?>
<option value="<?= $fac['id']; ?>"><?= $fac['name_department_en']; ?></option>
<?php } 
}

if(isset($_POST['department'])){
	?>
<option></option>
<?php 
$sql="SELECT * from class where id_department=?";
$param = array($_POST['department']);
$facults = $action->selectRows($sql,$param);
foreach ($facults as $fac) {
?>
<option value="<?= $fac['id']; ?>"><?= $fac['name_class_en']; ?></option>
<?php } 
}?>