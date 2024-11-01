<?php
/*
Plugin Name: WPYog Documents
Description: WPYog Documents.
Author: WPYog
Author URI: http://wpyog.com/
Version: 1.3.3
License:           	GPLv2 or later
License URI: 		http://www.gnu.org/licenses/gpl-2.0.html
*/
if(!defined('WPYOG_RESEARCH_PLUGIN_DIR'))
	define( 'WPYOG_RESEARCH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if(!defined('WPYOG_RESEARCH_PLUGIN_URL'))
	define( 'WPYOG_RESEARCH_PLUGIN_URL', plugin_dir_url(__FILE__) );


add_action('init', 'wpyog_research_education',1);
function wpyog_research_education() {	
	
	$document_labels = array(
		'name'                  => __('WPYog Document'),
		'singular_name'         => __('wpyog_document'),
		'add_new'               => __('Add Document'),
		'add_new_item'          => __('Add New Document'),
		'edit_item'             => __('Edit Document'),
		'new_item'              => __('New Document'),
		'view_item'             => __('View Document'),
		'search_items'          => __('Search  Document'),
		'not_found'             =>  __('No Document found'),
		'not_found_in_trash'    => __('No Document found in Trash'),
		'parent_item_colon'     => '',
		'menu_name'             => __( 'WPYog Documents')
	);
	
	$document_args = array(
		'labels'              => $document_labels,
		'public'              => true,
		'publicly_queryable'  => true,
    	'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true, 
		'query_var'           => true,
		'rewrite'             => array( 
									'slug'       => 'wpyog_document',
									'with_front' => false
								),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => 5,
		'menu_icon'   		  => 'dashicons-wpyog-icon',
		'supports'            => array('title','editor','thumbnail', 'author'),
		'show_in_rest'		  => true,
		'taxonomies' => ['wpyog_document_category'],
	);
    
	register_post_type( 'wpyog_document', $document_args );
	
	register_taxonomy('wpyog_document_category', ['wpyog_document'], [
		'label' => __('Category', 'txtdomain'),
		'rewrite' => ['slug' => 'wpyog_document-category'],
		 'hierarchical' => true,
   		 'show_ui' => true,
    	'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
		'labels' => [
			'singular_name' => __('Category', 'txtdomain'),
			'all_items' => __('All Category', 'txtdomain'),
			'edit_item' => __('Edit Category', 'txtdomain'),
			'view_item' => __('View Category', 'txtdomain'),
			'update_item' => __('Update Category', 'txtdomain'),
			'add_new_item' => __('Add New Category', 'txtdomain'),
			'new_item_name' => __('New Category Name', 'txtdomain'),
			'search_items' => __('Search Category', 'txtdomain'),
			'popular_items' => __('Popular Category', 'txtdomain'),
			'separate_items_with_commas' => __('Separate Category with comma', 'txtdomain'),
			'choose_from_most_used' => __('Choose from most used Category', 'txtdomain'),
			'not_found' => __('No Category found', 'txtdomain'),
		]
	]);
	register_taxonomy_for_object_type('wpyog_document_category', 'wpyog_document');
}
add_action('admin_menu', 'books_register_ref_page',1);
function books_register_ref_page() {
    add_submenu_page(
        'edit.php?post_type=wpyog_document',
        __( 'Shortcode Reference', 'textdomain' ),
        __( 'Shortcode Reference', 'textdomain' ),
        'manage_options',
        'document-shortcode-ref',
        'document_ref_page_callback'
    );
}

function document_ref_page_callback() { 
	?>
	<div class="wrap">
	<hr class="wp-header-end">
	<div class="wpyog-dashboard"style="">
		<img src="<?php echo WPYOG_RESEARCH_PLUGIN_URL;?>img/wpyog-doc-icon.png" width="140" class="wpyog-image-circle"/>
		<h2>WPYog Document</h2>
		<p>Shortcode for all document [wpyog-document-list category=7 desc=1 date=1 limit=2 orderby=date order=DESC download=1]</p>
		<ul style="text-align:left;color: #fff;">
			<li><strong>desc</strong> attribute to display description. 1 for show and 0 for hide</li>
			<li><strong>date</strong> attribute to display date. 1 for show and 0 for hide</li>
			<li><strong>download</strong> attribute to allow download file. 1 for show and 0 for hide</li>
		</ul>
		<div style="display:inline-block; margin: 0px auto;text-align: center;width:100%;">
			<a href="<?php echo admin_url('edit.php?post_type=wpyog_document'); ?>" class="wpyog_doc_btn">All Documents</a>
		</div>
	</div>
</div>
<?php }


add_action( 'admin_enqueue_scripts', 'wpyog_document_admin_script' );
function wpyog_document_admin_script(){
	global $post;
	wp_register_style( 'wpyog_document_admin_css', plugin_dir_url( __FILE__ ). 'css/wpyog-document.css', false, '1.0.0' );
	wp_enqueue_style( 'wpyog_document_admin_css' );
	
	wp_register_script( 'wpyog_document_admin_document_js', plugin_dir_url( __FILE__ ). 'js/document-js.js', false, '1.0.0' );
	wp_enqueue_script( 'wpyog_document_admin_document_js' );
	
	wp_enqueue_script('media-upload');
	
	if(is_object($post) ){
		wp_enqueue_media(array('post' => $post->ID));
	}else{
		wp_enqueue_media();
	}
}
add_action( 'add_meta_boxes', 'wpyog_document_meta_box' );
function wpyog_document_meta_box(){
	add_meta_box( 'wpyog_additional_attribute', 'Document Media', 'wpyog_additional_attribute', 'wpyog_document');
}
function wpyog_additional_attribute($post){
	$document_link = get_post_meta( $post->ID, 'document_link', true );
	
	if(!empty($document_link)) { ?>
		<div class="post-option">
			<label class="post-option-label">Upload Document (required)</label>
			<div class="post-option-value">
				<a href="<?php echo $document_link;?>" target="__blank"><?php echo $document_link;?></a></span>
				<a href="javascript:void(0);" class="button btn-danger" id="removeDoc">Remove</a>
			</div>
		</div>
	<?php } ?>
	
	<div class="post-option" id="uploadDoc" style="display:<?php echo (!empty($document_link))?'none':'block';?>">
		<label class="post-option-label">Upload Document (required)</label>
		<div class="post-option-value">
			<input id="upload-document" type="button" class="button" value="Upload Document" />
			<span id="showLink"></span>
			<input type="hidden" name="document_link" class="large-text required" id="document_link" value="<?php echo isset($document_link) ? $document_link : ''; ?>"/>
			<label class="error" id="fileError"></label>
		</div>					
	</div>
<?php }

add_action( 'save_post', 'save_wpyog_document_meta_data' , 1,2);
function save_wpyog_document_meta_data($post_id , $post ) {
	if($post->post_type == 'wpyog_document') {
		$document_link = !empty($_POST['document_link']) ? $_POST['document_link'] : '';
		update_post_meta($post_id, 'document_link', $document_link);
	}
}

add_filter( "manage_wpyog_document_posts_columns", function ( $defaults ) {
	$defaults['shortcode'] = 'Shortcode';
	return $defaults;
} );
// Handle the value for each of the new columns.

add_action( "manage_wpyog_document_posts_custom_column", function ( $column_name, $post_id ) {
	if ( $column_name == 'shortcode' ) {
		echo '[wpyog-document id='. $post_id .']';
	}
}, 10, 2 );

add_shortcode('wpyog-document-list', 'wpyog_research_document_list' );
function wpyog_research_document_list($atts, $content=null){
	global $content, $wpdb;
    ob_start();
	extract(shortcode_atts(array(
		'searchOption' => 'top',
		'category'=>'',
		'desc'=>0,
		'date'=>0,
		'orderby' => 'date',
		'order'   => 'DESC',
		'limit'   => -1,
		'download' => 0
	), $atts));
	$cat 				= ! empty( $category ) 				? explode(',', $category) 		: '';
	$args = array ( 
		'post_type'			=> 'wpyog_document',
		'post_status'		=> 'publish',
		'posts_per_page'	=> $limit,
        'orderby' => $orderby,
		'order'   => $order,
	);
	if( $cat != "" ) {
		$args['tax_query'] = array(
			array(
				'taxonomy'  => 'wpyog_document_category',
				'field'     => 'term_id',
				'terms'     => $cat
			)
		);
	}
	$query 		= new WP_Query( $args );
	$includeFile = plugin_dir_path( __FILE__ ).'templates/research-document-list.php';
	include( $includeFile );
	$output = ob_get_clean();
	$output = wpautop(trim($output));
    return $output;
}

function wpyog_fileExtention($ext){
	switch($ext){
		case 'doc':
		case 'docx':
		    $ext = "fa-file-word-o";
		break;
		case 'pdf':
		    $ext = "fa-file-pdf-o";
		break;
		case 'txt':
		    $ext = "fa-file-text-o";
		break;
		case 'zip':
		case 'rar':
		    $ext = "fa-file-zip-o";
		break;
		case 'ppt':
		case 'pptx':
		    $ext = "fa-file-powerpoint-o";
		break;
		case 'xls':
		case 'csv':
		case 'xlsx':
		    $ext = "fa-file-excel-o";
		break;
		case 'png':
		case 'jpg':
		case 'jpeg':
		case 'gif':
		    $ext = "fa-file-image-o";
		break;
		case 'com':
		    $ext = "fa-globe";
		break;
		default:
			$ext = "fa-file-o";
	}
	return $ext;
}   
if ( ! function_exists( 'wpyog_front_scripts' ) ) {
	function wpyog_front_scripts(){	
		wp_register_style( 'wpyog_font_front_css', plugin_dir_url( __FILE__ ). 'css/font-awesome.min.css', false, '1.0.0' );
		wp_enqueue_style( 'wpyog_font_front_css' );
		wp_register_style( 'wpyog_document_front_css', plugin_dir_url( __FILE__ ). 'css/wpyog_document.min.css', false, '1.0.0' );
		wp_enqueue_style( 'wpyog_document_front_css' );
	} 
}
add_action('wp_head', 'wpyog_front_scripts');

add_filter('widget_text','do_shortcode');

add_shortcode('wpyog-document','wpyog_get_wpyog_document');
function wpyog_get_wpyog_document($atts = array()){
	ob_start();
	global $content, $wpdb;
	$document_id = [];
	if (!empty($atts['id'])){
		$document_id = explode(',', $atts['id']);
	}
	
	$args = array ( 
		'post_type'			=> 'wpyog_document',
		'post_status'		=> 'publish',
		'posts_per_page'	=> -1,
        'order' 			=> 'DESC',
	);
	if ( !empty($document_id) ) {
		$args = array_merge($args,array('post__in' => $document_id));
	}
	$query 		= new WP_Query( $args );
	
	if ( $query->have_posts() ) { while ( $query->have_posts() ) : $query->the_post();
		$post_id = get_the_ID();
		$document_link = get_post_meta( $post_id, 'document_link', true );
		$ext = pathinfo($document_link, PATHINFO_EXTENSION);
		$iconClass = wpyog_fileExtention($ext);
	?>
	<div class="wpyog-doc-box">
		<div class="wpyog-doc-box-title"><i class="single_doc fa <?php echo $iconClass;?>"></i> <a href="<?php echo $document_link;?>" target="_blank"><?php echo get_the_title(); ?></a></div>					
		<div class="wpyog-doc-box-content">	
			<?php the_content(); ?>
		</div>
	</div>
<?php endwhile; } else { ?>
	<p>[wpyog-document id=<?php echo implode(',',$document_id);?>]</p>
<?php }
	//echo "<pre>"; print_r($documentRows); exit;
	$output = ob_get_clean();
	$output = wpautop(trim($output));
    return $output;
}

if (isset($_REQUEST['download_url']) && !empty($_REQUEST['download_url'])) {
    $downloadUrl = $_REQUEST['download_url'];
	$post_id = base64_decode( urldecode( $downloadUrl));
	$document_link = get_post_meta( $post_id, 'document_link', true );
	if( strpos( $document_link, "/wp-content/uploads/" ) !== false ){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($document_link).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($document_link));
		flush(); // Flush system output buffer
		readfile($document_link);
		die();
	}
}

