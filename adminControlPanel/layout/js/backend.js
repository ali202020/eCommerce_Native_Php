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



	



});


