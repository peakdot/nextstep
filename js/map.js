var map;
var markers = [];
var newMarkers = [];
var filtermarkers = [];
var jobs = [];
var markerIcon = "imgs/markerf.png";
var infoWindow;
var xml;

function initialize() {
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat: 47.9166, lng: 106.9175},

    zoomControl: false,
    mapTypeControl: false,
    scaleControl: false,
    streetViewControl: true,
    rotateControl: false,
    fullscreenControl: false,
    clickableIcons: false


  });


  infoWindow = new google.maps.InfoWindow;

  google.maps.event.addListener(infoWindow, 'domready', function() {
    // Reference to the DIV which receives the contents of the infowindow using jQuery
    var iwOuter = $('.gm-style-iw');

    /* The DIV we want to change is above the .gm-style-iw DIV.
    * So, we use jQuery and create a iwBackground variable,
    * and took advantage of the existing reference to .gm-style-iw for the previous DIV with .prev().
    */
    var iwBackground = iwOuter.prev();

    // Remove the background shadow DIV
    iwBackground.children(':nth-child(2)').css({'display' : 'none'});

    // Remove the white background DIV
    iwBackground.children(':nth-child(4)').css({'display' : 'none'});

    // Changes the desired tail shadow color.
    iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': '0px 1px 6px black', 'z-index' : '1'});


  });

  /*id
  name
  lat
  lng
  type
  SalaryMin
  SalaryMax
  wtimeStart
  wtimeEnd
  createdDate
  createdBy*/


  clickListener = map.addListener('click', function(e) {
    infoWindow.close();
  });

  downloadUrl("genLocXML.php", function(data) {
    xml = data.responseXML;
    if(xml != null){
      var markersXML = xml.documentElement.getElementsByTagName("marker");
      console.log(xml);
      for (var i = 0; i < markersXML.length; i++) {
        var id = parseInt(markersXML[i].getAttribute("id"));
        var name = markersXML[i].getAttribute("name");
        var type = parseInt(markersXML[i].getAttribute("type"));
        var point = new google.maps.LatLng(
          parseFloat(markersXML[i].getAttribute("lat")),
          parseFloat(markersXML[i].getAttribute("lng")));        
        var SalaryMax = parseInt(markersXML[i].getAttribute("SalaryMax"));
        var SalaryMin = parseInt(markersXML[i].getAttribute("SalaryMin"));
        var wtimeStart = parseInt(markersXML[i].getAttribute("wtimeStart"));
        var wtimeEnd = parseInt(markersXML[i].getAttribute("wtimeEnd"));
        var createdDate = markersXML[i].getAttribute("createdDate");
        var html = "<div class=\"mapiw\"><div class=\"mapiwtext\">" +id + "<br/>" + name + "<br/><b>Цалин: <b/>" + SalaryMin + "-" + SalaryMax+"<br/><b>Ажиллах цаг: <b/>"+wtimeStart+" цагаас " + wtimeEnd + " хүртэл<br/><b>Бүртгэсэн огноо: <b/>"+createdDate+"<br/></div><a href=\"#!\" onclick=\"sideNavi(" + id.toString() + ")\" class=\"waves-effect waves-green btn-flat\">"+"Дэлгэрэнгүй</a><a href=\"#!\" onclick=\"toSpecial(" + id.toString() + ")\" class=\"waves-effect waves-teal btn-flat\">Онцлох</a></div>";
        var marker = new google.maps.Marker({
          map: map,
          position: point,
          animation: google.maps.Animation.DROP,
          icon: markerIcon
        });
        markers.push(marker);
        bindInfoWindow(marker, map, infoWindow, html);
      }
    }});
}