add_action( 'upgrader_process_complete', 'wpyog_plugin_upgrade_completed', 10, 2 );

function wpyog_plugin_upgrade_completed($upgrader_object, $options ) {
	global $wpdb;
	$our_plugin = plugin_basename( __FILE__ );
	// If an update has taken place and the updated type is plugins and the plugins element exists
	if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
		foreach( $options['plugins'] as $plugin ) {
			if( $plugin == $our_plugin ) {
				// Set a transient to record that our plugin has just been updated
				$table_name      = $wpdb->prefix . "wpyog_documents";
				if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
					$sql = "SELECT * from $table_name";
					$rows = $wpdb->get_results($sql, OBJECT);
					if (!empty($rows)) {
						foreach ($rows as $row) {
							$new_post = array(
								'post_title' => $row->title,
								'post_type' => 'wpyog_document',
								'post_content' => !empty($row->description) ? $row->description : $row->title ,
								'post_status' => 'publish',
								'post_date' => date('Y-m-d H:i:s',strtotime($row->created))
							);
							$document_link = $row->document_link;
							$post_id = wp_insert_post( $new_post );
							update_post_meta($post_id, 'document_link', $document_link);
						}
						$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpyog_documents" );
					}
				}
				set_transient( 'wp_upe_updated', 1 );
			}
		}
	}
}


