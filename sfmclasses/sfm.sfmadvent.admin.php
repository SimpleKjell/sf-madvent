<?php
class SFMAdmin
{
  var $options;
  var $wp_all_pages = false;

  function __construct() {


    $this->options = get_option('sfmadvent_options');


		/* Plugin slug and version */
		$this->slug = 'sf-madvent';
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$this->plugin_data = get_plugin_data( sfmadvent_path . 'sf-madvent.php', false, false);
		$this->version = $this->plugin_data['Version'];


		/* Priority actions */
		//add_action('admin_menu', array(&$this, 'add_menu'), 9);
    add_action('admin_enqueue_scripts', array(&$this, 'add_admin_styles'), 9);
		//add_action('admin_init', array(&$this, 'admin_init'), 9);


    //add_action('wp_ajax_delete_donation', array( $this, 'delete_donation' ));
    //add_action('wp_ajax_nopriv_show_dank_screen', array( $this, 'show_dank_screen' ));

	}

  /*public function delete_donation()
  {
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "delete_donation_nonce")) {
      // TODO ERRORE zurücksenden
      exit("No naughty business please");
    }

    $donationID = $_REQUEST['id'];
    $donations = $this->options['prb_donations'];
    //$donations = array_reverse($donations);

    //var_dump($donations[$donationID]);
    unset($donations[$donationID]);

    $donations = array_values($donations);

    //$donations = array_reverse($donations);
    $this->prbreakfast_set_option('prb_donations',$donations);
    die();
  }*/

  function add_admin_styles()
  {


    /* Custom style */
    wp_register_style( 'sfmadvent_admin_style', sfmadvent_url.'admin/css/custom_admin.css');
    wp_enqueue_style('sfmadvent_admin_style');

    //wp_register_script('sfprb_custom_admin_js', sfprbreakfast_url.'admin/js/admin_custom.js',array('jquery'));
		// ajaxurl mitgeben
		//wp_localize_script( 'sfprb_custom_admin_js', 'Custom', array('ajaxurl'  => admin_url( 'admin-ajax.php' ),'homeurl' => home_url()));
		//wp_enqueue_script('sfprb_custom_admin_js');

    //wp_register_style( 'prbreakfast_font_awesome', sfprbreakfast_url.'libs/font-awesome/font-awesome.min.css');
		//wp_enqueue_style('prbreakfast_font_awesome');
  }


  // Menüs hinzufügen
  function add_menu()
	{
		add_menu_page( __('Pink Ribbon','prbreakfast'), __('Pink Ribbon','prbreakfast'), 'manage_options', $this->slug, array(&$this, 'admin_page'), sfprbreakfast_url .'admin/images/favicon-16x16.png', '159.140');
	}

  /*
  * Admin Menü Page
  * aufgerufen von add_menu_page
  */
  function admin_page()
	{
		global $sfg_spiel;

		//handle updates
		if (isset($_POST['update_settings']))
    {

			if ( ! isset( $_POST['prb_nonce_check'] ) || ! wp_verify_nonce( $_POST['prb_nonce_check'], 'update_settings' )
			)
			{
			   print 'Sorry, your nonce did not verify.';
			   exit;
			}
      $this->update_settings();
    }

    ?>


		<div class="wrap <?php echo $this->slug; ?>-admin">


      <h2 class="nav-tab-wrapper"><?php $this->admin_tabs(); ?></h2>

			<div class="<?php echo $this->slug; ?>-admin-contain">

			  <?php
         $this->include_tab_content();
         ?>
				<div class="clear"></div>
			</div>
		</div>

	<?php
  }

  /*
  * Update Settings
  * aufgerufen in admin_page
  */
  function update_settings()
 	{

    foreach($_POST as $key => $value)
    {
       if ($key != 'submit')
      {
        $this->sfmadvent_set_option($key, $value);
      }
    }




     $this->options = get_option('sfmadvent_options');
     echo '<div class="updated"><p><strong>'.__('Einstellungen gespeichert.','prbreakfast').'</strong></p></div>';


   }

   /*
   * Einstellungen speichern
   * aufgerufen von update_settings
   * @param String $option key
   * @param String $newvalue value
   */
  function sfmadvent_set_option($option, $newvalue)
  {
  	$settings = get_option('sfmadvent_options');
  	$settings[$option] = $newvalue;
  	update_option('sfmadvent_options', $settings);
  }

  /*
  * Admin Tabs
  * aufgerufen in admin_page
  */
  function admin_tabs( $current = null ) {
      $tabs = $this->tabs;
      $links = array();
      if ( isset ( $_GET['tab'] ) ) {
        $current = $_GET['tab'];
      } else {
        $current = $this->default_tab;
      }

      foreach( $tabs as $tab => $name ) :

        if ( $tab == $current ) :
          $links[] = "<a class='nav-tab nav-tab-active' href='?page=".$this->slug."&tab=$tab'>$name </a>";
        else :
          $links[] = "<a class='nav-tab' href='?page=".$this->slug."&tab=$tab'>$name </a>";
        endif;

      endforeach;

      foreach ( $links as $link )
        echo $link;
  }

  /*
  * Tab Inhalt
  * aufgerufen in admin_page
  */
  function include_tab_content()
  {
   $screen = get_current_screen();

   if( strstr($screen->id, $this->slug ) )
   {
     if ( isset ( $_GET['tab'] ) )
     {
       $tab = $_GET['tab'];

     } else {

       $tab = $this->default_tab;
     }

     if(isset($this->tabs[$tab]))
     {
       require_once (sfmadvent_path.'admin/tabs/'.$tab.'.php');
     }else{
       echo "Wrong Tab";
     }
   }
 }

 /*
 * Admin init
 * aufgerufen vom Cunstutor
 */
 function admin_init()
 {

   $this->tabs = array(
     //'main' => __('Dashboard', 'prbreakfast'),
     //'addnewdonation' => __('Neue Spende eintragen', 'prbreakfast'),
     //'responsemail' => __('Bestätigungsmail', 'prbreakfast'),
     //'export' => __('Export', 'dsdfmembers'),
     //'specialrewards' => __('Special Rewards', 'investusers'),
     //'permalinks' => __('Permalinks','sfmusiker'),
     //'settings' => __('Settings','sfmusiker'),
   );

   $this->default_tab = 'main';
 }


}

$key = "sfmadmin";
$this->{$key} = new SFMAdmin();
