<?php
require("dbinfo.php");
// Create connection
$conn = new mysqli($servername, $username, $pw, $dbname);

if (!$conn->set_charset("utf8")) {
  printf("Error loading character set utf8: %s\n", $mysqli->error);
} 

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

// Select all the rows in the markers table
$query = "SELECT * FROM Coordinates LEFT JOIN (SELECT createdBy, Joblist.Type, name, wtimeStart, wtimeEnd, SalaryMin, SalaryMax, createdDate, mobile1, week, edu, gender, age, Jobs.ID as ID, email FROM Jobs LEFT JOIN Joblist ON Jobs.jobID = Joblist.ID) as b ON b.ID = Coordinates.ID;";

$result = $conn->query($query);

if($result){
  header("Content-type: text/xml; charset=utf-8");

// Start XML file, echo parent node
  echo '<markers>';

// Iterate through the rows, printing XML nodes for each
  while ($row = mysqli_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
    echo '<marker ';
    echo 'id="' . $row['ID'] . '" ';
    echo 'name="' . $row['name'] . '" ';
    echo 'lat="' . $row['coorX'] . '" ';
    echo 'lng="' . $row['coorY'] . '" ';
    echo 'type="' . $row['Type'] . '" ';
    echo 'SalaryMin="' . $row['SalaryMin'] . '" ';
    echo 'SalaryMax="' . $row['SalaryMax'] . '" ';
    echo 'wtimeStart="' . $row['wtimeStart'] . '" ';
    echo 'wtimeEnd="' . $row['wtimeEnd'] . '" ';
    echo 'createdDate="' . $row['createdDate'] . '" ';
    echo 'createdBy="' . $row['createdBy'] . '" ';
    echo 'email="' . $row['email'] . '" ';
    echo 'mobile="' . $row['mobile1'] . '" ';
    echo 'edu="' . $row['edu'] . '" ';
    echo 'gender="' . $row['gender'] . '" ';
    echo 'age="' . $row['age'] . '" ';
    echo 'week="' . $row['week'] . '" ';
    echo '/>';
  }

// End XML file
  echo '</markers>';
// Company name, lat, lng, type, timestart, timeend,salarymin,salarymax
} else {
  echo "Error: " . $query . "<br>" . $conn->error;
}
?>