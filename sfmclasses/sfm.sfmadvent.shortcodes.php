<?php
class SFMShortCode {

  var $options;

  function __construct()
	{
		add_action( 'init',   array(&$this,'sfmadvent_shortcodes'));

    /*
    * Global Options
    */
    $this->options = get_option('sfmadvent_options');

	}

  /**
	* Add the shortcodes
	*/
	function sfmadvent_shortcodes()
	{
    // Frontend Kalender
    add_shortcode( 'sfmadvent_calendar', array(&$this,'sfmadvent_calendar_function') );

	// Frontend Form
    add_shortcode( 'sfmadvent_form', array(&$this,'sfmadvent_form_function') );


    //add_action('wp_ajax_send_prb_mails', array( $this, 'send_prb_mails' ));
    //add_action('wp_ajax_nopriv_send_prb_mails', array( $this, 'send_prb_mails' ));

	}


	// Form Funktion

	 public function sfmadvent_form_function($atts)
  {
    ob_start();
    ?>
    <div class="sfm_form_container">
    	<form class="sfm_form">
        <?php $nonce = wp_create_nonce('send_prb_mails_nonce'); ?>
        <input type="hidden" id="mail_nonce" value="<?php echo $nonce;?>">
    		<input class="sfm_input" type="text" id="vorname" placeholder="Vorname" required="">
    		<input class="sfm_input" type="text" id="nachname" placeholder="Nachname" required="">
    		<input class="sfm_input" type="tel" id="tel" placeholder="Handynummer (optional)" required="">
    		<input class="sfm_input" type="email" id="mail" placeholder="E-Mail" required="">
    		<div class="clear"></div>

    		<div class="sfm_form_checkbox"><label for="sfm_form_checkboxid"><input id="sfm_form_checkboxid" type="checkbox" checked name="newsletter" value="newsletter">Ich habe die AGB's gelesen und verstanden.<div class="sfm_form_btn"></div></label></div>
    		<div class="clear"></div><input class="sfm_input" type="submit" value="absenden" id="sfm_form_send">

    	</form>
      <script>
        PRBFrontEnd.prototype.validateParsleyForm();
      </script>
		<div class="clear"></div>
    	<div class="sfm_form_abschlusscreen">
			<span>Vielen Dank für Ihr Interesse!</span><br>Der jeweilige Ansprechpartner setzt sich mit Ihnen in Verbindung.
    	</div>
    </div>
    <?php
    //assign the file output to $content variable and clean buffer
		$content = ob_get_clean();
		return  $content;
  }

	/* Ende der Form Funktion */


  public function sfmadvent_calendar_function($atts)
  {
    ob_start();
    ?>
    <div class="sfm_calendar_container">
      <div class="sfm_calendar_inner">
        <?php
        for($i=1; $i<=24; $i++) {
          ?>
            <div class="sfm_calendar_element">

              <div class="sfm_inner_content">
                <img src="<?php echo sfmadvent_url.'templates/'.sfmadvent_template.'/img/tag'.$i.'.jpg';?>" />
              </div>
              <div class="sfm_left">
                <div class="element_schleife">
                  <img src="<?php echo sfmadvent_url.'templates/'.sfmadvent_template.'/img/schleife.png';?>" />
                </div>
                <div class="element_inner">
                  <?php echo $i;?>
                </div>
              </div>
              <div class="sfm_right">
                <div class="element_schleife">
                  <img src="<?php echo sfmadvent_url.'templates/'.sfmadvent_template.'/img/schleife.png';?>" />
                </div>
                <div class="element_inner">
                  <?php echo $i;?>
                </div>
              </div>
            </div>
          <?php
          if($i %4 == 0) {
            ?>
            <div class="clear"></div>
            <?php
          }
        }
        ?>
      </div>
    </div>
    <?php
    //assign the file output to $content variable and clean buffer
		$content = ob_get_clean();
		return  $content;
  }

}

$key = "shortcode";
$this->{$key} = new SFMShortCode();
