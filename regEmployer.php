<?php
header('Content-Type: text/html; charset=utf-8');
require ("uploadimg.php");
$fname = "";
$lname = "";
$email =  "";
$password = "";
$mobile = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$fname = test_input($_POST["fname"]);
	$lname = test_input($_POST["lname"]);
	$email = test_input($_POST["email"]);
	$password = hash('sha512', test_input($_POST["password"]));
	$mobile = test_input($_POST["mobile"]);
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$accpro = "";
$result = "";

if (($_FILES['file']['size'] == 0 && $_FILES['file']['error'] == 0) || !file_exists($_FILES['file']["tmp_name"])){
	$accpro = "default.png";
} else {
	$imageFileType = trim(strtolower(pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION)));
	$accpro = createNameforImage();
	$result = uploadImage("file", $accpro, 100, 100, "imgsmall/");
	if ($result!="succ")
		header("Location: index.php?jrf=".$result);
	$result = uploadImage("file", $accpro, 400, 400, "imgbig/");
	if ($result!="succ"){
		unlink("imgsmall/".$accpro.".".$imageFileType);
		header("Location: index.php?jrf=".$result);
	}
	$accpro.=".".$imageFileType;
} 
echo $accpro;
require("dbinfo.php");

// Create connection
$conn = new mysqli($servername, $username, $pw, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

if (!$conn->set_charset("utf8")) {
	die("Error loading character set utf8: ".$mysqli->error);
} 

/*
$sql = "INSERT INTO Employer (email,fname, lname,password )
VALUES (\"".$email."\",\"".$fname."\",\"".$lname."\",\"".$passwor d."\")";
*/

$stmt = $conn->prepare("INSERT INTO Employer (email, fname, lname, password, accpro) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $email, $fname, $lname, $password, $accpro);

if ($stmt->execute() === TRUE) {
	$last_id = $conn->insert_id;
	//$sql = "INSERT INTO employer_phone (ID, number) VALUES (\"".$last_id."\",\"".$mobile."\")";
	$stmt = $conn->prepare("INSERT INTO employer_phone (ID, number) VALUES (?, ?)");
	$stmt->bind_param("si", $last_id, $mobile);
	if ($stmt->execute() === TRUE) {
		setcookie("id", $last_id, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("fname",$fname, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("lname", $lname, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("email", $email, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("mobile", $mobile, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("accpro", $accpro, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("name", "", time() - 3600, "/"); // 86400 = 1 day
		//Tsaashdaa Session luu filteriin medeelluud hereglegchiin huviin bairshil, interest zergiig oruulna. Increase Data Efficiency
	} else {
		unlink("imgbig/".$accpro.".".$imageFileType);
		unlink("imgsmall/".$accpro.".".$imageFileType);
		die();
		echo "Error: " . $conn->error;
	}
} else {
	unlink("imgbig/".$accpro);
	unlink("imgsmall/".$accpro);
	echo "Error: " . $conn->error;
	die();
}

$conn->close();
header('Location: index.php?jrf='.$result);
?>