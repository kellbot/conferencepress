<?php
if ( ! function_exists('sponsor_post_type_setup') ) {

$event_name = "Summit";

// Register Custom Post Type
function sponsor_post_type_setup() {

	$labels = array(
		'name'                  => _x( "$event_name Sponsors", 'Post Type General Name', 'oshwa' ),
		'singular_name'         => _x( "$event_name Sponsor", 'Post Type Singular Name', 'oshwa' ),
		'menu_name'             => __( 'Summit Sponsors', 'oshwa' ),
		'name_admin_bar'        => __( 'Summit Sponsor', 'oshwa' ),
		'archives'              => __( 'Sponsor Archives', 'oshwa' ),
		'attributes'            => __( 'Sponsor Attributes', 'oshwa' ),
		'parent_item_colon'     => __( 'Parent Sponsor:', 'oshwa' ),
		'all_items'             => __( 'All Sponsors', 'oshwa' ),
		'add_new_item'          => __( 'Add New Sponsor', 'oshwa' ),
		'add_new'               => __( 'Add New', 'oshwa' ),
		'new_item'              => __( 'New Sponsor', 'oshwa' ),
		'edit_item'             => __( 'Edit Sponsor', 'oshwa' ),
		'update_item'           => __( 'Update Sponsor', 'oshwa' ),
		'view_item'             => __( 'View Sponsor', 'oshwa' ),
		'view_items'            => __( 'View Sponsor', 'oshwa' ),
		'search_items'          => __( 'Search Sponsor', 'oshwa' ),
		'not_found'             => __( 'Not found', 'oshwa' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'oshwa' ),
		'featured_image'        => __( 'Sponsor Logo', 'oshwa' ),
		'set_featured_image'    => __( 'Set Sponsor Logo', 'oshwa' ),
		'remove_featured_image' => __( 'Remove sponsor logo', 'oshwa' ),
		'use_featured_image'    => __( 'Use as sponsor logo', 'oshwa' ),
		'insert_into_item'      => __( 'Insert into sponsor', 'oshwa' ),
		'uploaded_to_this_item' => __( 'Uploaded to this sponsor', 'oshwa' ),
		'items_list'            => __( 'Sponsor list', 'oshwa' ),
		'items_list_navigation' => __( 'Sponsor list navigation', 'oshwa' ),
		'filter_items_list'     => __( 'Filter sponsors list', 'oshwa' ),
	);
	$rewrite = array(
		'slug'                  => 'sponsors',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Conference Sponsor', 'oshwa' ),
		'description'           => __( 'Sponsors of this Conference', 'oshwa' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'excerpt', 'thumbnail', ),
		'taxonomies'            => array( 'sponsorship_level' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-heart',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'conference_sponsor', $args );

}
add_action( 'init', 'sponsor_post_type_setup', 0 );

//Default size for sponsor logos is 300x300, no cropping.
add_image_size('sponsor_logo', 200, 200, false);

}

if ( ! function_exists( 'register_sponsorship_levels' ) ) {

// Register Custom Taxonomy
function register_sponsorship_levels() {

	$labels = array(
		'name'                       => _x( 'Sponsorship Levels', 'Taxonomy General Name', 'conferencepress' ),
		'singular_name'              => _x( 'Sponsorship Level', 'Taxonomy Singular Name', 'conferencepress' ),
		'menu_name'                  => __( 'Sponsorship Levels', 'conferencepress' ),
		'all_items'                  => __( 'All Levels', 'conferencepress' ),
		'parent_item'                => __( 'Parent Level', 'conferencepress' ),
		'parent_item_colon'          => __( 'Parent Level:', 'conferencepress' ),
		'new_item_name'              => __( 'New Level Name', 'conferencepress' ),
		'add_new_item'               => __( 'Add New Level', 'conferencepress' ),
		'edit_item'                  => __( 'Edit Level', 'conferencepress' ),
		'update_item'                => __( 'Update Level', 'conferencepress' ),
		'view_item'                  => __( 'View Level', 'conferencepress' ),
		'separate_items_with_commas' => __( 'Separate levels with commas', 'conferencepress' ),
		'add_or_remove_items'        => __( 'Add or remove levels', 'conferencepress' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'conferencepress' ),
		'popular_items'              => __( 'Popular Levels', 'conferencepress' ),
		'search_items'               => __( 'Search Levels', 'conferencepress' ),
		'not_found'                  => __( 'Not Found', 'conferencepress' ),
		'no_terms'                   => __( 'No levels', 'conferencepress' ),
		'items_list'                 => __( 'Level list', 'conferencepress' ),
		'items_list_navigation'      => __( 'Level list navigation', 'conferencepress' ),
	);
	$rewrite = array(
		'slug'                       => 'level',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'sponsorship_level', array( 'conference_sponsor' ), $args );

}
add_action( 'init', 'register_sponsorship_levels', 0 );

}

class Sponsor_Widget extends WP_Widget {

	public function __construct() {

		parent::__construct(
			'sponsor-logos',
			__( 'Sponsor Logos', 'conferencepress' ),
			array(
				'description' => __( 'Display sponsor logos', 'conferencepress' ),
				'classname'   => 'sponsor-logos',
			)
		);

	}

	public function widget( $args, $instance ) {

		echo "<h2>Sponsors</h2>";

		$levels = get_terms(array(
			'taxonomy' => 'sponsorship_level',
			'orderby' => 'slug',
			));

		foreach ($levels as $level) {

			$sponsors = new WP_Query(array(
				'post_type' => 'conference_sponsor',
				'tax_query' => array(
					array(
						'taxonomy' => 'sponsorship_level',
						'field' => 'slug',
						'terms' => $level->slug,
						),
					),
				));


			if($sponsors->have_posts())
				echo "<h3>$level->name</h3>";
			while ($sponsors->have_posts()) {
				$sponsors->the_post();

				echo '<figure class="aligncenter" style="text-align: center">';
				the_post_thumbnail('sponsor_logo');
				echo '</figure>';
			}

			wp_reset_postdata();
		}
	}

	public function form( $instance ) {

		// Set default values
		$instance = wp_parse_args( (array) $instance, array( 
			'cp_sponsor_widget_sponsor_level' => '',
		) );

		// Retrieve an existing value from the database
		$cp_sponsor_widget_sponsor_level = !empty( $instance['cp_sponsor_widget_sponsor_level'] ) ? $instance['cp_sponsor_widget_sponsor_level'] : '';

		$levels = get_terms('sponsorship_level');

		// Form fields
		echo '<p>';
		echo '	<label for="' . $this->get_field_id( 'cp_sponsor_widget_sponsor_level' ) . '" class="cp_sponsor_widget_sponsor_level_label">' . __( 'Sponsorship Level', 'conferencepress' ) . '</label>';
		echo '	<select id="' . $this->get_field_id( 'cp_sponsor_widget_sponsor_level' ) . '" name="' . $this->get_field_name( 'cp_sponsor_widget_sponsor_level' ) . '" class="widefat">';
		foreach ($levels as $level):
			echo '		<option value="'.$level->slug.'" ' . selected( $cp_sponsor_widget_sponsor_level, $level->slug, false ) . '> ' . __( $level->name, 'conferencepress' ) . '</option>';
		endforeach;
		echo '	</select>';
		echo '</p>';

	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['cp_sponsor_widget_sponsor_level'] = !empty( $new_instance['cp_sponsor_widget_sponsor_level'] ) ? strip_tags( $new_instance['cp_sponsor_widget_sponsor_level'] ) : '';

		return $instance;
	}

}

function cp_sponsor_widgetregister_widgets() {
	register_widget( 'Sponsor_Widget' );
}
add_action( 'widgets_init', 'cp_sponsor_widgetregister_widgets' );
