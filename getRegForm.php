<?php
$value = $_REQUEST["q"];
	//Employee form
if($value == "1") {
	echo "<form id=\"regForm\" accept-charset=\"utf-8\" class=\"col s12\" action = \"regEmployee.php\" method = \"post\" enctype=\"multipart/form-data\">
	<div class=\"input-field col s6\" >
		<input name=\"fname\" type=\"text\" class=\"validate\" required>
		<label for=\"fname\">Нэр</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"lname\" type=\"text\" class=\"validate\" required>
		<label for=\"lname\">Овог</label>
	</div>
	<div class=\"input-field col s12\" >
		<input name=\"email\" type=\"email\" class=\"validate\" required>
		<label for=\"email\">И-мэйл хаяг</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"password\" type=\"password\" class=\"validate\" required>
		<label for=\"password\">Нууц үг</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"passwordconfirm\" type=\"password\" class=\"validate\" required>
		<label for=\"password\">Нууц үгээ давтан хийнэ үү!</label>
	</div>
	<div class=\"file-field input-field col s12\">
		<div class=\"btn\">
			<span>Сонгох</span>
			<input type=\"file\" id=\"file\" name=\"file\">
		</div>
		<div class=\"file-path-wrapper\">
			<input class=\"file-path validate\" placeholder = \"Хүсвэл өөрийн зургаа оруулж болно шүү!\" type=\"text\" id=\"file2path\">
		</div>
	</div>";
}
	//Employer form
if($value == "2"){
	echo "<form id=\"regForm\" accept-charset=\"utf-8\" class=\"col s12\" action = \"regEmployer.php\" method = \"post\" enctype=\"multipart/form-data\">
	<div class=\"input-field col s6\" >
		<input name=\"fname\" type=\"text\" class=\"validate\" required>
		<label for=\"fname\">Нэр</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"lname\" type=\"text\" class=\"validate\" required>
		<label for=\"lname\">Овог</label>
	</div>
	<div class=\"input-field col s12\" >
		<input name=\"email\" type=\"email\" class=\"validate\" required>
		<label for=\"email\">И-мэйл хаяг</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"password\" type=\"password\" class=\"validate\" required>
		<label for=\"password\">Нууц үг</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"passwordconfirm\" type=\"password\" class=\"validate\" required>
		<label for=\"password\">Нууц үгээ давтан хийнэ үү!</label>
	</div>
	<div class=\"input-field col s12\" >
		<input name=\"mobile\" type=\"tel\" class=\"validate\" required>
		<label for=\"mobile\">Утасны дугаар</label>
	</div>
	<div class=\"file-field input-field col s12\">
		<div class=\"btn\">
			<span>Зураг</span>
			<input type=\"file\" id=\"file\" name=\"file\">
		</div>
		<div class=\"file-path-wrapper\">
			<input class=\"file-path validate\" placeholder = \"Хүсвэл өөрийн зургаа оруулж болно шүү!\" type=\"text\" id=\"file2path\">
		</div>
	</div></form>";
}
	//Company form
if($value == "3"){
	echo "<form id=\"regForm\" accept-charset=\"utf-8\" class=\"col s12\" action = \"regCompany.php\" method = \"post\" enctype=\"multipart/form-data\">
	<div class=\"input-field col s6\" >
		<input name=\"regnum\" type=\"text\" class=\"validate\" required>
		<label for=\"regnum\">Байгууллагын регистр</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"name\" type=\"text\" class=\"validate\" required>
		<label for=\"name\"Нэр</label>
	</div>
	<div class=\"input-field col s12\" >
		<input name=\"email\" type=\"email\" class=\"validate\" required>
		<label for=\"email\">И-мэйл хаяг</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"password\" type=\"password\" class=\"validate\" required>
		<label for=\"password\">Нууц үг</label>
	</div>
	<div class=\"input-field col s6\" >
		<input name=\"passwordconfirm\" type=\"password\" class=\"validate\" required>
		<label for=\"password\">Нууц үгээ давтан хийнэ үү!</label>
	</div>
	<div class=\"input-field col s12\" >
		<input name=\"mobile\" type=\"tel\" class=\"validate\" required>
		<label for=\"mobile\">Утасны дугаар</label>
	</div>
	<div class=\"file-field input-field col s12\">
		<div class=\"btn\">
			<span>Зураг</span>
			<input type=\"file\" id=\"file\" name=\"file\">
		</div>
		<div class=\"file-path-wrapper\">
			<input class=\"file-path validate\" placeholder = \"Хүсвэл өөрийн зургаа оруулж болно шүү!\" type=\"text\" id=\"file1path\">
		</div>
	</div></form>";
}
?>