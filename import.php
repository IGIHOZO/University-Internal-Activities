<?php 
$conn = mysqli_connect('localhost','u4ezgg6xw5d8v','inkugechurch123','dbj2xatqktawv9');
$filename = 'backup/backup.sql';

$handle = fopen($filename, "r+");
$contents = fread($handle,filesize($filename));

$sql = explode(';', $contents);
foreach ($sql as $query) {
	$result = mysqli_query($conn,$query);
	if($result){
		echo '<tr><td><br></td></tr>';
		echo '<tr><td>'.$query.'<b>SUCCESS</b></td></tr>';
		echo '<tr><td><br></td></tr>';

	}
}
fclose($handle);
echo "Imported";
?>