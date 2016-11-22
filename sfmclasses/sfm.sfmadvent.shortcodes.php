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
    // Frontend Form
    add_shortcode( 'sfmadvent_calendar', array(&$this,'sfmadvent_calendar_function') );


    //add_action('wp_ajax_send_prb_mails', array( $this, 'send_prb_mails' ));
    //add_action('wp_ajax_nopriv_send_prb_mails', array( $this, 'send_prb_mails' ));

	}

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
                <img src="<?php echo sfmadvent_url.'templates/'.sfmadvent_template.'/img/tag1.jpg';?>" />
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
