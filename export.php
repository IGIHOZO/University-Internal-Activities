<?php 
$conn = mysqli_connect('localhost','u4ezgg6xw5d8v','inkugechurch123','dbj2xatqktawv9');

//get all tables

$tables = array();
$result = mysqli_query($conn,"SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
	$tables[] = $row[0];
}

$return = '';
foreach ($tables as $table) {
	$result = mysqli_query($conn, "SELECT * FROM ".$table);
	$num_fields = mysqli_num_fields($result);

	$return .='TRUNCATE TABLE '.$table.';';
	$row2 = mysqli_fetch_row(mysqli_query($conn,'SHOW CREATE TABLE '.$table));
	$return .="\n\n".$row2[1]."\n\n";

	for ($i=0; $i < $num_fields; $i++) { 
		while ($row = mysqli_fetch_row($result)) {
			$return .='INSERT INTO '.$table.' VALUES(';
			for ($j=0; $j <$num_fields ; $j++) { 
				$row[$j] = addslashes($row[$j]);
				if(isset($row[$j])){ $return .='"'.$row[$j].'"';}else{$return .='""';}
				if($j<$num_fields-1){$return .=', ';}
			}
			$return .= ");\n";
		}
	}
	$return .= "\n\n\n";
}
$file = 'backup/backup.sql';
if(file_exists($file)){
	unlink($file);
}
$handle = fopen($file,'w+');
fwrite($handle, $return);
$fin = fclose($handle);
if($fin){

$dir = 'backup/';
$zip_file = 'backup.zip';

// Get real path for our folder
$rootPath = realpath($dir);

// Initialize archive object
$zip = new ZipArchive();
$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();


header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($zip_file));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($zip_file));
readfile($zip_file);
}
?>