function filtermapmarkers(filter){
  if(xml != null){
    var markersXML = xml.documentElement.getElementsByTagName("marker");
    filtermarkers = [];
    setalljobMarkers(null);
    for (var i = 0; i < markersXML.length; i++) {
      var id = parseInt(markersXML[i].getAttribute("id"));
      var name = markersXML[i].getAttribute("name");
      var type = parseInt(markersXML[i].getAttribute("type"));
      var point = new google.maps.LatLng(
        parseFloat(markersXML[i].getAttribute("lat")),
        parseFloat(markersXML[i].getAttribute("lng")));        
      var SalaryMax = parseInt(markersXML[i].getAttribute("SalaryMax"));
      var SalaryMin = parseInt(markersXML[i].getAttribute("SalaryMin"));
      var wtimeStart = parseInt(markersXML[i].getAttribute("wtimeStart"));
      var wtimeEnd = parseInt(markersXML[i].getAttribute("wtimeEnd"));
      var createdDate = markersXML[i].getAttribute("createdDate");
      if(type != filter.type && SalaryMax > filter.fsalarymin && SalaryMin < filter.fsalarymax && wtimeStart < filter.ftimestart && wtimeEnd > filter.timeend) {
        var html = "<div class=\"mapiw\"><div class=\"mapiwtext\">" +id + "<br/>" + name + "<br/><b>Цалин: <b/>" + SalaryMin + "-" + SalaryMax+"<br/><b>Ажиллах цаг: <b/>"+wtimeStart+" цагаас " + wtimeEnd + " хүртэл<br/><b>Бүртгэсэн огноо: <b/>"+createdDate+"<br/></div><a href=\"#!\" onclick=\"sideNavi(" + id.toString() + ")\" class=\"waves-effect waves-green btn-flat\">"+"Дэлгэрэнгүй</a><a href=\"#!\" onclick=\"toSpecial(" + id.toString() + ")\" class=\"waves-effect waves-teal btn-flat\">Онцлох</a></div>";
        var marker = new google.maps.Marker({
          map: map,
          position: point,
          animation: google.maps.Animation.DROP,
          icon: markerIcon
        });
        filtermarkers.push(marker);
        bindInfoWindow(marker, map, infoWindow, html);
      }
    }
    showMarker('filter');
  }
}

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
} 

function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
  new ActiveXObject('Microsoft.XMLHTTP') :
  new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open('GET', url, true);
  request.send(null);
}

function doNothing() {}

//]]>


// Sets the map on all markers in the array.
function setallfilterMarkers(map) {
  var len = filtermarkers.length;
  for (var i = 0; i < len; i++) {
    filtermarkers[i].setMap(map);
  }
}

// Sets the map on all markers in the array.
function setallnewMarkers(map) {
  var len = newMarkers.length;
  for (var i = 0; i < len; i++) {
    newMarkers[i].setMap(map);
  }
}

// Sets the map on all markers in the array.
function setalljobMarkers(map) {
  var len = markers.length;
  for (var i = 0; i < len; i++) {
    markers[i].setMap(map);
  }
}

// Adds a marker to the map and push to the array.
function addtonewMarkers(latLng, map) {
  var len = newMarkers.length;
  var marker = new google.maps.Marker({
    position: latLng,
    map: map,
    animation: google.maps.Animation.DROP,
    icon: markerIcon
  }); 
  marker.addListener('click', function(e) {
    var len = newMarkers.length;
    for (var i = 0; i < len; i++) {
      if(newMarkers[i].position == e.latLng){
        var tempmark = newMarkers[i];
        newMarkers[i] = newMarkers[len-1];
        newMarkers[len-1] = tempmark;
        newMarkers[len-1].setMap(null);
        newMarkers.pop();
        len--;
      }
    }
    console.log(newMarkers);
  });
  newMarkers.push(marker);
}

function showMarker(type){
  switch(type){
    case 'job': {
      setallfilterMarkers(null);
      setallnewMarkers(null);
      setalljobMarkers(map);
      break;
    }
    case 'new': {
      setallfilterMarkers(null);
      setallnewMarkers(map);
      setalljobMarkers(null);
      break;
    }
    case 'filter': {
      setallfilterMarkers(map);
      setallnewMarkers(null);
      setalljobMarkers(null);
      break;
    }
    default: {
      setallfilterMarkers(null);
      setallnewMarkers(null);
      setalljobMarkers(map);
    }
  }
}

function deletenewMarkers() {
  showMarker('job');
  newMarkers = [];
}
