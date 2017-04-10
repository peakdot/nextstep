<?php
header('Content-Type: text/html; charset=utf-8');
require("uploadimg.php");

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function checkyes($checkboxvalue){
	if(isset($_POST[$checkboxvalue])){
		if($_POST[$checkboxvalue]=='on')
			return 1;
		else 
			return 0;
	} else {
		return 0;
	}
}

$jobID = "";
$SalaryMax = "";
$SalaryMin =  "";
$wtimeStart = "";
$wtimeEnd = "";
$mon = 0;
$tue = 0;
$wed = 0;
$thu = 0;
$fri = 0;
$sat = 0;
$sun = 0;
$email = "";
$mobile = "";
$gender = "";
$age = "";
$edu = "";
$createdDate = "";
$createdBy = "";
$week = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$jobID = test_input($_POST["selectedJob"]);
	$SalaryMax = test_input($_POST["SalaryMax"]);
	$SalaryMin =  test_input($_POST["SalaryMin"]);
	$wtimeStart = test_input($_POST["workStartH"]);
	$wtimeEnd = test_input($_POST["workEndH"]);
	$mon = checkyes("mon");
	$tue = checkyes("tue");
	$wed = checkyes("wed");
	$thu = checkyes("thu");
	$fri = checkyes("fri");
	$sat = checkyes("sat");
	$sun = checkyes("sun");
	$week = $mon*1+$tue*2+$wed*4+$thu*8+$fri*16+$sat*32+$sun*64;
	$email = test_input($_POST["email"]);
	$mobile = test_input($_POST["phone"]);
	$gender = test_input($_POST["gender"]);
	$age = test_input($_POST["age"]);
	$edu = test_input($_POST["edu"]);
	$createdDate = date("Y/m/d");
	$createdBy = $_COOKIE["id"];
	$lats = json_decode($_POST["coordx"],TRUE);
	$lngs = json_decode($_POST["coordy"],TRUE);
}

echo $week." , ".$mon." , ".$tue." , ".$wed." , ".$thu." , ".$fri." , ".$sat." , ".$sun;

$last_id = 1;
$result = "";

require("dbinfo.php");

	// Create connection
$conn = new mysqli($servername, $username, $pw, $dbname);

	// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

if (!$conn->set_charset("utf8")) {
	printf("Error loading character set utf8: %s\n", $mysqli->error);
} 
/*$sql = "INSERT INTO Jobs (jobID,SalaryMax,SalaryMin,wtimeStart,wtimeEnd,mon,tue,wed,thu,fri,sat,sun,email,mobile,gender,age,edu,createdDate,createdBy) VALUES (".$jobID.",".$SalaryMax.",".$SalaryMin.",".$wtimeStart.",".$wtimeEnd.",".$mon.",".$tue.",".$wed.",".$thu.",".$fri.",".$sat.",".$sun.",'".$email."',".$mobile.",".$gender.",".$age.",".$edu.",'".$createdDate."',".$createdBy.");";*/

$stmt = $conn->prepare("INSERT INTO jobs (jobID, SalaryMax, SalaryMin, wtimeStart, wtimeEnd, week, email, mobile1, gender, age, edu, createdDate, createdBy) VALUES (? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?);");

$stmt->bind_param("iiiiiisiiiisi", $jobID, $SalaryMax, $SalaryMin, $wtimeStart, $wtimeEnd, $week, $email, $mobile, $gender, $age, $edu, $createdDate, $createdBy);


if ($stmt->execute() === TRUE) {
	$last_id = $conn->insert_id;
	$sql="INSERT INTO Coordinates (ID,coorX,coorY) VALUES";
	$len = count($lats);
	for ($i = 0; $i < $len; $i++){
		$sql.="(".$last_id.",".$lats[$i].",".$lngs[$i]."),";
	}
	$len = strlen($sql);
	$sql[$len-1]=';';
	if ($conn->query($sql) === TRUE) {
		header('Location: index.php?jrf=jrfsucc');
	} else {
		header('Location: index.php?jrf=jrffail');
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
} else {
	header('Location: index.php?jrf=jrffail');
	echo "Error: ". $conn->error;
}

if (($_FILES['file']['size'][0] == 0 && $_FILES['file']['error'][0] == 0) || !file_exists($_FILES['file']["tmp_name"][0])) {
	$jobpro = "";
	file_put_contents("imgs/".$last_id."/nameList.json", "");
} else {
	$temp = "";
	$myFile = $_FILES['file'];
	$fileCount = count($myFile["name"]);
	$imageNames = array();
	
	mkdir("imgs/".$last_id, 0777, true);

	for ($i = 0; $i < $fileCount; $i++) {
		$temp = createNameforImage();
		$imageFileType = trim(strtolower(pathinfo(basename($myFile["name"][$i]),PATHINFO_EXTENSION)));
		array_push($imageNames, $temp.'.'.$imageFileType);
		$result = uploadImageX("file", $temp, $imageFileType, $myFile["tmp_name"][$i], $myFile["size"][$i],"imgs/".$last_id."/");
		if ($result!="succ"){
			for($j = 0; $j<= $i; $j++)
				unlink(array_pop($imageNames));
			rmdir("imgs/".$last_id);
			header('Location: index.php?jrf=jrfsuccpicerr');
		}
	}
	file_put_contents("imgs/".$last_id."/nameList.json", json_encode($imageNames));
} 

$conn->close();
header('Location: index.php?jrf=jrfsucc');

?>