<?php
/**
* Plugin Name: Pneus
* Description: A brief description of the Plugin
* Version: 1.3
* Author: Denis Boucher
* Text Domain: pneus
* Domain Path: /languages/
*/
 
 class Pneus_Plugin
 {
    public function __construct(){
        include_once plugin_dir_path( __FILE__ ).'/inventaire.php';
        new Inventaire();
        
        register_activation_hook(__FILE__, array('Inventaire', 'install'));
        register_uninstall_hook(__FILE__, array('Inventaire', 'uninstall'));
        add_action( 'init', array($this, 'wpm_custom_post_type'), 0 );
        add_action( 'init', array($this, 'wpm_add_taxonomies'), 0 );
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        wp_register_style( 'pneus', plugins_url( 'pneus/mon.css' ) );
        wp_register_style('bootstrap', 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
        wp_enqueue_style( 'pneus' );
        load_plugin_textdomain( 'pneus', false, basename( dirname( __FILE__ ) ) . '/languages' );
        //wp_enqueue_style( 'bootstrap' );
    }
    
    public function add_admin_menu()
    {
        // 'toplevel_page_pneus'
        add_menu_page( __( 'Tire Inventory','pneus'), 'Pneu plugin', 'manage_options', 'pneus', array($this, 'menu_html'));
    }
    
    public function menu_html()
    {
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <p><?php _e( 'Welcome to the plugin home page','pneus' ); ?></p>
        <br />
        <p><?php _e( 'This plugin adds an "inventory" table.','pneus' ); ?><br />
        <?php _e( 'She then adds the fields "mark" and "model".','pneus' ); ?><br />
        <?php _e( 'Subsequently, you will be able to add data to this table, then allow a search.','pneus' ); ?></p>
        <?php
    }
    
    public function wpm_custom_post_type()
    {
        // On rentre les différentes dénominations de notre custom post type qui seront affichées dans l'administration
        $labels = array(
		  'name'                => _x('Automobiles', 'Post Type General Name','pneus'),
		  'singular_name'       => _x('Car', 'Post Type Singular Name','pneus'),
		  'menu_name'           => __('Cars','pneus'),
          'name_admin_bar'      => __('Cars','pneus'),
          'parent_item_colon'   => __('Parent Item:','pneus'),
		  'all_items'           => __('All cars','pneus'),
          'add_new_item'        => __('Add a new car','pneus'),
          'add_new'             => __('Add','pneus'),
          'new_item'            => __( 'New car','pneus'),
          'edit_item'           => __( 'Edit a car','pneus'),
          'update_item'         => __( 'Edit an automobile','pneus'),
		  'view_item'           => __( 'See automobiles','pneus'),
		  'search_items'        => __( 'Search a car','pneus'),
		  'not_found'           => __( 'Not found','pneus'),
		  'not_found_in_trash'  => __( 'Not found in trash','pneus')
	   );
	
	   // On peut définir ici d'autres options pour notre custom post type
	
	   $args = array(
		'label'               => __('Cars','pneus'),
		'description'         => __('Cars','pneus'),
		'labels'              => $labels,
        'supports'            => array( 'title', 'editor','link', 'author' ),
        'taxonomies'          => array('property_type'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 3,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
		'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'query_var'           => 'automobiles',
		'rewrite'			  => array( 'slug' => 'automobiles'),

	   );
	
	   // On enregistre notre custom post type qu'on nomme ici "automobiles" et ses arguments
	   register_post_type( 'automobiles', $args );
    }
    
    public function wpm_add_taxonomies()
    {
        
        // Taxonomie Marque
        
        // On déclare ici les différentes dénominations de notre taxonomie qui seront affichées et utilisées dans l'administration de WordPress
        $labels_marque = array(
		'name'              			=> __( 'Marques', 'taxonomy general name','pneus'),
		'singular_name'     			=> __( 'Marque', 'taxonomy singular name','pneus'),
		'search_items'      			=> __( 'Find a brand','pneus'),
        'popular_items'                 => __( 'Popular brands','pneus'),
		'all_items'        				=> __( 'All brands','pneus'),
        'parent_item'        			=> __( 'Parent brand','pneus'),
        'parent_item_colon'        		=> __( 'Parent brand','pneus'),
        'view_item'                     => __( 'See brands','pneus'),
		'edit_item'         			=> __( 'Edit brand','pneus'),
		'update_item'       			=> __( 'Update brand','pneus'),
		'add_new_item'     				=> __( 'Add a new brand','pneus'),
		'new_item_name'     			=> __( 'Value of the new brand','pneus'),
		'separate_items_with_commas'	=> __( 'Separate the marks with a comma','pneus'),
        'add_or_remove_items'	        => __( 'Add or remove brands','pneus'),
        'choose_from_most_used'	        => __( 'Choose from the most used','pneus'),
        'not_found'	                    => __( 'No mark found.','pneus'),
        'no_terms'	                    => __( 'No brand','pneus'),
        'items_list_navigation'	        => __( 'Navigation of the list of brands','pneus'),
        'items_list'	                => __( 'List of brands','pneus'),
        'most_used'	                    => __( 'More used','pneus'),
        'back_to_items'	                => __( 'Return to brands','pneus'),
		'menu_name'                     => __( 'Brand','pneus')
        );
        
        $args_marque = array(
            'label'               => __( 'Brand','pneus'),
            'description'         => __( 'Automotive Brands','pneus'),
            'labels'              => $labels_marque,
            'supports'            => array( 'title', 'editor','link', 'author' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'show_admin_column'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'marques' ),
        );
        
        register_taxonomy( 'marques', 'automobiles', $args_marque );

	// Taxonomie Modèles
	
	$labels_modeles = array(
		'name'                       => __( 'Modèles', 'taxonomy general name','pneus'),
		'singular_name'              => __( 'Modèle', 'taxonomy singular name','pneus'),
		'search_items'               => __( 'Find a model','pneus'),
		'popular_items'              => __( 'Popular models','pneus'),
		'all_items'                  => __( 'All Models','pneus'),
        'parent_item'                => __( 'Parent model','pneus'),
        'parent_item_colon'        	 => __( 'Parent model','pneus'),
        'view_item'                  => __( 'See models','pneus'),
		'edit_item'                  => __( 'Edit a model','pneus'),
		'update_item'                => __( 'Update a model','pneus'),
		'add_new_item'               => __( 'Add a new model','pneus'),
		'new_item_name'              => __( 'Name of the new model','pneus'),
		'separate_items_with_commas' => __( 'Separate models with a comma','pneus'),
		'add_or_remove_items'        => __( 'Add or remove a model','pneus'),
		'choose_from_most_used'      => __( 'Choose from the most used','pneus'),
		'not_found'                  => __( 'No models found','pneus'),
        'no_terms'	                 => __( 'No model','pneus'),
        'items_list_navigation'	     => __( 'Model list navigation','pneus'),
        'items_list'	             => __( 'List of models','pneus'),
        'most_used'	                 => __( 'More used','pneus'),
        'back_to_items'	             => __( 'Back to models','pneus'),
		'menu_name'                  => __( 'Models','pneus')
	);

	$args_modeles = array(
            'label'               => __('Models','pneus'),
            'description'         => __('Model','pneus'),
            'labels'              => $labels_modeles,
            'supports'            => array( 'title', 'editor','link', 'author' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'show_admin_column'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'modeles' ),
	);

	register_taxonomy( 'modeles', 'automobiles', $args_modeles );
	
	// Année

	$labels_annees = array(

		'name'                       => __( 'Années', 'taxonomy general name','pneus'),
		'singular_name'              => __( 'Année', 'taxonomy singular name','pneus'),
		'search_items'               => __( 'Search a year','pneus'),
		'popular_items'              => __( 'Popular years','pneus'),
		'all_items'                  => __( 'All years','pneus'),
        'parent_item'                => __( 'Parent year','pneus'),
        'parent_item_colon'        	 => __( 'Parent year','pneus'),
        'view_item'                  => __( 'See the years','pneus'),
		'edit_item'                  => __( 'Edit a year','pneus'),
		'update_item'                => __( 'Update a year','pneus'),
		'add_new_item'               => __( 'Add a new year','pneus'),
		'new_item_name'              => __( 'Name of the new year','pneus'),
        'separate_items_with_commas' => __( 'Separate years with a comma','pneus'),
		'add_or_remove_items'        => __( 'Add or delete a year','pneus'),
		'choose_from_most_used'      => __( 'Choose from the most used years','pneus'),
		'not_found'                  => __( 'No year found','pneus'),
        'no_terms'	                 => __( 'No year','pneus'),
        'items_list_navigation'	     => __( 'Navigation of the list of years','pneus'),
        'items_list'	             => __( 'List of years','pneus'),
        'most_used'	                 => __( 'More used','pneus'),
        'back_to_items'	             => __( 'Return to years','pneus'),
		'menu_name'                  => __( 'Years','pneus')
	);

	$args_annees = array(
            'label'               => __( 'Years','pneus'),
            'description'         => __( 'Years','pneus'),
            'labels'              => $labels_annees,
            'supports'            => array( 'title', 'editor','link', 'author' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'show_admin_column'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'annees' ),
	);

	register_taxonomy( 'annees', 'automobiles', $args_annees );

	// Type

	$labels_types = array(

		'name'                       => _x( 'Types', 'taxonomy general name','pneus'),
		'singular_name'              => _x( 'Type', 'taxonomy singular name','pneus'),
		'search_items'               => __( 'Find a type','pneus'),
		'popular_items'              => __( 'Popular types','pneus'),
		'all_items'                  => __( 'All types','pneus','pneus'),
        'parent_item'                => __( 'Parent type','pneus'),
        'parent_item_colon'        	 => __( 'Parent type','pneus'),
        'view_item'                  => __( 'See types','pneus'),
		'edit_item'                  => __( 'Edit a type','pneus'),
		'update_item'                => __( 'Update a type','pneus'),
		'add_new_item'               => __( 'Add a new type','pneus'),
		'new_item_name'              => __( 'Name of the new type','pneus'),
        'separate_items_with_commas' => __( 'Separate types with a comma','pneus'),
		'add_or_remove_items'        => __( 'Add or remove a type','pneus'),
		'choose_from_most_used'      => __( 'Choose from the most used types','pneus'),
		'not_found'                  => __( 'No type found','pneus'),
        'no_terms'	                 => __( 'No type','pneus'),
        'items_list_navigation'	     => __( 'Navigation of the list of types','pneus'),
        'items_list'	             => __( 'List of types','pneus'),
        'most_used'	                 => __( 'More used','pneus'),
        'back_to_items'	             => __( 'Return to types','pneus'),
		'menu_name'                  => __( 'Types','pneus')
	);

	$args_types = array(
            'label'               => __( 'Types','pneus'),
            'description'         => __( 'Types','pneus'),
            'labels'              => $labels_types,
            'supports'            => array( 'title', 'editor','link', 'author' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'show_admin_column'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'types' ),
	);

	register_taxonomy( 'types', 'automobiles', $args_types );
    
	// Options

	$labels_options = array(
		'name'                       => _x( 'Options', 'taxonomy general name','pneus'),
		'singular_name'              => _x( 'Option', 'taxonomy singular name','pneus'),
		'search_items'               => __( 'Search an option','pneus'),
		'popular_items'              => __( 'Popular options','pneus'),
		'all_items'                  => __( 'All options','pneus'),
        'parent_item'                => __( 'Parent option','pneus'),
        'parent_item_colon'        	 => __( 'Parent option','pneus'),
        'view_item'                  => __( 'See options','pneus'),
		'edit_item'                  => __( 'Edit an option','pneus'),
		'update_item'                => __( 'Update an option','pneus'),
		'add_new_item'               => __( 'Add a new option','pneus'),
		'new_item_name'              => __( 'Name of the new option','pneus'),
        'separate_items_with_commas' => __( 'Separate options with a comma','pneus'),
		'add_or_remove_items'        => __( 'Add or remove an option','pneus'),
		'choose_from_most_used'      => __( 'Choose from the most used options','pneus'),
		'not_found'                  => __( 'No options found','pneus'),
        'no_terms'	                 => __( 'No option','pneus'),
        'items_list_navigation'	     => __( 'Navigation of the list of options','pneus'),
        'items_list'	             => __( 'List of options','pneus'),
        'most_used'	                 => __( 'More used','pneus'),
        'back_to_items'	             => __( 'Return to options','pneus'),
		'menu_name'                  => __( 'Options','pneus')
	);

	$args_options = array(
            'label'               => __( 'Options','pneus'),
            'description'         => __( 'Options','pneus'),
            'labels'              => $labels_options,
            'supports'            => array( 'title', 'editor','link', 'author' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'show_admin_column'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'options' ),
	);

	register_taxonomy( 'options', 'automobiles', $args_options );

	// Pneus

	$labels_pneus = array(
		'name'                       => __( 'Pneus', 'taxonomy general name','pneus'),
		'singular_name'              => __( 'Pneu', 'taxonomy singular name','pneus'),
		'search_items'               => __( 'Find a tire','pneus'),
		'popular_items'              => __( 'Popular tires','pneus'),
		'all_items'                  => __( 'All tires','pneus','pneus'),
        'parent_item'                => __( 'Parent tire','pneus'),
        'parent_item_colon'        	 => __( 'Parent tire','pneus'),
        'view_item'                  => __( 'See the tires','pneus'),
		'edit_item'                  => __( 'Edit a tire','pneus'),
		'update_item'                => __( 'Update a tire', 'pneus'),
		'add_new_item'               => __( 'Add a new tire','pneus'),
		'new_item_name'              => __( 'Name of the new tire','pneus'),
        'separate_items_with_commas' => __( 'Separate the tires with a comma','pneus'),
        'no_terms'	                 => __( 'No tires','pneus'),
		'add_or_remove_items'        => __( 'Add or remove a tire','pneus'),
		'choose_from_most_used'      => __( 'Choose from the most used tires','pneus'),
		'not_found'                  => __( 'No tires found','pneus'),
        'items_list_navigation'	     => __( 'Navigation of the list of tires','pneus'),
        'items_list'	             => __( 'List of tires','pneus'),
        'most_used'	                 => __( 'More used','pneus'),
        'back_to_items'	             => __( 'Return to the tires','pneus'),
		'menu_name'                  => __( 'Tires','pneus')
	);

	$args_pneus = array(
            'label'               => __('Tires','pneus'),
            'description'         => __('Tire','pneus'),
            'labels'              => $labels_pneus,
            'supports'            => array( 'title', 'editor','link', 'author' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'show_admin_column'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'spneus' ),
	);

	register_taxonomy( 'pneus', 'automobiles', $args_pneus );
    
    	// Prix

	$labels_p = array(
		'name'                       => _x( 'Price', 'taxonomy general name','pneus'),
		'singular_name'              => _x( 'Price', 'taxonomy singular name','pneus'),
		'search_items'               => __( 'Search a price','pneus'),
		'popular_items'              => __( 'Popular prices','pneus'),
		'all_items'                  => __( 'All prices','pneus'),
        'parent_item'        		 => __( 'Parent price','pneus'),
        'parent_item_colon'        	 => __( 'Parent price','pneus'),
        'view_item'                  => __( 'See prices','pneus'),
		'edit_item'                  => __( 'Edit price','pneus'),
		'update_item'                => __( 'Update a price','pneus'),
		'add_new_item'               => __( 'Add a new price','pneus'),
		'new_item_name'              => __( 'Amount of new price','pneus'),
        'separate_items_with_commas' => __( 'Separate prices with a comma','pneus'),
        'no_terms'	                 => __( 'No price','pneus'),
		'add_or_remove_items'        => __( 'Add or remove a price','pneus'),
		'choose_from_most_used'      => __( 'Choose from the most used prices','pneus'),
		'not_found'                  => __( 'No prices found','pneus'),
        'items_list_navigation'	     => __( 'Navigation of the price list','pneus'),
        'items_list'	             => __( 'List of prices','pneus'),
        'most_used'	                 => __( 'More used','pneus'),
        'back_to_items'	             => __( 'Return to prices','pneus'),
		'menu_name'                  => __( 'Price','pneus')
	);

	$args_prix = array(
            'label'               => __( 'Price','pneus'),
            'description'         => __( 'Price','pneus'),
            'labels'              => $labels_prix,
            'type'                => 'numeric',
            'supports'            => array( 'title', 'editor','link', 'author' ),
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'show_admin_column'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'query_var'           => true,
            'rewrite'             => array( 'slug' => 'prix' ),
	);
    register_taxonomy( 'prix', 'automobiles', $args_prix );


    add_action( 'contextual_help', array($this, 'my_contextual_help'), 10, 3 );
    add_filter( 'post_updated_messages', array($this, 'my_updated_messages') );
    add_action('pre_get_posts',array($this, 'wpc_cpt_in_home'));
    add_action('pre_get_posts',array($this, 'wpc_cpt_in_search'));
    add_action('pre_get_posts',array($this, 'wpc_cpt_in_archive'));
    }
    
    public function my_updated_messages( $messages ) {
        
        global $post, $post_ID;
        $messages['automobiles'] = array(
            0 => '', 
            1 => sprintf( __('updated car <a href="%s"> See the automobile </a>','pneus'), esc_url( get_permalink($post_ID) ) ),
            2 => __('Custom field updated.','pneus'),
            3 => __('Custom field deleted.','pneus'),
            4 => __('Automobile updated.','pneus'),
            5 => isset($_GET['revision']) ? sprintf( __('Automobile restored to revision of %s','pneus'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6 => sprintf( __('Posted Automotive <a href="%s"> View Car </a>','pneus'), esc_url( get_permalink($post_ID) ) ),
            7 => __('Registered automobile','pneus'),
            8 => sprintf( __('Automotive Submission <a target="_blank" href="%s"> Automotive Overview </a>','pneus'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
            9 => sprintf( __('Automobile planned for: <strong>%1$ s </ strong>. <a target="_blank" href="%2$s"> Auto Overview </a>','pneus'), date_i18n(( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
            10 => sprintf( __('Updated car version <a target="_blank" href="%s"> Auto Overview </a>','pneus'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );
        
        return $messages;
    }
    
    public function my_contextual_help( $contextual_help, $screen_id, $screen )
    {
    $screen = get_current_screen();;
    //var_dump($screen);
        
    if ( 'edit-automobiles' == $screen->id ){
        $screen->add_help_tab( array(
            'id'		=> 'overview',
            'title'		=> __('Overview','pneus'),
            'content'	=>
                '<p>' . __('This screen gives access to all your cars. You can customize the display of this screen according to your workflow.','pneus').'</p>'
        ) );
        $screen->add_help_tab( array(
            'id' => 'screen-content',
            'title' => 'Contenu de l\'écran',
            'content' =>
                '<p>' . __('You can customize the display of the content of this screen in several ways:','pneus').'</p>'.
                    '<ul>' .
                        '<li>' . __('You can hide/display columns based on your needs and decide how many posts to list per screen using the Screen Options tab.','pneus') . '</li>'.
                        '<li>' .  __( 'You can filter the list of posts by post status using the text links above the posts list to only show posts with that status. The default view is to show all posts.','pneus' ) . '</li>'.
                        '<li>' .  __('You can view posts in a simple title list or with an excerpt using the Screen Options tab.','pneus') . '</li>'.
                        '<li>' .  __('You can refine the list to show only posts in a specific category or from a specific month by using the dropdown menus above the posts list. Click the Filter button after making your selection. You also can refine the list by clicking on the post author, category or tag in the posts list.','pneus').  '</li>'.
                        '<li>' . __('You can refine the list to show only posts in a specific category or from a specific month by using the dropdown menus above the posts list. Click the Filter button after making your selection. You also can refine the list by clicking on the post author, category or tag in the posts list.','pneus') . '</li>' .
                    '</ul>'
        ) );
        $screen->add_help_tab( array(
            'id'		=> 'action-links',
            'title'		=> __('Available Actions'),
            'content'	=>
                '<p>' . __('Hovering over a row in the posts list will display action links that allow you to manage your post. You can perform the following actions:') . '</p>' .
                    '<ul>' .
                        '<li>' . __('<strong>Edit</strong> takes you to the editing screen for that post. You can also reach that screen by clicking on the post title.') . '</li>' .
                        '<li>' . __('<strong>Quick Edit</strong> provides inline access to the metadata of your post, allowing you to update post details without leaving this screen.') . '</li>' .
                        '<li>' . __('<strong>Trash</strong> removes your post from this list and places it in the trash, from which you can permanently delete it.') . '</li>' .
                        '<li>' . __('<strong>Preview</strong> will show you what your draft post will look like if you publish it. View will take you to your live site to view the post. Which link is available depends on your post&#8217;s status.','pneus') . '</li>' .
                    '</ul>'
        ) );
        $screen->add_help_tab( array(
            'id'		=> 'bulk-actions',
            'title'		=> __('Bulk Actions'),
            'content'	=>
                '<p>' . __('You can also edit or move multiple posts to the trash at once. Select the posts you want to act on using the checkboxes, then select the action you want to take from the Bulk Actions menu and click Apply.','pneus') . '</p>' .
				'<p>' . __('When using Bulk Edit, you can change the metadata (categories, author, etc.) for all selected posts at once. To remove a post from the grouping, just click the x next to its name in the Bulk Edit area that appears.','pneus') . '</p>'
        ) );
    }elseif ( 'automobiles' == $screen->id ) {
        $screen->add_help_tab( array(
            'id'        => 'Ajouter',
            'title'     => 'Ajouter',
            'content'  =>
                '<p>Cette page vous permet d\'afficher / modifier les détails de l\'automobile. Veuillez vous assurer de remplir les cases disponibles avec les détails appropriés et <strong> ne pas </strong> ajouter ces détails à la description de l\'automobile.</p>'
        ) );
    }elseif ( 'edit-marques' == $screen->id ) {
        $screen->add_help_tab( array(
            'id'        => 'Marque',
            'title'     => 'Marque',
            'content'  =>
                '<p>Cette page vous permet d\'afficher / modifier les détails de la marque. Veuillez vous assurer de remplir les cases disponibles avec les détails appropriés et <strong> ne pas </strong> ajouter ces détails à la description de l\'automobile.</p>'
        ) );
    }elseif ( 'edit-modeles' == $screen->id ) {
        $screen->add_help_tab( array(
            'id'        => 'Modeles',
            'title'     => 'Modèles',
            'content'  =>
                '<p>Cette page vous permet d\'afficher / modifier les détails du modèle. Veuillez vous assurer de remplir les cases disponibles avec les détails appropriés et <strong> ne pas </strong> ajouter ces détails à la description de l\'automobile.</p>'
        ) );
    }elseif ( 'edit-annees' == $screen->id ) {
        $screen->add_help_tab( array(
            'id'        => 'Annees',
            'title'     => 'Années',
            'content'  =>
                '<p>Cette page vous permet d\'afficher / modifier les détails de l\'année. Veuillez vous assurer de remplir les cases disponibles avec les détails appropriés et <strong> ne pas </strong> ajouter ces détails à la description de l\'automobile.</p>'
        ) );
    }elseif ( 'edit-types' == $screen->id ) {
        $screen->add_help_tab( array(
            'id'        => 'Types',
            'title'     => 'Types',
            'content'  =>
                '<p>Cette page vous permet d\'afficher / modifier les détails du type de automobiles. Veuillez vous assurer de remplir les cases disponibles avec les détails appropriés et <strong> ne pas </strong> ajouter ces détails à la description de l\'automobile.</p>'
        ) );
    }elseif ( 'edit-options' == $screen->id ) {
        $screen->add_help_tab( array(
            'id'        => 'Options',
            'title'     => 'Options',
            'content'  =>
                '<p>Cette page vous permet d\'afficher / modifier les détails des options. Veuillez vous assurer de remplir les cases disponibles avec les détails appropriés et <strong> ne pas </strong> ajouter ces détails à la description de l\'automobile.</p>'
        ) );
    }elseif ( 'edit-pneus' == $screen->id ) {
        $screen->add_help_tab( array(
            'id'        => 'Pneus',
            'title'     => 'Pneus',
            'content'  =>
                '<p>Cette page vous permet d\'afficher / modifier les détails du pneu. Veuillez vous assurer de remplir les cases disponibles avec les détails appropriés et <strong> ne pas </strong> ajouter ces détails à la description de l\'automobile.</p>'
        ) );
    }
  
  return $contextual_help;

    }
    
    public function wpc_cpt_in_home($query) {
        if (! is_admin() && $query->is_main_query()) {
            if ($query->is_home) {
                $query->set('post_type', array('automobiles'));
            }
        }
    }
    
    public function wpc_cpt_in_search($query) {
        if (! is_admin() && $query->is_main_query()) {
            if ($query->is_search) {
                $query->set('post_type', array('automobiles'));
            }
        }
    }

    public function wpc_cpt_in_archive($query) {
        if (! is_admin() && $query->is_main_query()) {
            if ($query->is_archive) {
                $query->set('post_type', array('automobiles'));
            }
        }
    }
    

}
 new Pneus_Plugin();