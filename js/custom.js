jQuery(document).ready(function(jQuery)
{


	sfm_frontend = new SFMFrontEnd();



});

function SFMFrontEnd() {
  this.init();
};

SFMFrontEnd.prototype = {
	/* Alles wichtige was am Anfang gebraucht wird */
	init:function () {
		/* Aufrufen von wichtigen Funktionen */
		this.calendarEffect();
	},
	calendarEffect: function() {

		jQuery('.sfm_calendar_element').click(function() {

			jQuery(this).find('.left').animate({
				left: '-100%'
			}, 2500);

			jQuery(this).find('.right').animate({
				right: '-100%'
			}, 2500);

		});
	},
}
