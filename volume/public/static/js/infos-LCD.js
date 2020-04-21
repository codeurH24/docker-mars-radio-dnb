	var animationMessageRadio = function()
		{
			$("#messageContenueRadio").animate({marginLeft: "660px"}, 5, "linear");
			$("#messageContenueRadio").animate({marginLeft: "-1800px"}, 40000, "linear", function()
			{
				
			});
			
		}
	
	$(document).ready(function(){	

		console.log('test')
		animationMessageRadio();
		setInterval(function()
		{
			$("#messageContenueRadio").animate({marginLeft: "660px"}, 5, "linear");
			$("#messageContenueRadio").animate({marginLeft: "-1800px"}, 30000, "linear");
			
		},55000);	 
		
	});