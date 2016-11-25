<?php
class SFMShortCode {

  var $options;

  function __construct()
	{
		add_action( 'init',   array(&$this,'sfmadvent_shortcodes'));

    // Our custom post type function
    add_action( 'init', array(&$this, 'create_custom_post_type' ));

    // Custom Meta Box
    add_action( 'add_meta_boxes', array(&$this, 'create_custom_meta_box' ));

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

    add_action('wp_ajax_add_new_sub', array( $this, 'add_new_sub' ));
    add_action('wp_ajax_nopriv_add_new_sub', array( $this, 'add_new_sub' ));

	}

  public function add_new_sub()
  {

    if ( !wp_verify_nonce( $_REQUEST['nonce'], "add_new_sub_nonce")) {
      // TODO ERRORE zurücksenden
      exit("No naughty business please");
    }

    $vorname = strip_tags($_REQUEST['vorname']);
    $nachname = strip_tags($_REQUEST['nachname']);
    $tel = strip_tags($_REQUEST['tel']);
    $mail = strip_tags($_REQUEST['mail']);


    // Neuen Teilnehmer hinzufügen
    $new_sub = array(
      'post_title'    => wp_strip_all_tags( $vorname. ' ' .$nachname ),
      'post_status'   => 'publish',
      'post_type'     => 'teilnehmer',
      'post_author'   => 1,
    );

    // Teilnehmer hinzufügen
    $teilnehmer_id = wp_insert_post( $new_sub );

    // Alle Daten dem Teilnehmer zuordnen
    if($teilnehmer_id !== 0) {

      update_post_meta($teilnehmer_id, 'Vorname', $vorname);
      update_post_meta($teilnehmer_id, 'Nachname', $nachname);
      update_post_meta($teilnehmer_id, 'Telefon', $tel);
      update_post_meta($teilnehmer_id, 'E-Mail', $mail);

    }



    die();
  }


	// Form Funktion

	 public function sfmadvent_form_function($atts)
  {
    ob_start();
    ?>
    <div class="sfm_form_container">
    	<form class="sfm_form">
        <?php $nonce = wp_create_nonce('add_new_sub_nonce'); ?>
        <input type="hidden" id="sub_nonce" value="<?php echo $nonce;?>">
    		<input class="sfm_input" type="text" id="vorname" placeholder="Vorname" required="">
    		<input class="sfm_input" type="text" id="nachname" placeholder="Nachname" required="">
    		<input class="sfm_input" type="tel" id="tel" placeholder="Handynummer (optional)" required="">
    		<input class="sfm_input" type="email" id="mail" placeholder="E-Mail" required="">
    		<div class="clear"></div>

    		<div class="sfm_form_checkbox">
          <label for="sfm_form_checkboxid">
            <input id="sfm_form_checkboxid" required="" type="checkbox" checked name="newsletter" value="newsletter" />
            <div class="sfm_form_btn"></div>
            Ich habe die <a href="/teilnahmebedingungen">AGB's</a> gelesen und verstanden.
          </label>
        </div>
    		<div class="clear"></div><input class="sfm_input" type="submit" value="absenden" id="sfm_form_send">

    	</form>
      <script>
        SFMFrontEnd.prototype.validateParsleyForm();
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
        $actualDate = date('j');
        $actualDate = 10;
        $isLink = true;
        $calendarItems = array(115, 117, 142, 143, 144, 145, 146, 147, 148, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164);
        for($i=1; $i<=24; $i++) {
          $calendarItem = array_shift($calendarItems);


          if($actualDate > $i) {
            $calendarClass = 'opened';
            $isLink = false;
          } else if($actualDate == $i) {
            $calendarClass = 'openedToday';
            $isLink = true;
          } else if($actualDate < $i) {
            $calendarClass = 'toBeOpened';
          }


          ?>
            <div class="sfm_calendar_element <?php echo $calendarClass;?>">

              <div class="sfm_inner_content">
                <?php
                if($isLink) {
                  ?>
                    <a href="?p=<?php echo $calendarItem;?>">
                  <?php
                }
                ?>
                  <img src="<?php echo sfmadvent_url.'templates/'.sfmadvent_template.'/img/tag'.$i.'.jpg';?>" />
                <?php
                if($isLink) {
                  ?>
                    </a>
                  <?php
                }
                ?>

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
          $calendarItem++;
        }
        ?>
      </div>
    </div>

    <script>
    jQuery(document).ready(function() {
      jQuery.fn.snow();
    })
    </script>
    <?php
    //assign the file output to $content variable and clean buffer
		$content = ob_get_clean();
		return  $content;
  }

  /*
  * Custom Meta Box
  */
  function create_custom_meta_box()
  {
    add_meta_box(
      'custom-sub-box',      // Unique ID
      'Teilnehmer Informationen',    // Title
      array(&$this, 'sub_meta_box' ),   // Callback function
      'teilnehmer',         // Admin page (or post type)
      'normal',         // Context
      'default'         // Priority
    );
  }

  /*
  * Meta Box
  * Backend Anzeigen der Teilnehmer
  */
  function sub_meta_box( $object, $box ) {

    $subMeta = get_post_meta($object->ID);

    ?>
    <div class="postbox" id="boxid">
      <div class="marginTopMedium marginBottomMedium subInfo">
        <?php
        foreach($subMeta as $key => $value) {
          $this->showSubInformation($key, $value, $object->ID);
        }
        ?>
      </div>
    </div>

  <?php
 }

 /*
  * Custom Post Type
  * Gewinnspielteilnehmer
  */
  function create_custom_post_type() {
    register_post_type( 'teilnehmer',
    // CPT Options
        array(
            'labels' => array(
                'name' => 'Teilnehmer',
            ),
            'public'    => false,
            'show_ui'            => true,
		        'show_in_menu'       => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'teilnehmer'),
            'supports' => array('title','thumbnail')
        )
    );
  }

  /*
  * show Subscriber Info
  */
  function showSubInformation($field, $value, $subID) {

    switch($field) {
      case 'Vorname':
        $label = $field;
        $value = $value[0];
        break;
      case 'Nachname':
        $label = $field;
        $value = $value[0];
        break;
      case 'E-Mail':
        $label = $field;
        $value = $value[0];
        break;
      case 'Telefon':
        $label = $field;
        $value = $value[0];
        break;
      default:
        $label = '';
        $value = '';
    }

    if(!empty($label) && !empty($value) ) {

     ?>

     <div class="field">
       <div class="label">
         <?php echo $label; ?>
       </div>
       <div class="value">
         <?php echo $value;?>
       </div>
     </div>

     <?php
   }
 }


}

$key = "shortcode";
$this->{$key} = new SFMShortCode();