/**
 * Show a notice to anyone who has just updated this plugin
 * This notice shouldn't display to anyone who has just installed the plugin for the first time
 */
function wpyog_upe_display_update_notice() {
	// Check the transient to see if we've just updated the plugin
	if( get_transient( 'wp_upe_updated' ) ) {
		echo '<div class="notice notice-success">' . __( 'Thanks for updating', 'wp-upe' ) . '</div>';
		delete_transient( 'wp_upe_updated' );
	}
}
add_action( 'admin_notices', 'wpyog_upe_display_update_notice' );

/**
 * Show a notice to anyone who has just installed the plugin for the first time
 * This notice shouldn't display to anyone who has just updated this plugin
 */
function wpyog_upe_display_install_notice() {
	// Check the transient to see if we've just activated the plugin
	if( get_transient( 'wp_upe_activated' ) ) {
		echo '<div class="notice notice-success">' . __( 'Thanks for installing', 'wp-upe' ) . '</div>';
		// Delete the transient so we don't keep displaying the activation message
		delete_transient( 'wp_upe_activated' );
	}
}
add_action( 'admin_notices', 'wpyog_upe_display_install_notice' );

/**
 * Run this on activation
 * Set a transient so that we know we've just activated the plugin
 */
function wpyog_upe_activate() {
	set_transient( 'wp_upe_activated', 1 );
}
register_activation_hook( __FILE__, 'wpyog_upe_activate' );


add_action('restrict_manage_posts', 'axxiem_filter_post_type_by_taxonomy');
function axxiem_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'wpyog_document'; // change to your post type
	$taxonomy  = 'wpyog_document_category'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => sprintf( __( 'Show all %s', 'textdomain' ), $info_taxonomy->label ),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}

/**
 * Filter posts by taxonomy in admin
 * @author  WPYog
 * 
 */
add_filter('parse_query', 'axxiem_convert_id_to_term_in_query');
function axxiem_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'wpyog_document'; // change to your post type
	$taxonomy  = 'wpyog_document_category'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

add_action('init', 'enable_revisions');
function enable_revisions() {
    add_post_type_support('wpyog_document', 'revisions');
}
add_action('save_post', 'create_custom_post_type_revision');
function create_custom_post_type_revision($post_id) {
    $post_type = get_post_type($post_id);
    if ($post_type !== 'wpyog_document' || wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
        return;
    }
    wp_save_post_revision($post_id);
}