<?php
require("uploadimg.php");

$last_id = 10001;

if(($_FILES['file']['size'][0] == 0 && $_FILES['file']['error'][0] == 0) || !file_exists($_FILES['file']["tmp_name"][0])) {
	$jobpro = "";
	echo $_FILES['file']["tmp_name"][0]."<br/>".$_FILES['file']['error'][0];
} else {
	$temp = "";
	$myFile = $_FILES['file'];
	$fileCount = count($myFile["name"]);
	$imageNames = array();
	
	if(!mkdir("imgs/".$last_id, 0777, true)){
		echo "unsuccessful";
		die();
	}

	for ($i = 0; $i < $fileCount; $i++) {
		$temp = createNameforImage();
		$imageFileType = trim(strtolower(pathinfo(basename($myFile["name"][$i]),PATHINFO_EXTENSION)));
		array_push($imageNames, $temp.'.'.$imageFileType);
		$result = uploadImageX("file", $temp, $imageFileType, $myFile["tmp_name"][$i], $myFile["size"][$i],"imgs/".$last_id."/");
		if ($result!="succ"){
			for($j = 0; $j<= $i; $j++)
				unlink(array_pop($imageNames));
		} else {
			file_put_contents("imgs/".$last_id."/nameList.json", json_encode($imageNames));
			echo "Yessss!!!";
		}
	}
} 
?>