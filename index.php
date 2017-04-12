<!--
+ Өгөгдлийн сангаас мап дээрх цэг дээр дарахад гарч ирэх чухал мэдээллүүдийг XML байдлаар экспортлох(SQL бичиж орхисон)
+ XML файлаас импортлож оруулж ирэх, аль хэсэгт хадгалахаа шийдэх
+ Өгөгдлийн санд хадгалагдсан ажлын жагсаалтын нэрийг засах(?????? болчихсон байгаа)
+ Үнэгүй хостинг дээр ажиллахгүй байгаа
+ Маркерийг үзэмжтэй болгох
- XML файл руу хандахдаа зэрэг хандаж болно, хадгалахад зэрэг хадгалж болохгүй.
- AJAX ашиглаж мапаас дэлгэрэнгүй мэдээллийн хэсэг рүү шилжих
- Маркер дарахад гарч ирэх товч мэдээллийг үзэмжтэй болгох
- Ажил нэмэх формийн ажил сонгох хэсэг доошоо хэт их ажил гарч ирж байгаа
- Маркер дээрх мэдээллийг хянах
- You should always validate external data!
-->

<?php
header('Content-Type: text/html; charset=utf-8');

function wipeAllCookies(){
	setcookie("id", "", time() - 3600, "/");
	setcookie("fname", "", time() - 3600, "/");
	setcookie("lname", "", time() - 3600, "/");
	setcookie("email", "", time() - 3600, "/");
	setcookie("mobile", "", time() - 3600, "/"); 
	setcookie("accpro", "", time() - 3600, "/");
	setcookie("name", "", time() - 3600, "/"); 
}

function checkAllCookies(){
	if(isset($_COOKIE['id']) && !empty($_COOKIE['id']) && isset($_COOKIE['fname']) && !empty($_COOKIE['fname']) && isset($_COOKIE['lname']) && !empty($_COOKIE['lname']) && isset($_COOKIE['accpro']) && !empty($_COOKIE['accpro'])){
		return true;
	}
	return false;
}
?>

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

	<link type="text/css" href="css/nextstep.css" rel="stylesheet">
	<link type="text/css" href="css/nouislider.css" rel="stylesheet">
	<link type="text/css" href="css/filter.css" rel="stylesheet">

</head>

