<?php
$comment = $_POST["fedbac"]."\n**************************\n";
file_put_contents('feedback.txt', $comment.PHP_EOL , FILE_APPEND);
header("Location:index.php?jrf=ty");
?>