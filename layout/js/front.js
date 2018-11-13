$(function()
{
	'use strict';

	//Hide Placeholser On Form Focus
	$("[placeholder]")
		.focus(function()
		{
			$(this).attr('data-text' , $(this).attr('placeholder'));  // As i got : he used 'data-text' as a temp storage for the value of the place holder
			$(this).attr('placeholder' , '');

		})
		.blur(function()
		{
			$(this).attr('placeholder' , $(this).attr('data-text'));

		});

	//Confirmation Message On Deleting User
	$('.confirm').click(function()
		{
			return confirm('Are You sure That You Want To Proceed !');
		});

	//Login/SignUp Toggle
	$('.login-page h1 span').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
		//hide all forms
		$('.login-page form').hide();
		/* show the form of 'class' matching 'dataclass' by the following:
		firstly:obtaining the class name */
		var className = $(this).data('log-sign');
		//console.log(className);
		/*secondly: showing the element of that class*/
		$('.'+className).show();
	});	

	//live preview (price,description,name)
	$('.live-update').keyup(function(){
		$('#'+$(this).data('live')).text($(this).val());
	});



	



});