<body>
	<div id = "main">

		<!-- Navbar Fixed-->
		<ul id="menu" class="dropdown-content navdropdown">
			<li><a href="#!">Шинэчлэх</a></li>
			<li><a href="#!">Тохиргоо</a></li>
			<li><a href="logout.php">Гарах</a></li>
		</ul>

		<div class="navbar-fixed" id = "navbarCont">
			<nav id ="navbar">
				<div class="nav-wrapper teal accent-200 a">
					<a href="index.php" class="brand-logo center"><i class="material-icons">cloud</i>NextStep</a>
					<ul class="right hide-on-med-and-down">
						<?php 
						if(checkAllCookies()) {
							echo "<a  class=\"dropdown-button\" href=\"#!\" data-activates=\"menu\"><li>".$_COOKIE["fname"]." ".$_COOKIE["lname"]."</li><li><img class=\"circle profileImage\" src=\"imgsmall/".$_COOKIE["accpro"]."\"></li></a>";
						}
						else {
							//wipeAllCookies();
							echo "<li><a class = \"modal-trigger\" href = \"#login\">Нэвтрэх</a></li>";
						}
						?>
					</ul>
				</div>
			</nav>
		</div>
		<!-- Navbar Fixed End-->

		<!-- Menu -->
		<div class="menufab fixed-action-btn horizontal click-to-toggle disabled" id = "menufab">
			<a class="btn-floating btn-large red"> <i class="material-icons">menu</i> </a>
			<ul>
				<li>
					<a class="modal-trigger btn-floating red tooltipped" data-position="top" data-delay="50" data-tooltip="Ажил оруулах" href=<?php 
					//Cookied id baigaa esehig shalgaj hereglegch nevtersen esehiig shalgana
					if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
					//Nevtersen hereglegch 
						if (substr($_COOKIE['id'],0,1)!="2") echo "\"#regJobModal\"";
						else echo "\"#beemployer\"";
					}
					else echo "\"#login\""; ?>
					><i class="material-icons">add</i></a>
				</li>
				<li><a class="btn-floating yellow darken-1 tooltipped" data-position="top" data-delay="50" data-tooltip="Ажил хайх"><i class="material-icons" onclick = "showFilter()">search</i></a></li>
				<li><a class="modal-trigger btn-floating green  tooltipped" href="#feedback" data-position="top" data-delay="50" data-tooltip="Сэтгэгдлээ үлдээх"><i class="material-icons">comment</i></a></li>
			</ul>
		</div>
		<!-- Menu End -->

		<!-- Get Location Button -->
		<a class="btn-floating btn-large waves-effect waves-light green" id = "doneButton" onclick="getLocationFromUser()"><i class="material-icons">done</i></a>
		<!-- Get Location Button End-->

		<!-- Login -->
		<div id="login" class="modal">
			<div class="modal-content">
				<div class="row">
					<form id = "loginform" class="col s12" action = "login" method = "post">
						<div class="row">
							<h4>Нэвтрэх</h4>
							<div class="input-field col s12">
								<input name="email" type="email" class="validate" onchange="" required>
								<label for="email">И-мэйл хаяг</label>
							</div>
							<div class="input-field col s12">
								<input name="password" type="password" class="validate" required>
								<label for="password">Нууц үг</label>
							</div>
							<div class="input-field col s12">
								<input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" />
							</div>
							<div class="col s12">
								<p class="wrongpass" id="wrongpass"></p>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class = "modal-footer">
				<button type="submit" form="loginform" class = "modal-action waves-effect waves-green btn-flat">Нэвтрэх</button>
				<a class = "modal-action modal-close modal-trigger waves-effect waves-green btn-flat" href = "#regUserModal">Бүртгүүлэх</a>
			</div>
		</div>
		<!-- Login End-->

		<!-- Register Forms -->
		<div id="regUserModal" class="modal modal-fixed-footer">
			<div class="modal-content">
				<div class = "row">
					<div class = "input-field col s12" >
						<select onchange="showForm(this.value)">
							<option value="" disabled selected>Сонгох</option>
							<option value="1">Ажил хайгч</option>
							<option value="2">Ажил олгогч</option>
							<option value="3">Ажил олгогч байгууллага</option>
						</select>
						<label>Та ажил хайгч уу, ажил олгогч уу?</label>
					</div>
					<div id = "regFormContainer">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type = "submit" form = "regForm" class="modal-action waves-effect waves-green btn-flat">Бүртгүүлэх</button>
			</div>
		</div>
		<!-- Register Forms End-->


		<!-- Temporary feedback -->
		<div id="feedback" class="modal">
			<div class="modal-content">
				<div class="row">
					<form id = "feedbackform" class="col s12" action = "feedback.php" method = "post">
						<div class="row">
							<div class = "input-field col s12">
								<h4>Сэтгэгдэл</h4>
								<i class="material-icons prefix">mode_edit</i>
								<textarea name="fedbac" id="fedbac" placeholder="Энд бичнэ үү..." class="materialize-textarea"></textarea>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class = "modal-footer">
				<button type="submit" form="feedbackform" class = "modal-action waves-effect waves-green btn-flat">Илгээх</button>
			</div>
		</div>
		<!-- Temporary feedback End-->

		<!-- You cant add job from this user -->
		<div id="beemployer" class="modal">
			<div class="modal-content">
				<div class = "row">
					<h5>Шинээр бүртгүүлнэ үү!</h5>
					<p>Ажлын байр шинээр нэмэхийн тулд та ажил олгогч эсвэл компани байх шаардлагатай.</p>
				</div>
			</div>
			<div class="modal-footer">
				<button class="modal-action modal-close waves-effect waves-green btn-flat">Ойлголоо</button>
			</div>
		</div>
		<!-- You cant add job from this user End-->

		<!-- Register Job -->
		<div id="regJobModal" class="modal modal-fixed-footer">
			<div class="modal-content">
				<div class = "row">
					<form action = "regJob.php" id = "regJobForm" accept-charset="utf-8" class="col s12" method = "post" enctype="multipart/form-data">
						<div class="row">
							<h5>Ажлын ерөнхий мэдээлэл</h5>
							<div class = "input-field col s12">
								<select name = "selectedJob" size = "5">
									<option value="" disabled selected>Сонгох</option>

									<?php
									require("dbinfo.php");
												// Create connection
									$conn = new mysqli($servername, $username, $pw, $dbname);

												// Check connection
									if ($conn->connect_error) {
										die("Connection failed: " . $conn->connect_error);
									} 

									if (!$conn->set_charset("utf8")) {
										die("Error loading character set utf8:".$mysqli->error);
									} 

									$sql = "SELECT * FROM joblist";

									$result1 = $conn->query($sql);


									while($row = mysqli_fetch_assoc($result1)) {
										echo "<option value =\"".$row['ID']."\" >".$row['name']."</option>";
									}

									?>
								</select>
								<label for = "SelectedJob">Санал болгох ажил</label>
							</div>
							<div class = "input-field col s6">
								<input name = "SalaryMin" type = "number" value = "100000" min="100000" max = "50000000" step="1000" class = "validate" required>
								<label for = "SalaryMin">Цалингийн доод хэмжээ(сарын)</label>
							</div>
							<div class = "input-field col s6">
								<input name = "SalaryMax" type = "number" value = "100000" min="100000" max = "50000000" step="1000" class = "validate" required>
								<label for = "SalaryMax">Цалингийн дээд хэмжээ(сарын)</label>
							</div>
							<div class = "input-field col s12">
								<textarea name="addition" id="addition" placeholder="Нэмэлт мэдээллээ энд бичнэ үү!" class="materialize-textarea"></textarea>
								<label for="addition">Нэмэлт мэдээлэл</label>
							</div>
							<h5>Ажиллах цагийн хуваарь</h5>
							<div class = "input-field col s12">
								<label id = "timeDisplayer"></label>
								<div id="worktime"></div>
								<input type = "hidden" name = "workStartH" id = "workStartH" value = ""/>
								<input type = "hidden" name = "workEndH" id = "workEndH" value = ""/>
								<br/>
								<p>
									<input type="hidden" name="mon" value="off">
									<input type="checkbox" class="filled-in" id="mon" name="mon"/>
									<label for="mon">Даваа</label>
								</p>
								<p>
									<input type="hidden" name="tue" value="off">
									<input type="checkbox" class="filled-in" id="tue" name="tue"/>
									<label for="tue">Мягмар</label>
								</p>
								<p>
									<input type="hidden" name="wed" value="off">
									<input type="checkbox" class="filled-in" id="wed" name="wed"/>
									<label for="wed">Лхагва</label>
								</p>
								<p>
									<input type="hidden" name="thu" value="off">
									<input type="checkbox" class="filled-in" id="thu" name="thu"/>
									<label for="thu">Пүрэв</label>
								</p>
								<p>
									<input type="hidden" name="fri" value="off">
									<input type="checkbox" class="filled-in" id="fri" name="fri"/>
									<label for="fri">Баасан</label>
								</p>
								<p>
									<input type="hidden" name="sat" value="off">
									<input type="checkbox" class="filled-in" id="sat" name="sat"/>
									<label for="sat">Бямба</label>
								</p>
								<p>
									<input type="hidden" name="sun" value="off">
									<input type="checkbox" class="filled-in" id="sun" name="sun"/>
									<label for="sun">Ням</label>
								</p>
								<br/>
							</div>
							<h5>Холбоо барих</h5>
							<div class = "input-field col s12">
								<input name="email" type="email" class="validate">
								<label for="email">И-мэйл хаяг</label>
							</div>
							<div class = "input-field col s12">
								<input name="phone" type="tel" class="validate" required/>
								<label for="email">Утасны дугаар</label>
							</div>
							<h5>Байршил оруулах</h5>
							<snap id = "locationNumber"></snap>
							<div class = "input-field col s12">
								<a onclick="prepareTogetLocationFromUser();" class = "btn-floating cyan lighten-2" ><i class="material-icons">add</i></a>
								<input name="coordx" id = "coordx" type="hidden" value = ""/>
								<input name="coordy" id = "coordy" type="hidden" value = ""/>
							</div>		
							<br/>
							<br/>
							<br/>
							<h5>Зураг оруулах</h5>	
							<div class="file-field input-field col s12">
								<div class="btn">
									<span>Сонгох</span>
									<input type="file" id="file" name="file[]" multiple>
								</div>
								<div class="file-path-wrapper">
									<input class="file-path validate" placeholder = "Ажлын зураг оруулна уу!" type="text">
								</div>
							</div>
							<h5>Шаардлага</h5>							
							<div class = "input-field col s12">
								<select name = "gender">
									<option value="0" selected>Хамаагүй</option>
									<option value="1">Эрэгтэй</option>
									<option value="2">Эмэгтэй</option>
								</select>
								<label for = "gender">Хүйс</label>
							</div>
							<div class = "input-field col s12">
								<select name = "age">
									<option value="0" selected>Хамаагүй</option>
									<option value="1">18-25</option>
									<option value="2">25-30</option>
									<option value="3">30-45</option>
								</select>
								<label for = "age">Нас</label>
							</div>			
							<div class = "input-field col s12">
								<select name = "edu">
									<option value="0" selected>Хамаагүй</option>
									<option value="1">Бага</option>
									<option value="2">Дунд</option>
									<option value="3">Бүрэн дунд</option>
									<option value="4">Дээд</option>
								</select>
								<label for = "edu">Боловсрол</label>
							</div>							
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type = "submit" form = "regJobForm" class="modal-action waves-effect waves-green btn-flat">Оруулах</button>
			</div>
		</div>
		<!--Register Job End-->


		<!--Filter-->
		<div id = "filter">
			<!--<h6>Санал болгох ажил</h6>-->
			<div class = "input-field col s12">
				<select name = "fjobtype" id = "fjobtype">
					<option value="0" selected>Бүгд</option>
					<option value="1">Цэвэрлэгээ</option>
					<option value="2">Үйлчилгээ</option>
					<option value="3">Хүнд хүчний</option>
				</select>
			</div>

			<!--<h6>Цагийн хөлс</h6>-->
			<div style = "background-color: #3f51b5; height: 6vh; font-size: 4vh; color: white;">
				<center>
					<span id = "fsalaryText"></span>
				</center>
			</div>
			<br/>
			<div id="fsalary"></div>
			<br/>

			<input type = "hidden" name = "fsalarymin" id = "fsalarymin" value = ""/>
			<input type = "hidden" name = "fsalarymax" id = "fsalarymax" value = ""/>

			<!--<h6>Ажиллах цаг</h6>-->
			<ul id = "fweekinfo" class="" onclick="">
				<li class = "fweekday">Да</li>
				<li class = "fweekday">Мя</li>
				<li class = "fweekday">Лха</li>
				<li class = "fweekday">Пү</li>
				<li class = "fweekday">Ба</li>
				<li class = "fweekday">Бя</li>
				<li class = "fweekday">Ня</li>
			</ul>
			<center>
				<div class="timepicker">
					<div style = "background-color: #3f51b5; font-size: 5vh; color: grey; margin-bottom: 10px;">
						<center>
							<span id = "tp-time1" class = "selecteded" onclick = "activatetp(0)">09:00</span><span> - </span><span id = "tp-time2" onclick = "activatetp(1)">18:00</span>
						</center>
					</div>
					<svg class = "timecircle" id = "timepicker1">
						<circle cx="100" cy="100" r="100" stroke="#e0e0e0" stroke-width="1" fill="#e0e0e0" />
						<circle cx="100" cy="100" r="2" fill="#3f51b5"/>
						<line id = "timepin1" x1="100" y1="100" x2="100" y2="20" transform="rotate(135 100 100)" style="stroke:#3f51b5;stroke-width:2" />
						<circle id = "timepincircle1" cx="100" cy="20" r="15" fill="#3f51b5" transform="rotate(135 100 100)"/>
						<line id = "timepin2" x1="100" y1="100" x2="100" y2="20" transform="rotate(270 100 100)" style="stroke:#3f51b5;stroke-width:2" />
						<circle id = "timepincircle2" cx="100" cy="20" r="15" fill="#3f51b5" transform="rotate(270 100 100)"/>
						<text x="92" y="25" id = 'tp-24' fill="black" class = "unselectable" onclick="setclock(24)">24</text>
						<text x="117" y="27" id = 'tp-1' fill="#e0e0e0" class = "unselectable" onclick="setclock(1)">1</text>
						<text x="136" y="35" id = 'tp-2' fill="black" class = "unselectable" onclick="setclock(2)">2</text>
						<text x="153" y="48" id = 'tp-3' fill="#e0e0e0" class = "unselectable" onclick="setclock(3)">3</text>
						<text x="165" y="65" id = 'tp-4' fill="black" class = "unselectable" onclick="setclock(4)">4</text>
						<text x="173" y="84" id = 'tp-5' fill="#e0e0e0" class = "unselectable" onclick="setclock(5)">5</text>
						<text x="176" y="105" id = 'tp-6' fill="black" class = "unselectable" onclick="setclock(6)">6</text>
						<text x="173" y="126" id = 'tp-7' fill="#e0e0e0" class = "unselectable" onclick="setclock(7)">7</text>
						<text x="165" y="145" id = 'tp-8' fill="black" class = "unselectable" onclick="setclock(8)">8</text>
						<text x="153" y="162" id = 'tp-9' fill="white" class = "unselectable" onclick="setclock(9)">9</text>
						<text x="132" y="174" id = 'tp-10' fill="black" class = "unselectable" onclick="setclock(10)">10</text>
						<text x="113" y="182" id = 'tp-11' fill="#e0e0e0" class = "unselectable" onclick="setclock(11)">11</text>
						<text x="92" y="185" id = 'tp-12' fill="black" class = "unselectable" onclick="setclock(12)">12</text>
						<text x="72" y="182" id = 'tp-13' fill="#e0e0e0" class = "unselectable" onclick="setclock(13)">13</text>
						<text x="52" y="174" id = 'tp-14' fill="black" class = "unselectable" onclick="setclock(14)">14</text>
						<text x="35" y="162" id = 'tp-15' fill="#e0e0e0" class = "unselectable" onclick="setclock(15)">15</text>
						<text x="23" y="145" id = 'tp-16' fill="black" class = "unselectable" onclick="setclock(16)">16</text>
						<text x="15" y="126" id = 'tp-17' fill="#e0e0e0" class = "unselectable" onclick="setclock(17)">17</text>
						<text x="12" y="105" id = 'tp-18' fill="white" class = "unselectable" onclick="setclock(18)">18</text>
						<text x="15" y="84" id = 'tp-19' fill="#e0e0e0" class = "unselectable" onclick="setclock(19)">19</text>
						<text x="23" y="65" id = 'tp-20' fill="black" class = "unselectable" onclick="setclock(20)">20</text>
						<text x="36" y="48" id = 'tp-21' fill="#e0e0e0" class = "unselectable" onclick="setclock(21)">21</text>
						<text x="52" y="35" id = 'tp-22' fill="black" class = "unselectable" onclick="setclock(22)">22</text>
						<text x="72" y="27" id = 'tp-23' fill="#e0e0e0" class = "unselectable" onclick="setclock(23)">23</text>
					</svg>
				</div>
			</center>
			<br/>
			<center>
				<button class="waves-effect waves-green btn" onclick="filtermapmarkers(getfilterparas())">Хайх</button>
				<button class="waves-effect waves-green btn-flat" onclick="showMarker('job')">Цуцлах</button>
			</center>
		</div>
		<!--Filter End-->


		<!--SideNav-->
		<ul id="slide-out" class="side-nav">
			<div class = "sidenavXbtn btn-floating btn-large waves-effect waves-light green" onclick="sideNavi(-1)"><i class="material-icons">arrow_back</i></div>
			<li>
				<div class="userView">
					<img class="background" id="spjobpro" src = "imgs/office.jpg"/>
					<a href="#!user" id="sppro"><img class="circle" src="imgsmall/201703140852_pn2qDSY7ITPksRouH5gfCUQ0O3jXNx.jpg"></a>
					<a><span class="white-text name" id="spname"></span></a>
					<a><span class="white-text email" id="spemailmobile"></span></a>
				</div>
			</li>
			<li><a class="subheader">Ерөнхий мэдээлэл</a></li>
			<li><a class="sidePanelItem"><i class="material-icons">assignment</i><span id="spjobname"></span></a></li>
			<li><a class="sidePanelItem"><i class="material-icons">thumb_up</i><span id="spsalary"></span></a></li>
			<li><a class="sidePanelItem"><i class="material-icons">thumb_up</i><span id="spgender"></span></a></li>
			<li><a class="sidePanelItem"><i class="material-icons">query_builder</i><span id="spage"></span></a></li>
			<li><a class="sidePanelItem"><i class="material-icons">query_builder</i><span id="speducation"></span></a></li>
			<li><a class="sidePanelItem"><i class="material-icons">query_builder</i><span id="spwtime"></span></a></li>
			<li>
				<a class="">
					<span class="jobweekinfo" id="infomon">Да</span>
					<span class="jobweekinfo" id="infotue">Мя</span>
					<span class="jobweekinfo" id="infowed">Лха</span>
					<span class="jobweekinfo" id="infothu">Пү</span>
					<span class="jobweekinfo" id="infofri">Ба</span>
					<span class="jobweekinfo" id="infosat">Бя</span>
					<span class="jobweekinfo" id="infosun">Ня</span>
				</a>
			</li>
			<div class="carousel" id = "jobimgs">
				<div class="carousel-item"><img class="materialboxed" src="imgs/office.jpg"></div>
			</div>
			<li><a class="sidePanelItem"><i class="material-icons">thumb_up</i><span id="spadditional"></span></a></li>
		</ul>
		<button type = "hidden" id = "sideNavTrigg" data-activates = "slide-out" class = "button-collapse"></button>
		<!--SideNav End-->

		<script type = "text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<!-- Map -->
		<script type = "text/javascript" src = "js/map.js"></script>
		<!-- Map End -->

		<div id="map"></div>
	</div>
	<script async defer	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDapiQf8_eNvGEudEZDZjnJ2H3hOSn8eWo&callback=initialize"></script>

	<!-- Scripts -->
	<script type="text/javascript" src="js/materialize.js"></script>
	<script type="text/javascript" src="js/nouislider.min.js"></script>
	<script type="text/javascript" src="js/filter.js"></script>
	<script type="text/javascript">
		var materialboxactive=false;
		var name = "";
		var type = "";
		var SalaryMax = "";
		var SalaryMin = "";
		var wtimeStart = "";
		var wtimeEnd = "";
		var createdDate = "";
		var createdBy = "";
		var jobpro = "";
		var sidepanelstate=0; 
			/*
			0 - Closed side panel
			1 - Opened side panel
			2 - Waiting
			*/
			$(document).ready(function(){
				// the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
				$('.modal-trigger').leanModal();
				$('select').material_select();
				// A setting that changes the collapsible behavior to expandable instead of the default accordion style
				$('.button-collapse').sideNav({
					menuWidth: 400
				});
				$(".dropdown-button").dropdown({
					belowOrigin: true,
					alignment: 'right'
				});
				$('.carousel').carousel({
					time_constant: 80,
					dist: -70
				});
				$('.materialboxed').materialbox();
				$('.collapsible').collapsible();
				$('.fixed-action-btn').openFAB();

				downloadUrl("genLocXML.php", function(data) {
					xml = data.responseXML;});

				function getEventTarget(e) {
					e = e || window.event;
					return e.target || e.srcElement; 
				}

				var ul = document.getElementById('fweekinfo');
				ul.onclick = function(event) {
					var target = getEventTarget(event);
					if(target.className.indexOf("active")==-1){
						target.className += " active";
					} else {
						target.className = "";
					}
				};

				var slider1 = document.getElementById('fsalary');
				noUiSlider.create(slider1, {
					start: [20, 40],
					connect: true,
					step: 1,
					tooltips: true,
					range: {
						'min': 10,
						'max': 50
					},
					format: wNumb({
						decimals: 0
					})
				});

				var fsalarymin = $("#fsalarymin"),
				fsalarymax = $("#fsalarymax"),
				fsalaryText = $("#fsalaryText");

				fsalary.noUiSlider.on('update', function ( values, handle ) {
					fsalarymin.val(values[0]);
					fsalarymax.val(values[1]);
					fsalaryText.html(values[0]+"000₮ - "+values[1]+"000₮");
				});



				var slider2 = document.getElementById('worktime');
				noUiSlider.create(slider2, {
					start: [9, 18],
					connect: true,
					step: 1,
					range: {
						'min': 0,
						'max': 24
					},
					format: wNumb({
						decimals: 0
					})
				});
				var starthour = document.getElementById("workStartH"),
				endhour = document.getElementById("workEndH"),
				labelText = document.getElementById("timeDisplayer");

				worktime.noUiSlider.on('update', function ( values, handle ) {
					starthour.setAttribute("value",values[0]);
					endhour.setAttribute("value",values[1]);
					labelText.innerHTML = values[0]+" цагаас "+values[1] + " цаг хүртэл";
				});

				<?php
				if(isset($_GET['jrf']) && !empty($_GET['jrf'])) {
					echo "jrf(\"".$_GET['jrf']."\");";
				}
				?>

			});

			function jrf(str){
				switch(str){
					case "jrfsucc": {
						Materialize.toast('Бүртгэл амжилттай хийгдлээ!', 3000);
						break;
					}
					case "jrffail": {
						Materialize.toast('Бүртгэл амжилтгүй!', 3000);
						break;
					}
					case "picexterr": {
						Materialize.toast('Таны оруулсан зургийн өргөтгөл буруу байна. \nЗөвхөн JPG, JPEG, PNG өргөтөлтэй зураг оруулна уу.', 3000);
						break;
					}
					case "picincerr": {
						Materialize.toast('Таны зургийг оруулахад алдаа гарлаа.', 3000);
						break;
					}
					case "pictoolarge": {
						Materialize.toast('Таны оруулсан зураг хэтэрхий том байна.', 3000);
						break;
					}
					case "pictoosmall": {
						Materialize.toast('Таны оруулсан зураг хэтэрхий жижиг байна.'
							<?php if(isset($_GET["size"]) && !empty($_GET["size"])) echo "+".$_GET["size"]?>, 3000);
						break;
					}
					case "connfail": {
						Materialize.toast('Холболт амжилтгүй боллоо.', 3000);
						break;
					}
					case "loginsucc": {
						Materialize.toast('Амжилттай нэвтэрлээ!', 3000);
						break;
					}
					case "loginfail": {
						$("#wrongpass").html("И-мэйл хаяг эсвэл нууц үг буруу байна!");
						$('#login').openModal();
						break;
					}
					case "ty": {
						Materialize.toast('Сэтгэгдлээ үлдээсэнд баярлалаа!', 3000);
						break;
					}
				}
			}

			var sideNavTrigg = document.getElementById("sideNavTrigg"),
			mainframe = document.getElementById("main"),
			sidepanel = document.getElementById("slide-out"),
			mapframe = document.getElementById('map');

			function sidepanelChangeContent(def_id){
				if(xml != null){
					var markersXML = xml.documentElement.getElementsByTagName("marker");
					for (var i = 0; i < markersXML.length; i++) {
						var id = parseInt(markersXML[i].getAttribute("id"));
						if(def_id==id){
							var name = markersXML[i].getAttribute("name");
							var type = parseInt(markersXML[i].getAttribute("type"));
							var email = markersXML[i].getAttribute("email");
							var mobile = markersXML[i].getAttribute("mobile");
							var SalaryMax = parseInt(markersXML[i].getAttribute("SalaryMax"));
							var SalaryMin = parseInt(markersXML[i].getAttribute("SalaryMin"));
							var wtimeStart = parseInt(markersXML[i].getAttribute("wtimeStart"));
							var wtimeEnd = parseInt(markersXML[i].getAttribute("wtimeEnd"));
							var createdDate = markersXML[i].getAttribute("createdDate");
							var createdBy = parseInt(markersXML[i].getAttribute("createdBy"));
							var education = parseInt(markersXML[i].getAttribute("edu"));
							var gender = parseInt(markersXML[i].getAttribute("gender"));
							var age = parseInt(markersXML[i].getAttribute("age"));
							var week = parseInt(markersXML[i].getAttribute("week"));
							$("#spjobname").html(name);
							$("#spname").html(name);
							$("#spemailmobile").html(mobile+"<br/>"+email);
							$("#spsalary").html(SalaryMin+"₮ - "+SalaryMax + "₮");
							$("#spwtime").html(wtimeStart+" цагаас "+wtimeEnd +" цаг хүртэл");
							$("#spjobpro").attr("src","imgs/office.jpg");
							if(parseInt(week%2)==1) {
								$("#infosun").css("color","#A2A2A2");
								$("#infosun").css("background-color","#FAFAFA");
							} else {
								$("#infosun").css("color","white");
								$("#infosun").css("background-color","#00B39E");
							} 
							week /= 2; 
							if(parseInt(week%2)==1) {
								$("#infosat").css("color","#A2A2A2");
								$("#infosat").css("background-color","#FAFAFA");
							} else {
								$("#infosat").css("color","white");
								$("#infosat").css("background-color","#00B39E");
							}
							week /= 2; 
							if(parseInt(week%2)==1) {
								$("#infofri").css("color","#A2A2A2");
								$("#infofri").css("background-color","#FAFAFA");
							} else {
								$("#infofri").css("color","white");
								$("#infofri").css("background-color","#00B39E");
							}
							week /= 2; 
							if(parseInt(week%2)==1) {
								$("#infothu").css("color","#A2A2A2");
								$("#infothu").css("background-color","#FAFAFA");
							} else {
								$("#infothu").css("color","white");
								$("#infothu").css("background-color","#00B39E");
							}
							week /= 2; 
							if(parseInt(week%2)==1) {
								$("#infowed").css("color","#A2A2A2");
								$("#infowed").css("background-color","#FAFAFA");
							} else {
								$("#infowed").css("color","white");
								$("#infowed").css("background-color","#00B39E");
							}
							week /= 2; 
							if(parseInt(week%2)==1) {
								$("#infotue").css("color","#A2A2A2");
								$("#infotue").css("background-color","#FAFAFA");
							} else {
								$("#infotue").css("color","white");
								$("#infotue").css("background-color","#00B39E");
							}
							week /= 2; 
							if(parseInt(week%2)==1) {
								$("#infomon").css("color","#A2A2A2");
								$("#infomon").css("background-color","#FAFAFA");
							} else {
								$("#infomon").css("color","white");
								$("#infomon").css("background-color","#00B39E");
							}
							switch(gender){
								case 0: $("#spgender").html("Хүйс хамаагүй"); break;
								case 1: $("#spgender").html("Хүйс эрэгтэй"); break;
								case 2: $("#spgender").html("Хүйс эмэгтэй"); break;
								default: $("#spgender").html("Хүйс хамаагүй"); break;
							}
							switch(education){
								case 0: $("#speducation").html("Боловсрол хамаагүй"); break;
								case 1: $("#speducation").html("Боловсрол 'Бага' болон түүнээс дээш"); break;
								case 2: $("#speducation").html("Боловсрол 'Дунд' болон түүнээс дээш"); break;
								case 3: $("#speducation").html("Боловсрол 'Бүрэн дунд' болон түүнээс дээш"); break;
								case 4: $("#speducation").html("Боловсрол 'Дээд' болон түүнээс дээш"); break;
								default: $("#speducation").html("Боловсрол хамаагүй"); break;
							}
							switch(age){
								case 0: $("#spage").html("Нас хамаагүй"); break;
								case 1: $("#spage").html("Нас 18-25"); break;
								case 2: $("#spage").html("Нас 25-30"); break;
								case 3: $("#spage").html("Нас 30-45"); break;
								default: $("#spage").html("Нас хамаагүй"); break;
							}
							downloadUrl("imgs/"+id+"/nameList.json", function(data) {
								if(data!=null || data!=""){
									$(".carousel").remove();
									jobimgs = document.createElement("div");
									jobimgs.setAttribute("class","carousel");
									imageNames = JSON.parse(data.responseText);
									if( imageNames!= null){
										$("#spjobpro").attr("src","imgs/"+id+"/"+imageNames[0]);
										for( i=0; i<imageNames.length; i++){
											temp1 = document.createElement("img");
											temp1.setAttribute("src", "imgs/"+id+"/"+imageNames[i]);
											temp1.setAttribute("class", "materialboxed");
											temp2 = document.createElement("div");
											temp2.setAttribute("class", "carousel-item");
											temp2.appendChild(temp1);
											jobimgs.appendChild(temp2);
										}
									}
									$('#slide-out').append(jobimgs);
									$('.materialboxed').materialbox();
									$('.carousel').carousel({
										time_constant: 80,
										dist: -70
									});
								}});
							break;
						}
					}
				}
			}

			function sideNavi(id){
				if(id==-1){
					sideNavTrigg.click();
				} else if(sidepanelstate==0){
					sidepanelChangeContent(id);
					sideNavTrigg.click();
				} else if(sidepanelstate==1){
					sidepanelChangeContent(id);
				}
			}

			//Under Construction
			function toSpecial(id){
				console.log($(".side-nav").scrollTop());
			}

			function updateNavbarWidth(state){
				if(!state){
					sidepanelstate = 0;
					$(".sidenavXbtn").css("right","0px");
				}
				else {
					sidepanelstate = 1;
					$(".sidenavXbtn").css("right","-30px");
				}
			}

			function showForm(str) {
				if (str.length == 0) { 
					document.getElementById("regFormContainer").innerHTML = "";
					return;
				} else {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("regFormContainer").innerHTML = this.responseText;
						}
					};
					xmlhttp.open("GET", "getRegForm.php?q=" + str, true);
					xmlhttp.send();
				}
			}

			var navbr = document.getElementById("navbar"),
			navbrc = document.getElementById("navbarCont"),
			menufab = document.getElementById("menufab");

			function prepareTogetLocationFromUser(){
				$('#regJobModal').closeModal();
				var doneButton = document.getElementById("doneButton");
				var pos = 0;
				var id = setInterval(frame, 3);
				doneButton.style.display = "block";

				showMarker('new');

				function frame() {
					if (pos == -64) {
						clearInterval(id);
						menufab.style.display = "none";
						navbrc.style.zIndex = "-3";
					} else {
						pos--;
						menufab.style.opacity = (1-(pos/-64));
						doneButton.style.opacity = pos/-64;
						navbr.style.top = pos+"px";
					}
				}
				Materialize.toast('Та байршлаа сонгоно уу!', 3000);
				clickListener = map.addListener('click', function(e) {
					addtonewMarkers(e.latLng, map);
				});
			}

			function getLocationFromUser(){
				$('#regJobModal').openModal();
				var doneButton = document.getElementById("doneButton");
				var pos = -64;
				menufab.style.display = "block";
				navbrc.style.zIndex = "998";

				showMarker('job');

				var id = setInterval(frame, 3);
				function frame() {
					if (pos == 0) {
						clearInterval(id);
						doneButton.style.display = "none";
					} else {
						pos++;
						menufab.style.opacity = 1-pos/-64;
						doneButton.style.opacity = (1-(pos/-64));
						navbr.style.top = pos+"px";
					}
				}

				var len = newMarkers.length;
				var lat = [],lng = [];
				for (i = 0; i < len; i++){
					var position = newMarkers[i].position;
					lat.push(position.lat());
					lng.push(position.lng());
				}

				document.getElementById("coordx").setAttribute("value",JSON.stringify(lat));
				document.getElementById("coordy").setAttribute("value",JSON.stringify(lng));


				document.getElementById("locationNumber").innerHTML = newMarkers.length+" байршил орсон байна.";
				google.maps.event.removeListener(clickListener);
			}

		</script>
		<!-- Scripts End -->

	</body>
	</html>	