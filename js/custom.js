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
		this.formSubmit();
	},
	validateParsleyForm: function() {
		jQuery('.sfm_form').parsley();
	},
	calendarEffect: function() {

		jQuery('.sfm_calendar_element').hover(function() {
			/*jQuery(this).find('.sfm_left').filter(':not(:animated)').animate({
				left: '-3%'
			}, 300);

			jQuery(this).find('.sfm_right').filter(':not(:animated)').animate({
				right: '-3%'
			}, 300);


		}, function() {
			jQuery(this).find('.sfm_left').animate({
				left: '-0%'
			}, 300);

			jQuery(this).find('.sfm_right').animate({
				right: '-0%'
			}, 300);*/

		})

		jQuery('.sfm_calendar_element.toBeOpened').each(function(index) {

			//jQuery(this).addClass('animate');

			jQuery(this).find('.sfm_left').delay(100*index).fadeIn(300);
			jQuery(this).find('.sfm_right').delay(100*index).fadeIn(300);
			jQuery(this).find('.sfm_inner_content').delay(100*index).fadeIn(1000);
			//jQuery(this).delay(400*index).fadeIn(300);
			//jQuery(this).delay(400*index).fadeIn(300).css('display', 'inline-block');
			//jQuery(this).delay(400*index).css('display', 'inline-block');
		})


		//jQuery('.sfm_calendar_element').toggle( "bounce", { times: 3 },'fast');


		jQuery('.sfm_calendar_element.openedToday').click(function() {



			var index_day = jQuery(this).attr('data-day');


			var range = 4;
			if(index_day %4 == 0) {
				range = index_day;
			} else {
				var range_day = index_day+1;
				if(range_day %4 == 0) {
					range = range_day;
				} else {
					range_day = range_day+1;
					if(range_day %4 == 0) {
						range = range_day;
					} else {
						range_day = range_day+1;
						if(range_day %4 == 0) {
							range = range_day;
						} else {
							range_day = range_day+1;
							if(range_day %4 == 0) {
								range = range_day;
							}
						}
					}
				}
			}

			jQuery(this).find('.sfm_left').animate({
				left: '-52%'
			}, 2000);

			jQuery(this).find('.sfm_right').animate({
				right: '-52%'
			}, 2000, function() {
				//jQuery('.sfm_calendar_inner').hide('slow');
				jQuery('.day_'+index_day).appendTo('.sfm_range_'+range).show('slow');
			});
			jQuery(this).addClass('hoverEffect');
		});

		//jQuery('.sfm_calendar_container')

	},
	formSubmit: function() {


		jQuery('.sfm_form').submit(function(evt) {



			// Validierung hier
			if(jQuery('.sfm_form').parsley().validate()) {

				var vorname = jQuery('.sfm_form #vorname').val();
				var nachname = jQuery('.sfm_form #nachname').val();
				var tel = jQuery('.sfm_form #tel').val();
				var mail = jQuery('.sfm_form #mail').val();
				var nonce = jQuery('.sfm_form #sub_nonce').val();

				var addSub = jQuery.ajax({
						url : Custom.ajaxurl,
						type : 'post',
						data : {
							 action: 'add_new_sub',
							 vorname: vorname,
							 nachname: nachname,
							 tel: tel,
							 mail: mail,
							 nonce : nonce
						},
						beforeSend: function( xhr ) {
							jQuery('.sfm_form_container').append('<div class="xhrWait"><center><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br /><br />Deine Anfrage wird bearbeitet. Bitte habe ein wenig Geduld.</center></div>');
							jQuery('.sfm_form').hide();
							//jQuery(that).parent().append('<center><i style="font-size: 14px;color:#EA4E92;" class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> wird bearbeitet</center>');
							//jQuery('.edit, .close, .delete').remove();
						},
						error : function(error) {
							console.log(error)
							alert('Keine Berechtigung')
						}
				})

				addSub.done(function(response) {
					jQuery('.prb_form').hide();
					jQuery('.xhrWait').remove();
					jQuery('.sfm_form_abschlusscreen').show();
					console.log(response);
				})
				return false;
			}

			return false;
		})
	},
}
