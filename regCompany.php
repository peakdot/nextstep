<?php
header('Content-Type: text/html; charset=utf-8');
require ("uploadimg.php");
$name = "";
$email =  "";
$mobile =  "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = test_input($_POST["name"]);
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

/*$sql = "INSERT INTO Company (email, name, password)
VALUES (\"".$email."\",\"".$name."\",\"".$password."\")";*/

$stmt = $conn->prepare("INSERT INTO Company (email, name, password ) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $name, $password);

if ($stmt->execute() === TRUE) {
	$last_id = $conn->insert_id;
	//$sql = "INSERT INTO company_phone (ID, number) VALUES (\"".$last_id."\",\"".$mobile."\")";
	$stmt = $conn->prepare("INSERT INTO company_phone (ID, number) VALUES (?, ?)");
	$stmt->bind_param("si", $last_id, $mobile);

	if ($conn->query($sql) === TRUE) {
		setcookie("id", $last_id, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("name",$name, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("email", $email, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("mobile", $mobile, time() + (86400 * 7), "/"); // 86400 = 1 day
		setcookie("fname","", time() - 3600, "/"); // 86400 = 1 day
		setcookie("lname","", time() - 3600, "/"); // 86400 = 1 day
		//Tsaashdaa Session luu filteriin medeelluud hereglegchiin huviin bairshil, interest zergiig oruulna. Increase Data Efficiency
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header('Location: index.php');
?>