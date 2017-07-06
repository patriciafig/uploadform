
/**
 * Created on PhpStorm.
 * User: patricia
 * Date: 6/28/17
 */

<!doctype html>
<html>
<head>
    <title>Test</title>
</head>
<body>
<h1> Sample Page </h1>
<form method ="post" enctype="multipart/form-data" action=" ">
    <input type="text" name="Release" />
    <input type="text" name="SN" />
    <input type="file" name="my_file[]">
    <br><br>
    <input type="file" name="my_file[]">
    <input type= "submit" name="submit" value= "Upload" >
</form>
<!--
$_REQUEST["Release"]
$_REQUEST["SN"]
-->
<?php

if (isset($_FILES['my_file'])) {

	$folder = "file";
	$random = substr(md5(uniqid(mt_rand(), true)), 0, 6);
	$myFile = array();
	$myFile = $_FILES['my_file'];
	$count = count($_FILES['my_file']['size']);

	$target_dir = "./file/";

	$check = 1;

	for ($i = 0; $i < $count; $i++){

		$value = $i + 1;

		$target_file = $target_dir . basename($_FILES["my_file"]["name"][$i]);

		if (move_uploaded_file($_FILES["my_file"]["tmp_name"][$i], $target_file)) {
			$check = 0;
		} else {
			$check = 1;
		}

		echo "file $value name: " . $_FILES['my_file']['name'][$i] . "<br>";
		echo "tmpfile $value name: " . $_FILES['my_file']['tmp_name'][$i] . "<br>";
		echo "file $value upload error: " . $check . "<br>";

	}

	$zip = new ZipArchive;
	$file = Array();
	if($zip->open("file/$random.zip",  ZipArchive::CREATE) === TRUE){
		foreach($_FILES['my_file']['name'] as $file) {
			echo $file;
			$zip->addFile($folder.'/'.$file, $file);
			echo "<br/>";
		}
		$zip->close();
	} else {
		echo "Unable to create zip file";
	}

	for ($i = 0; $i < $count; $i++){
		echo "File $i is valid and was successfully uploaded<br>";
	}


	echo "The zip file name for uploaded file is $random located in file folder";

}

$uploadDir = $target_dir;   // target directory

?>

</body>
</html>
