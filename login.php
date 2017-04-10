<?php 
header('Content-Type: text/html; charset=utf-8');
$email =  "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = test_input($_POST["email"]);
	$password = hash('sha512', test_input($_POST["password"]));
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
	$conn->close();
	header('Location: index.php?jrf=connfail');
	die();
} 

if (!$conn->set_charset("utf8")) {
	$conn->close();
	header('Location: index.php?jrf=connfail');
	die();
} 

$sql1 = "SELECT * FROM Employee where (email = \"".$email."\" and password = \"".$password."\")";
$sql2 = "SELECT * FROM Employer where (email = \"".$email."\" and password = \"".$password."\")";
$sql3 = "SELECT * FROM Company where (email = \"".$email."\" and password = \"".$password."\")";

$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);

if($result1 || $result2 || $result3 ){
	if ($result1->num_rows > 0) {
		while($row = mysqli_fetch_assoc($result1)) {
			setcookie("id", $row["ID"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("fname",$row["fname"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("lname", $row["lname"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("email", $row["email"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("accpro", $row["accpro"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("mobile", "", time() - 3600, "/"); // 86400 = 1 day
			setcookie("name", "", time() - 3600, "/"); // 86400 = 1 day
		}
	} else if ($result2->num_rows > 0) {
		while($row = mysqli_fetch_assoc($result2)) {
			setcookie("id", $row["ID"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("fname",$row["fname"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("lname", $row["lname"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("email", $row["email"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("mobile", "", time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("accpro", $row["accpro"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("name", "", time() - 3600, "/"); // 86400 = 1 day
		}
	} else if ($result3->num_rows > 0) {
		while($row = mysqli_fetch_assoc($result3)) {
			setcookie("id", $row["ID"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("name",$row["name"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("email", $row["email"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("mobile", $row["mobile"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("accpro", $row["accpro"], time() + (86400 * 7), "/"); // 86400 = 1 day
			setcookie("fname","", time() - 3600, "/"); // 86400 = 1 day
			setcookie("lname","", time() - 3600, "/"); // 86400 = 1 day
		}
	} else {
		$conn->close();
		header('Location: index.php?jrf=loginfail');
		die();
	}
} else {
	$conn->close();
	header('Location: index.php?jrf=connfail');
	die();
	/*
	echo "Error: " . $sql1 . "<br>" . $conn->error;
	echo "Error: " . $sql2 . "<br>" . $conn->error;
	echo "Error: " . $sql3 . "<br>" . $conn->error;
	*/
}
$conn->close();
header('Location: index.php?jrf=loginsucc');
die();
?>