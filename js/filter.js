currtptimestart = 9;
currtptimeend = 18;
filterstatus = false;
filter = $("#filter");

function showFilter(){
	if(filterstatus==false){
		filter.css('right','10px');
		filterstatus = true;
	} else {
		filter.css('right','-310px');
		filterstatus = false;
	}
}

function activatetp(t){
	if(t==0){
		$('#tp-time1').addClass('selecteded');
		$('#tp-time2').removeClass('selecteded');					
	} else {
		$('#tp-time2').addClass('selecteded');
		$('#tp-time1').removeClass('selecteded');		
	}
}

function setclock(time){
	if ($('#tp-time1').hasClass('selecteded')){
		$('#timepincircle1').attr('transform','rotate('+time*15+' 100 100)');
		$('#timepin1').attr('transform','rotate('+time*15+' 100 100)');
		$('#tp-'+time).attr('fill','white');
		if(currtptimestart%2==1)
			$('#tp-'+currtptimestart).attr('fill','#e0e0e0');
		else
			$('#tp-'+currtptimestart).attr('fill','black');
		currtptimestart = time
		$('#tp-time1').html(currtptimestart+':00');
	} else {
		setclockend(time);
	}
}

function setclockend(time){
	$('#timepincircle2').attr('transform','rotate('+time*15+' 100 100)');
	$('#timepin2').attr('transform','rotate('+time*15+' 100 100)');
	$('#tp-'+time).attr('fill','white');
	if(currtptimeend%2==1)
		$('#tp-'+currtptimeend).attr('fill','#e0e0e0');
	else
		$('#tp-'+currtptimeend).attr('fill','black');
	currtptimeend = time
	$('#tp-time2').html(currtptimeend+':00');
}

function getfilterparas(){
	var jwork = $('#fjobtype').val();
	var jsalarymin = $('#fsalarymin').val();
	var jsalarymax = $('#fsalarymax').val();
	var jweekinfo = [0,0,0,0,0,0,0];
	var result = {fwork:"", as:"500", color:"white"};
	var jweeks = $('.fweekday');
	for (var i = 0; i < 7; i++) {
		if (jweeks[i].className.indexOf("active")!=-1){
			switch(i){
				case 0: jweekinfo[0] = 1; break;
				case 1: jweekinfo[1] = 1; break;
				case 2: jweekinfo[2] = 1; break;
				case 3: jweekinfo[3] = 1; break;
				case 4: jweekinfo[4] = 1; break;
				case 5: jweekinfo[5] = 1; break;
				case 6: jweekinfo[6] = 1; break;
			}
		}
	}
	return {'fwork': jwork, 'fsalarymin': jsalarymin, 'fsalarymax': jsalarymax, 'fweeks': jweeks, 'ftimestart': currtptimestart, 'ftimeend': currtptimeend};
}