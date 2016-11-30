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
			<span>Du bist mit dabei!</span><br>Vielen Dank für Dein Interesse. Zu Gewinnen gibt es Filialgutscheine: 1x300€, 1x100€, 1x50€ !
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
    $calendarItems = array(115, 117, 142, 143, 144, 145, 146, 147, 148, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164);
    $calendarItems2 = $calendarItems;
    $calendarItems2 = array(4636);

    ?>
    <div class="sfm_calendar_container">

      <div class="sfm_single_item_full day_1">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/01.12.2016.jpg" alt="01-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-0px"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Teelichtschale Miri</h3>
        Mit unserem Gutscheincode gibt es NUR HEUTE die Teelichtschale Miri um nur 9,99 (statt 29,95)! (Artikelnummer 85270033)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv01</b><br><br>
        <a href="https://www.moemax.at/dekoration/wohnaccessoires/dekoobjekte/c8c5c3/moemax-modern-living/teelichtschale-miri-aus-mangoholz.produkt-0085270033" target="_blank"><b>Im Shop ansehen &gt; </b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_2">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/02.12.2016.jpg" alt="02-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Drehstuhl Lewis</h3>
        Hinter dem heutigen Türchen verbirgt sich der Gutscheincode für unseren Drehstuhl Lewis. Den gibt es NUR HEUTE mit Code um nur 77,00 (statt 143,00). Artikelnummer (29260069/01)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv02</b><br><br>
        <a href="https://www.moemax.de/buero-vorzimmer/bueromoebel/buerostuehle/c5c1c3/drehstuhl-in-grau-schwarz.produkt-002926006901"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_3">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/03.12.2016.jpg" alt="03-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Spannleintuch 100x200x28cm</h3>
        Heute gibt es eine 1+1 Aktion! Mit unserem Gutscheincode bekommt Ihr NUR HEUTE eine ein zweites Spannleintuch geschenkt. (Artikelnummer 50540004/01-04,06)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv03</b><br><br>
        <a href="https://www.moemax.de/produkte/suche?fh_search=50540004"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_4">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/04.12.2016.jpg" alt="04-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Kettler Laufrad</h3>
        Das heutige Kalendertürchen bringt Euch einen Gutschein für das Kettler Laufrad. Mit unserem Code kostet es NUR HEUTE statt 59,90 nur 19,90! (Artikelnummer 08180015/01)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv04</b><br><br>
        <a href="https://www.moemax.de/baby-kinderzimmer/spielwaren/c6c3/kettler-hks/kettler-laufrad-speedy-emma.produkt-000818001501"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_5">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/05.12.2016.jpg" alt="05-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Vitrine Lucienne (Trend)</h3>
        Mit unserem heutigen Gutscheincode gibt es die Vitrine Lucienne (Trend) NUR HEUTE um 33,00 (statt 70,00). (Artikelnummer: 04460001/01)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv05</b><br><br>
        <a href="https://www.moemax.de/kuechen-esszimmer/vitrinen/c3c6/vitrine-in-weiss-aus-echtholz.produkt-000446000101"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_6">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/06.12.2016.jpg" alt="06-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Kombiservice Vivo</h3>
        Mit unserem Gutscheincode gibt es NUR HEUTE das Kombiservice Vivo um nur 75,00 (statt 279,00)! (Artikelnummer 34070414/01)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv06</b><br><br>
        <a href="https://www.moemax.de/haushaltswaren/geschirr-glaeser/geschirr/c10c1c1/vivo/kombiservice-vivo-simply-fresh.produkt-003407041401"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_7">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/07.12.2016.jpg" alt="07-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>-30% auf alle Lattenroste und Matratzen</h3>
        Heute haben wir -30% auf alle Lattenroste und Matratzen (außer Werbeware). Aber NUR HEUTE mit unserem Gutscheincode.<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv07</b><br><br>
        <a href="https://www.moemax.at/schlafzimmer/lattenrost.kategorie-C2C2"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_8">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/08.12.2016.jpg" alt="08-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Regal Milla</h3>
        Hinter dem heutigen Türchen verbirgt sich der Gutscheincode für unser Regal Milla. Das gibt es NUR HEUTE mit Code um nur 25,00 (statt 72,00). Artikelnummer (79680027/01)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv08</b><br><br>
        <a href="https://www.moemax.de/wohnzimmer/kommoden-regale/regale/c1c4c2/regal-in-anthrazit-weiss.produkt-007968002701"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_9">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/09.12.2016.jpg" alt="09-12-2016" width="360" height="280"></div></div>        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Daunendecke Premium Warm</h3>
        Das heutige Kalendertürchen bringt Euch einen Gutschein für die Daunendecke Premium Warm. Mit unserem Code kostet sie NUR HEUTE statt 199,00 nur 99,00! (Artikelnummer 79920185/03)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv09</b><br><br>
        <a href="https://www.moemax.de/heimtextilien-teppiche/schlaftextilien/einziehdecken-kopfkissen/c9c2c3/premium-living/kassettendecke-premium-warm.produkt-007992018503"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_10">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/10.12.2016.jpg" alt="10-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Kindersitzgruppe Star</h3>
        Heute gibt es mal etwas für die Kleinen: Die Kindersitzgruppe Star gibts NUR HEUTE mit unserem Code um nur 77,00 (statt 241,00). (Artikelnummer 18030401/01)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv10</b><br><br>
        <a href="https://www.moemax.de/baby-kinderzimmer/kinderzimmer/kinderzimmermoebel/c6c2c3/kindersitzgruppe-in-blau-gelb-gruen-rot-weiss.produkt-001803040101"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_11">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/besteckset.jpg" alt="11-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Besteckset Vienna</h3>
        Mit unserem heutigen Gutscheincode gibt es das Besteckset Vienna NUR HEUTE für 39,00 (statt 189,00). (Artikelnummer: 3050004701)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv11</b><br><br>
        <a href="https://www.moemax.de/haushaltswaren/besteck/c10c2/berndorf/besteckset-vienna-berndorf-30-tlg-.produkt-003050004701"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_12">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/12.12.2016.jpg" alt="12-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Fernsehsessel Ancona</h3>

        Mit unserem Gutscheincode gibt es NUR HEUTE den Fernsehsessel Ancona um nur 222,00 (statt 493,00)! (Artikelnummer 01810020/01)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv12</b><br><br>

        <a href="https://www.moemax.de/wohnzimmer/hocker-sessel/fernsehsessel/c1c2c2/moemax-modern-living/fernsehsessel-in-schwarz.produkt-000181002001"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_13">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/13.12.2016.jpg" alt="13-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Multi-Küchenmaschine</h3>
        Hinter dem heutigen Türchen verbirgt sich der Gutscheincode für unsere Multi-Küschenmaschine. Diese gibt es NUR HEUTE mit Code um nur 129,00 (statt 499,00). Artikelnummer (79070001)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv13</b><br><br>
        <a href="https://www.moemax.de/haushaltswaren/haushaltselektronik/c10c6/based/multi-kuechenmaschine-dana-in-weiss-aus-metall.produkt-0079070001"><b>Im Shop ansehen &gt;</b></a>
        </div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_14">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/14.12.2016.jpg" alt="14-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Couchtisch Kian (Trend)</h3>
        Das heutige Kalendertürchen bringt Euch einen Gutschein für den Couchtisch Kian. Mit unserem Code kostet er NUR HEUTE statt 199,00 nur 66,00! (Artikelnummer 18110007/01)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv14</b><br><br>
        <a href="https://www.moemax.de/wohnzimmer/couchtische/c1c5/couchtisch-in-schwarz-mit-glas.produkt-001811000701"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_15">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/15.12.2016.jpg" alt="15-12-2016" width="360" height="280"></div></div></div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Dekobaum Christmas Tree (Höhe: 118 cm)</h3>
        Mit unserem heutigen Gutscheincode gibt es den Dekobaum Christmas Tree (Höhe: 118 cm) NUR HEUTE um 14,99 (statt 39,99). (Artikelnummer: 90290009)<br><br>
        <b style="color:#ec008c;">Gutscheincode: adv15</b><br><br>
        <a href="https://www.moemax.de/dekoration/wohnaccessoires/dekoobjekte/c8c5c3/moemax-modern-living/dekobaum-christmas-tree-in-weiss.produkt-0090290009"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_16">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/16.12.2016.jpg" alt="16-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Kindersessel Kiddy</h3>

        Für unsere Kleinen: Den Kindersessel Kiddy gibts NUR HEUTE mit unserem Code um nur 66,00 (statt 166,00). (Artikelnummer 12430002/01-02)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv16</b><br><br>

        <a href="https://www.moemax.de/products/search/kindersessel-theme_liveshopping&quot;"><b>Im Shop ansehen &gt;</b></a>
        </div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_17">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/17.12.2016.jpg" alt="17-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Electroscooter</h3>

        Hinter dem heutigen Türchen verbirgt sich der Gutscheincode für unseren Electroscooter. Den gibt es NUR HEUTE mit Code um nur 222,00 (statt 499,00). Artikelnummer (80210081/01-02)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv17</b><br><br>

        <a href="https://www.moemax.de/baby-kinderzimmer/spielwaren/c6c3/elektroscooter-thomas-in-weiss-mit-faltrahmen.produkt-008021008102"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_18">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/stabmixer.jpg" alt="18-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Stabmixer Gorenje</h3>

        Das heutige Kalendertürchen bringt Euch einen Gutschein für den Stabmixer Gorenje. Diesen gibt es NUR HEUTE mit Code um nur 19,90 (statt 49,00). Artikelnummer (111005301)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv18</b><br><br>

        <a href="https://www.moemax.de/haushaltswaren/haushaltselektronik/mixer/c10c6c1/gorenje/gorenje-stabmixer.produkt-000111005301"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_19">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/19.12.2016.jpg" alt="19-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Fadenstore String</h3>

        Heute gibt es mit unserem Gutschein den Fadenstore String. Mit dem Code kostet er NUR HEUTE um 14,99 (statt 29,95). (Artikelnummer: 39170503/01,25,27,28,30)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv19</b><br><br>

        <a href="https://www.moemax.de/produkte/suche?fh_search=39170503" target="_blank"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_20">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/20.12.2016.jpg" alt="20-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Hocker Ruby (Trend)</h3>

        Hinter dem heutigen Türchen verbirgt sich der Gutscheincode für unseren Hocker Ruby (Trend). Den gibt es NUR HEUTE mit Code um nur 55,00 (statt 139,00). Artikelnummer (12430015/01)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv20</b><br><br>

        <a href="https://www.moemax.de/wohnzimmer/hocker-sessel/hocker/c1c2c4/hocker-in-dunkelgruen.produkt-001243001501" target="_blank"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_21">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/21.12.2016.jpg" alt="21-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Schaffell Melissa</h3>

        Das heutige Kalendertürchen bringt Euch einen Gutschein für das Schaffell Melissa. Mit unserem Code kostet es NUR HEUTE statt 07,00 nur 19,99! (Artikelnummer 42280010/01)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv21</b><br><br>

        <a href="https://www.moemax.de/heimtextilien-teppiche/teppiche-fussmatten/teppiche/c9c5c1/moemax-modern-living/kunstfell-melissa.produkt-004228001001" target="_blank"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_22">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/22.12.2016.jpg" alt="22-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Laterne Manuela (mit 3 LED-Kerzen)</h3>

        Mit unserem heutigen Gutscheincode gibt es die Laterne Manuela. NUR HEUTE um 14,99 (statt 49,95). (Artikelnummer: 51960001/01-03)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv22</b><br><br>

        <a href="https://www.moemax.de/produkte/suche?fh_search=51960001" target="_blank"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_23">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/23.12.2016.jpg" alt="23-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=""><h3>Schaukelstuhl Alva (Trend)</h3>

        Hinter dem heutigen Türchen verbirgt sich der Gutscheincode für unsern Schaukelstuhl Alva (Trend). Das gibt es NUR HEUTE mit Code um nur 79,00 (statt 159,00). Artikelnummer (21350011/01)<br><br>

        <b style="color:#ec008c;">Gutscheincode: adv23</b><br><br>

        <a href="https://www.moemax.de/wohnzimmer/hocker-sessel/relaxsessel/c1c2c1/schaukelstuhl-in-weiss-aus-echtholz.produkt-002135001101" target="_blank"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>
      <div class="sfm_single_item_full day_24">
        <div class="wrap mcb-wrap one  valign-top clearfix" style=""><div class="mcb-wrap-inner"><div class="column mcb-column two-fifth column_image "><div class="image_frame image_item no_link scale-with-grid no_border"><div class="image_wrapper"><img class="scale-with-grid" src="http://mmkalender.wpdev.at/wp-content/uploads/2016/11/24.12.2016.jpg" alt="24-12-2016" width="360" height="280"></div></div>
        </div><div class="column mcb-column three-fifth column_column  column-margin-"><div class="column_attr clearfix" style=" padding:50px 0 0 0;"><h3>Stuhl Greta</h3>

        FROHE WEIHNACHTEN! Heute öffnet sich das letzte Türchen und es gibt einen Gutscheincode für den Stuhl Greta. NUR HEUTE um 111,00 (statt 266,00). (Artikelnummer 12890010/01-03)<br><br>


        <b style="color:#ec008c;">Gutscheincode: adv24</b><br><br>

        <a href="https://www.moemax.de/produkte/suche?fh_search=12890010" target="_blank"><b>Im Shop ansehen &gt;</b></a></div></div></div></div>
      </div>



      <div class="sfm_calendar_inner">
        <?php
        $actualDate = date('j');
        $actualDate = 4;
        $isLink = true;

        for($i=1; $i<=24; $i++) {
          $calendarItem = array_shift($calendarItems);


          if($actualDate > $i) {
            //$calendarClass = 'opened';
            //dashier$calendarClass = 'toBeOpened';
            $calendarClass = 'openedToday';
            $isLink = false;
          } else if($actualDate == $i) {
            $calendarClass = 'openedToday';
            $isLink = true;
          } else if($actualDate < $i) {
            //dashier$calendarClass = 'toBeOpened';
            $calendarClass = 'openedToday';
          }


          ?>
            <div data-day="<?php echo $i;?>" class="sfm_calendar_element <?php echo $calendarClass;?>">

              <div class="sfm_inner_content">
                <?php
                if($isLink) {
                  /*?>
                    <a href="?p=<?php echo $calendarItem;?>">
                  <?php*/
                }
                ?>
                  <img src="<?php echo sfmadvent_url.'templates/'.sfmadvent_template.'/img/tag'.$i.'.jpg';?>" />
                <?php
                if($isLink) {
                  /*?>
                    </a>
                  <?php*/
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
            <div class="sfm_range_<?php echo $i;?> sfm_show_single_item_full">

            </div>
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
