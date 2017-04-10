<?php
function scanImagesfor($id){
	$files = scandir("imgs/".$id);
	return json_encode($files);
}
?>