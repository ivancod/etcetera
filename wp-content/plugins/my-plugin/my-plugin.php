<?php
/**
 * Plugin Name: My plugin 
 * Description: Плагин для тестового задания Etcetera
 * Plugin URI:  vanstep17@gmail.com
 * Author URI:  vanstep17@gmail.com
 * Author:      Ivan Step
 * Version:     1.0
 *
 */

include plugin_dir_path( __FILE__ ) . '/widget/index.php';


add_action( 'wp_enqueue_scripts', 'my_plugin_scripts' );

function my_plugin_scripts() {
	wp_enqueue_style( 'style-my_plugin', '/'.PLUGINDIR.'/'.dirname( plugin_basename( __FILE__ ) ). '/assets/style.css' );
	wp_enqueue_script( 'script-my_plugin', '/'.PLUGINDIR.'/'.dirname( plugin_basename( __FILE__ ) ). '/assets/script.js', array(), '1.0.0', true );
}

function my_plugin_create_objects_posttype() {
    register_post_type( 'objects',
        array(
            'labels' => array(
	            'name' => __( 'Объект недвижимости' ),
	            'singular_name' => __( 'Объект' )
	        ),
	        'public' 		=> true,
	        'has_archive' 	=> true,
	        'rewrite' 		=> array('slug' => 'objects'),
	        'taxonomies' 	=> array( 'Район' ),
        	'supports' => array('title', 'editor', 'thumbnail' ),
    	)
    );

    my_plugin_set_field();
}

add_action( 'init', 'my_plugin_create_objects_posttype' );

add_action( 'wp_ajax_nopriv_mp_acf_filter', 'mp_acf_filter' );
add_action( 'wp_ajax_mp_acf_filter', 'mp_acf_filter' );

function my_plugin_shortcode( $atts ){
	if( is_admin() ) return;

	load_template(dirname( __FILE__ ) . '/front-template.php');
}

function mp_acf_filter(){

	$meta_query = [];

	foreach($_POST['data'] as $key => $field){
		if($field['val'] == '' OR $field['val'] == '0' OR $field['val'] == []){
			continue;
		}

		if($field['type'] == 'text') {
 			$meta_query[] = [	
 				'key'		=> $field['name'],
				'value'		=> $field['val'],
				'compare'	=> 'LIKE'
			];
		}

		if($field['type'] == 'radio') {
			$meta_query[] = [	
 				'key'		=> $field['name'],
				'value'		=> $field['val'],
				'compare'	=> '='
			];
		}

		if($field['type'] == 'select') {
			if($field['multiple']) {
				$meta_query[] = [	
	 				'key'		=> $field['name'],
					'value'		=> $field['val'],
					'compare'	=> 'IN'
				];
			} else {
				$meta_query[] = [	
	 				'key'		=> $field['name'],
					'value'		=> $field['val'],
					'compare'	=> '='
				];
			}
		}

		if($field['type'] == 'checkbox') {
			$meta_query[] = [	
 				'key'		=> $field['name'],
				'value'		=> $field['val'],
				'compare'	=> 'IN'
			];
		}
	}

	$meta_query['relation']	= 'AND';

	$the_query  =  new WP_Query(
		array(
			'post_type'		=> 'objects',
			'posts_per_page' => '5',
			'paged' => $_POST['page'] ? $_POST['page'] : 1,
			'meta_query'	=> $meta_query
		)
	);

	$posts = [ 'list' => [] ];
	while ( $the_query->have_posts() ) : $the_query->the_post(); 
		$posts['list'][] = [
			'link' 		=> get_permalink(),
			'thumbnail' => get_the_post_thumbnail(),
			'title' 	=> get_the_title(),
			'content' 	=> wp_trim_words( get_the_content(), 30, '...' )
		];	
	endwhile;

	$posts['total_posts'] = $the_query->found_posts;

	echo json_encode($posts);
	wp_die(); 
}

function my_plugin_set_field(){
	$result = [];

	foreach( my_plugin_meta_list('acf-field') as $acf ) {
		global $wpdb;
		$field = get_field_object( $acf ) ;

		if($field['parent']) {
			$sql = "SELECT post_excerpt FROM {$wpdb->posts} WHERE ID = {$field['parent']} AND post_type = 'acf-field' ";
			if( $wpdb->get_results( $sql ) ) continue; 
		}

		$result[] = $field;
	}

	$_SERVER['acf-field'] = $result;
}

function my_plugin_meta_list($type = ''){
 	global $wpdb;

 	$sql = "SELECT post_name FROM {$wpdb->posts} WHERE post_type = '$type' ORDER BY menu_order ASC";
 	$result = [];
    foreach ($wpdb->get_results( $sql ) as $v) {
    	$result[] = $v->post_name;
    }

    return $result;
}

function my_plugin_create_field($field){
	if(!$field) return;

	if($field['type'] == 'text') {
		echo 	"<div class='acf_field'>
					 <label class='mp_label_field'><p>{$field['label']}</p>
						<input class='form-control' type='text' key='{$field['key']}' name='{$field['name']}'> 
					 </label>
				 </div>";
	}

	if($field['type'] == 'radio') {
		echo 	"<div class='mp_wrap_field acf_field'><p>{$field['label']}</p>";

		foreach($field['choices'] as $choice){
		echo 	"<label class='mp_label_field '>
					<input type='radio' key='{$field['key']}' name='{$field['name']}' value='$choice'> $choice
				 </label><br>";
		}

		echo 	"</div>";

	}

	if($field['type'] == 'select') {
		echo 	"<div class='mp_wrap_field acf_field'><p>{$field['label']}</p>
				 <select class='custom-select' type='select' name='{$field['name']}' key='{$field['key']}'>
				 	<option value='0'>-</option>";
		foreach($field['choices'] as $choice){
			echo "<option value='$choice'>$choice</option>";
		}

		echo 	"</select></div>";
	}

	if($field['type'] == 'checkbox') {
		//--
	}

    return $result;
}

add_shortcode( 'my_plugin', 'my_plugin_shortcode' ); // [my_plugin] 


