<?php
	setcookie("id", "", time() - 3600, "/"); // 86400 = 1 day
	setcookie("fname", "", time() - 3600, "/"); // 86400 = 1 day
	setcookie("lname", "", time() - 3600, "/"); // 86400 = 1 day
	setcookie("email", "", time() - 3600, "/"); // 86400 = 1 day
	setcookie("name", "", time() - 3600, "/"); // 86400 = 1 day
	setcookie("mobile", "", time() - 3600, "/"); // 86400 = 1 day
	setcookie("accpro", "", time() - 3600, "/"); // 86400 = 1 day
	header('Location: index.php');
	?>