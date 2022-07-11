<?php
$file = $_POST['name'];
if (!file_exists('../student_cards/')) {
  	$folder = mkdir('../student_cards/', 0777, true);
}else{
	$folder = '../student_cards/';
}
$image = $_POST['image'];
$image = explode(";",$image)[1];
$image = explode(",",$image)[1];
$image = str_replace(" ", "+", $image);
$image = base64_decode($image);
file_put_contents($folder.'/'.$file.".jpeg", $image);
echo "done";
?>