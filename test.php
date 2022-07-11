<?php 
$cookie_name = "user";
$cookie_value = "gate";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>
<html>
<body>

<?php
if(!isset($_COOKIE[$cookie_name])) {
  echo "Cookie named '" . $cookie_name . "' is not set!";
  ?>
<script type="text/javascript">
	function login(){
	var pass = prompt("Please enter password");
	if(pass=='amarembo123!'){
		alert('Ok');
	}else{
		alert('Invalid password. Please try again.');
		login();
	}
}
login();
</script>
  <?php
} else {
  echo "Cookie '" . $cookie_name . "' is set!<br>";
  echo "Value is: " . $_COOKIE[$cookie_name];
}
?>

</body>
</html> 
