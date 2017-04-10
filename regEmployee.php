<?php
header('Content-Type: text/html; charset=utf-8');
require ("uploadimg.php");
$fname = "";
$lname = "";
$email =  "";
$password = "";
$havepic=is_uploaded_file($_FILES['file']['tmp_name']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$fname = test_input($_POST["fname"]);
	$lname = test_input($_POST["lname"]);
	$email = test_input($_POST["email"]);
	$password = hash('sha512', test_input($_POST["password"]));
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$accpro = "";
$result = "";

if($havepic) {
	$seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789!@#$%^&*()'); 
    // and any other characters
	shuffle($seed); 
	// probably optional since array_is randomized; this may be redundant
	$rand = '';
	foreach (array_rand($seed, 12) as $k) $rand .= $seed[$k];   
	$date = Date("Y").Date("m").Date("d").Date("H").Date("i");
	$accpro = $date.$rand;
	$imageFileType = trim(strtolower(pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION)));
	$result = uploadImage("file", $accpro, 100, 100, $imageFileType,"imgsmall/");
	if ($result!="jrfsucc")
		header("Location: index.php?jrf=".$result);
	$result = uploadImage("file", $accpro, 400, 400, $imageFileType,"imgbig/");
	if ($result!="jrfsucc"){
		unlink("imgbig/".$accpro.".".$imageFileType);
		header("Location: index.php?jrf=".$result);
	}
	$accpro.=".".$imageFileType;
} 


require("dbinfo.php");

// Create connection
$conn = new mysqli($servername, $username, $pw, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

if (!$conn->set_charset("utf8")) {
	die("Error loading character set utf8:". $mysqli->error);
} 

$stmt = $conn->prepare("INSERT INTO Employee (email,fname, lname,password,accpro) VALUES (?, ?, ?, ?, ?);");
$stmt->bind_param("sssss", $email, $fname, $lname, $password,$accpro);
if ($stmt->execute() === TRUE) {
	$last_id = $conn->insert_id;
	setcookie("id", $last_id, time() + (86400 * 7), "/"); // 86400 = 1 day
	setcookie("fname", $fname, time() + (86400 * 7), "/"); // 86400 = 1 day
	setcookie("lname", $lname, time() + (86400 * 7), "/"); // 86400 = 1 day
	setcookie("email", $email, time() + (86400 * 7), "/"); // 86400 = 1 day
	setcookie("accpro", $accpro, time() + (86400 * 7), "/"); // 86400 = 1 day
	setcookie("mobile", "", time() - 3600, "/"); // 86400 = 1 day
	setcookie("name", "", time() - 3600, "/"); // 86400 = 1 day
//Tsaashdaa Session luu filteriin medeelluud hereglegchiin huviin bairshil, interest zergiig oruulna. Increase Data Efficiency
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();	
header('Location: index.php?jrf='.$result);
?>