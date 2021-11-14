function showMenuDropDown(e) {
	setTimeout(function(){
		  $('div.adtm_sub').css('left', '0px');
		}, 1000);
}

function hideMenuDropDown(e) {
	$('div.adtm_sub').css('left', '-9999px');
}