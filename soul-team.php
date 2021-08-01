<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              soulteam.com
 * @since             1.0.0
 * @package           Soul_Team
 *
 * @wordpress-plugin
 * Plugin Name:       Soul Team
 * Plugin URI:        soulteam.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Soul Team
 * Author URI:        soulteam.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       soul-team
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SOUL_TEAM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-soul-team-activator.php
 */
function activate_soul_team() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-soul-team-activator.php';
	Soul_Team_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-soul-team-deactivator.php
 */
function deactivate_soul_team() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-soul-team-deactivator.php';
	Soul_Team_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_soul_team' );
register_deactivation_hook( __FILE__, 'deactivate_soul_team' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-soul-team.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_soul_team() {

	$plugin = new Soul_Team();
	$plugin->run();

}
run_soul_team();

add_action( 'init', 'create_team_review' );

function create_team_review() {
    register_post_type( 'team_reviews',
        array(
            'labels' => array(
                'name' => 'Team',
                'singular_name' => 'Team',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Team',
                'edit' => 'Edit',
                'edit_item' => 'Edit Team',
                'new_item' => 'New Team',
                'view' => 'View',
                'view_item' => 'View Team',
                'search_items' => 'Search Team',
                'not_found' => 'No Team found',
                'not_found_in_trash' => 'No Team found in Trash',
                'parent' => 'Parent Team'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),
            'taxonomies' => array( '' ),
            'has_archive' => true
        )
    );
}

add_action( 'admin_init', 'my_admin' );

function my_admin() {
    add_meta_box( 'team_review_meta_box',
        'Team Details',
        'display_team_review_meta_box',
        'team_reviews', 'normal', 'high'
    );
}

function display_team_review_meta_box( $team_review ) {
    // Retrieve current name of the Director and team Rating based on ID
    $player_name = get_post_meta( $team_review->ID, 'player_name', true );
    // $player_name = json_decode($player_name);
    // $gender = get_post_meta( $team_review->ID, 'gender', true );
    $birthdate = get_post_meta( $team_review->ID, 'birthdate', true );
    $age = get_post_meta( $team_review->ID, 'age', true );
    $bio = get_post_meta( $team_review->ID, 'bio', true );
    if(!empty($player_name) AND count($player_name) > 0)
    {
    for($i=0;$i<count($player_name);$i++)
    {
    ?>
    <table>
        <tr>
            <td style="width: 100%">Player Name</td>
            <td><input type="text" size="80" name="player_name[]" value="<?=$player_name[$i]?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Birthdate</td>
            <td><input type="text" size="80" class="datepicker" name="birthdate[]"  value="<?=date('d-m-Y',strtotime($birthdate[$i]))?>" onchange="changedate(this.value)" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Age</td>
            <td><input type="text" size="80" id="age" name="age[]" value="<?=$age[$i]?>"/></td>
        </tr>
        <tr>
            <td style="width: 100%">BIO</td>
            <td><textarea name="bio[]" cols="80" rows="10"><?=$bio[$i]?></textarea></td>
        </tr>
    </table>
    <hr>
	<?php } }else{?>
		<table>
	        <tr>
	            <td style="width: 100%">Player Name</td>
	            <td><input type="text" size="80" name="player_name[]" /></td>
	        </tr>
	        <tr>
	            <td style="width: 100%">Birthdate</td>
	            <td><input type="text" class="datepicker" name="birthdate[]" onchange="changedate(this.value)" ></td>
	        </tr>
	        <tr>
	            <td style="width: 100%">Age</td>
	            <td><input type="text" id="age" size="80" name="age[]" /></td>
	        </tr>
	        <tr>
	            <td style="width: 100%">BIO</td>
	            <td><textarea name="bio[]" cols="80" rows="10"></textarea></td>
	        </tr>
	    </table>
	<?php } ?>
    	<div class="container1"></div>
          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <div class="container1">
	    
	    <div><input type="text" name="mytext[]"></div>
	</div> -->
	<button class="add_form_field">Add New Team Member &nbsp; 
      <span style="font-size:16px; font-weight:bold;">+ </span>
    </button>

	<script type="text/javascript">
        $(document).ready(function() {
            $( ".datepicker" ).datepicker();
		    var max_fields = 10;
		    var wrapper = $(".container1");
		    var add_button = $(".add_form_field");

		    var x = 1;
		    $(add_button).click(function(e) {
		        e.preventDefault();
		        if (x < max_fields) {
		            x++;
		            $(wrapper).append('<table> <tr> <td style="width: 100%">Player Name</td> <td><input type="text" size="80" name="player_name[]" /></td> </tr> <tr> <td style="width: 100%">Birthdate</td> <td><input type="text" class="datepicker" size="80" name="birthdate[]" onchange="changedate(this.value)" /></td> </tr> <tr> <td style="width: 100%">Age</td> <td><input type="text" id="age" size="80" name="age[]" /></td> </tr> <tr> <td style="width: 100%">BIO</td> <td><textarea name="bio[]" cols="80" rows="10"></textarea></td> </tr> </table><a href="#" class="delete">Delete</a><hr>'); //add input box
		        } else {
		            alert('You Reached the limits')
		        }
		    });

		    $(wrapper).on("click", ".delete", function(e) {
		        e.preventDefault();
		        $(this).parent('div').remove();
		        x--;
		    })

		});
        $(document).on('focus',".datepicker", function(){
            $(this).datepicker();
        });

        function changedate(val){
            dob = new Date(val);
            var today = new Date();
            var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
            $('#age').val(age);        
        }
	</script>
    <?php
}

add_action( 'save_post', 'add_team_review_fields', 10, 2 );

function add_team_review_fields( $team_review_id, $team_review ) {
    // Check post type for team
    if ( $team_review->post_type == 'team_reviews' ) {
    	// Store data in post meta table if present in post data
        if ( isset( $_POST['player_name'] ) && $_POST['player_name'] != '' ) {
        		update_post_meta( $team_review_id, 'player_name', $_POST['player_name'] );
        	// for($i=0;$i<count($_POST['player_name']);$i++)
        	// {
        	// }
        }
        // if ( isset( $_POST['gender'] ) && $_POST['gender'] != '' ) {
        //     	update_post_meta( $team_review_id, 'gender', $_POST['gender'] );
        //  //    for($i=0;$i<count($_POST['gender']);$i++)
        // 	// {
        // 	// }
        // }
        if ( isset( $_POST['birthdate'] ) && $_POST['birthdate'] != '' ) {
            	update_post_meta( $team_review_id, 'birthdate', $_POST['birthdate'] );
         //    for($i=0;$i<count($_POST['birthdate']);$i++)
        	// {
        	// }
        }
        if ( isset( $_POST['age'] ) && $_POST['age'] != '' ) {
            	update_post_meta( $team_review_id, 'age', $_POST['age'] );
         //    for($i=0;$i<count($_POST['age']);$i++)
        	// {
        	// }
        }
        if ( isset( $_POST['bio'] ) && $_POST['bio'] != '' ) {
            	update_post_meta( $team_review_id, 'bio', $_POST['bio'] );
         //    for($i=0;$i<count($_POST['bio']);$i++)
        	// {
        	// }
        }
    }
}



// add_shortcode( 'Display', 'team_list_shortcode_func' );
// function team_list_shortcode_func($atts){
	
// 	global $wp_query,
//         $post;
	
// 	 $atts = shortcode_atts( array(
//         'team' => ''
//     ), $atts );
	
// 	$args = array(
// 		'post_type'         => 'team_reviews',
// 		'posts_per_page'    => -1,
// 		'post_status' => 'publish',
// 		'orderby'           => 'menu_order',
//         'order'             => 'ASC',
//         'post_title'         => $atts['team'],
// 	);

// 	$teamvar = '';
// 	$query = new WP_Query( $args );
// 	if( $query->have_posts() ){
// 		$teamvar .= '<ul>';
// 		while( $query->have_posts() ){
// 			$query->the_post();
// 			$teamvar .= '<li>' . get_the_title() . '</li>';
// 		}
// 		$teamvar .= '</ul>';
// 	}
// 	wp_reset_postdata();
// 	return $teamvar;
// }


add_shortcode( 'Display', 'rmcc_post_listing_shortcode1' );
function rmcc_post_listing_shortcode1( $atts ) {
    global $wpdb;

    ob_start();
    
    if(isset($atts['team']) && $atts['team'] != "")
    {
      $options = array(
        'post_type' => 'team_reviews',
        'post_status' => array('publish'),
        'posts_per_page' => -1,
        'post__in' => explode( ',', $atts['team']),
      );
      
    }
    else
    {
    // define query parameters based on attributes
    $options = array(
        'post_type' => 'team_reviews',
        'post_status' => array('publish'),
        'posts_per_page' => -1,
    );
    }
    $query = new WP_Query( $options );
    
    if ( $query->have_posts() ) { ?>
            

<style>
html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  /*width: 33.3%;*/
  margin-bottom: 16px;
  padding: 0 8px;
}

@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}
</style>
</head>
<body>

<h2>Soul Team</h2>
<br>

<div class="row">
    <?php while ( $query->have_posts() ) : $query->the_post(); 
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'large'); ?>            
              <div class="column">
                <div class="card">
                  <img src="<?=$featured_img_url?>" alt="<?=get_the_title()?>" style="width:100%">
                  <div class="container">
                    <h2><?=get_the_title()?></h2>
                    <p><?=get_the_excerpt()?></p>
                    <?php 
                        echo '<table>';
                        $post_id = get_the_ID();
                        $result = $wpdb->get_results("SELECT meta_value FROM  $wpdb->postmeta WHERE post_id = $post_id AND meta_key IN ('player_name','birthdate','age','bio')");
                        $player_name = unserialize($result[0]->meta_value);
                        $birthdate = unserialize($result[1]->meta_value);
                        $age = unserialize($result[2]->meta_value);
                        $bio = unserialize($result[3]->meta_value);

                        $teamdetail = array_merge_recursive($player_name, $birthdate,$age,$bio);
                        $i=1;
                        echo '<tr>';
                        foreach ( $teamdetail as $cp )
                        {
                            echo '<td>'.$cp.'</td>';
                            if($i%2==0)
                            {
                                echo '</tr>';
                            }
                            // echo '</tr>';
                        $i++; }
                        echo '</table>';
                    ?>                    
                  </div>
                </div>
              </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
  
</div>




    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}