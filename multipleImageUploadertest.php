<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Next Step</title>

	<!--Import Google Icon Font-->
	<link type="text/css" rel="stylesheet" href="materialicon/material-icons.css" rel="stylesheet">

	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
	<form action="multipleImageUploader.php" accept-charset="utf-8" method = "post" enctype="multipart/form-data">
		<div class="file-field input-field col s12">
			<div class="btn">
				<span>Сонгох</span>
				<input type="file" id="file" name="file[]" multiple>
			</div>
			<div class="file-path-wrapper">
				<input class="file-path validate" placeholder = "Ажлын зураг оруулна уу!" type="text">
			</div>
		</div>
		<input type="submit" name="Илгээх">
	</form>
	<script type = "text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
</body>
</html>