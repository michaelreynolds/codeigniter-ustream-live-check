$(document).ready(function(){
	$(function() {
		//timer.stop();
		//timer.reset(15000);
		var timer = $.timer(15000, function() { //check every 15 seconds
			$.getJSON('/index.php/live/check', function(data) {
				//alert(data['live']);
				if (data['live'] == true){
					//alert('true');
					if(window.location.pathname == "/"){
						window.location.reload();
					}
			    }
			    else {
			    	//alert('false');
			    	if(window.location.pathname == "/live"){
				    	window.location.reload();
					}
			    }
			});
		});
	});
});