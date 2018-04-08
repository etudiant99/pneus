<?php
/**
 * Plugin Name: Pneus
 * Description: Classification de pneus
 * Version: 1.3
 * Author: Denis Boucher
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
        //wp_enqueue_style( 'bootstrap' );
    }
    
    public function add_admin_menu()
    {
        // 'toplevel_page_pneus'
        add_menu_page('Inventaire de pneus', 'Pneu plugin', 'manage_options', 'pneus', array($this, 'menu_html'));
    }
    
    public function menu_html()
    {
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <p>Bienvenue sur la page d'accueil du plugin</p>
        <br />
        <p>Ce plugin ajoute une table "inventaire".<br />
        Elle y ajoute ensuite les champs "marque" et "modele".<br />
        Par la suite, il vous sera possible d'ajouter des données à cette table, pour permettre ensuite une recherche.</p>
        <?php
    }
    
    public function wpm_custom_post_type()
    {
        // On rentre les différentes dénominations de notre custom post type qui seront affichées dans l'administration
        $labels = array(
		  'name'                => _x( 'Automobiles', 'Post Type General Name'),
		  'singular_name'       => _x( 'Automobile', 'Post Type Singular Name'),
		  'menu_name'           => __( 'Automobiles'),
          'name_admin_bar'      => __( 'Automobiles'),
          'parent_item_colon'   => __( 'Item parent:'),
		  'all_items'           => __( 'Toutes les automobiles'),
          'add_new_item'        => __( 'Ajouter une nouvelle automobile'),
          'add_new'             => __( 'Ajouter'),
          'new_item'            => __( 'Nouvelle automobile'),
          'edit_item'           => __( 'Editer une automobile'),
          'update_item'         => __( 'Modifier une automobile'),
		  'view_item'           => __( 'Voir les automobiles'),
		  'search_items'        => __( 'Rechercher une automobile'),
		  'not_found'           => __( 'Non trouvée'),
		  'not_found_in_trash'  => __( 'Non trouvée dans la corbeille')
	   );
	
	   // On peut définir ici d'autres options pour notre custom post type
	
	   $args = array(
		'label'               => __( 'Automobiles'),
		'description'         => __( 'Automobiles'),
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
		'name'              			=> _x( 'Marques', 'taxonomy general name'),
		'singular_name'     			=> _x( 'Marque', 'taxonomy singular name'),
		'search_items'      			=> __( 'Chercher une marque'),
        'popular_items'                 => __( 'Marques populaires'),
		'all_items'        				=> __( 'Toutes les marques'),
        'parent_item'        			=> __( 'Marque parente'),
        'parent_item_colon'        		=> __( 'Marque parente'),
        'view_item'                     => __( 'Voir les marques'),
		'edit_item'         			=> __( 'Editer la marque'),
		'update_item'       			=> __( 'Mettre à jour la marque'),
		'add_new_item'     				=> __( 'Ajouter une nouvelle marque'),
		'new_item_name'     			=> __( 'Valeur de la nouvelle marque'),
		'separate_items_with_commas'	=> __( 'Séparer les marques avec une virgule'),
        'add_or_remove_items'	        => __( 'Ajouter ou supprimer des marques'),
        'choose_from_most_used'	        => __( 'Choisir parmi les plus utilisées'),
        'not_found'	                    => __( 'Aucune marque trouvée.'),
        'no_terms'	                    => __( 'Aucune marque'),
        'items_list_navigation'	        => __( 'Navigation de la liste des marques'),
        'items_list'	                => __( 'Liste des marques'),
        'most_used'	                    => __( 'Plus utilisées'),
        'back_to_items'	                => __( '&larr; Revenir aux marques'),
		'menu_name'                     => __( 'Marque')
        );
        
        $args_marque = array(
            'label'               => __( 'Marque'),
            'description'         => __( 'Marques automobiles'),
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
		'name'                       => _x( 'Modèles', 'taxonomy general name'),
		'singular_name'              => _x( 'Modèle', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher un modèle'),
		'popular_items'              => __( 'Modèles populaires'),
		'all_items'                  => __( 'Tous les modèles'),
        'parent_item'                => __( 'Modèle parent'),
        'parent_item_colon'        	 => __( 'Modèle parent'),
        'view_item'                  => __( 'Voir les modèles'),
		'edit_item'                  => __( 'Editer un modèle'),
		'update_item'                => __( 'Mettre à jour un modèle'),
		'add_new_item'               => __( 'Ajouter un nouveau modèle'),
		'new_item_name'              => __( 'Nom du nouveau modèle'),
		'separate_items_with_commas' => __( 'Séparer les modèles avec une virgule'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un modèle'),
		'choose_from_most_used'      => __( 'Choisir parmi les plus utilisés'),
		'not_found'                  => __( 'Pas de modèles trouvés'),
        'no_terms'	                 => __( 'Aucun modèle'),
        'items_list_navigation'	     => __( 'Navigation de la liste des modèles'),
        'items_list'	             => __( 'Liste des modèles'),
        'most_used'	                 => __( 'Plus utilisés'),
        'back_to_items'	             => __( '&larr; Revenir aux modèles'),
		'menu_name'                  => __( 'Modèles')
	);

	$args_modeles = array(
            'label'               => __( 'Modèles'),
            'description'         => __( 'Modèles'),
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

		'name'                       => _x( 'Années', 'taxonomy general name'),
		'singular_name'              => _x( 'Année', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher une année'),
		'popular_items'              => __( 'Années populaires'),
		'all_items'                  => __( 'Toutes les années'),
        'parent_item'                => __( 'Année parente'),
        'parent_item_colon'        	 => __( 'Année parente'),
        'view_item'                  => __( 'Voir les années'),
		'edit_item'                  => __( 'Editer une année'),
		'update_item'                => __( 'Mettre à jour une année'),
		'add_new_item'               => __( 'Ajouter une nouvelle année'),
		'new_item_name'              => __( 'Nom de la nouvelle année'),
        'separate_items_with_commas' => __( 'Séparer les années avec une virgule'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer une année'),
		'choose_from_most_used'      => __( 'Choisir parmi les années les plus utilisées'),
		'not_found'                  => __( 'Pas d\' année trouvées'),
        'no_terms'	                 => __( 'Aucune année'),
        'items_list_navigation'	     => __( 'Navigation de la liste des années'),
        'items_list'	             => __( 'Liste des années'),
        'most_used'	                 => __( 'Plus utilisées'),
        'back_to_items'	             => __( '&larr; Revenir aux années'),
		'menu_name'                  => __( 'Années')
	);

	$args_annees = array(
            'label'               => __( 'Années'),
            'description'         => __( 'Années'),
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

		'name'                       => _x( 'Types', 'taxonomy general name'),
		'singular_name'              => _x( 'Type', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher un type'),
		'popular_items'              => __( 'Types populaires'),
		'all_items'                  => __( 'Tous les types'),
        'parent_item'                => __( 'Type parent'),
        'parent_item_colon'        	 => __( 'Type parent'),
        'view_item'                  => __( 'Voir les types'),
		'edit_item'                  => __( 'Editer un type'),
		'update_item'                => __( 'Mettre à jour un type'),
		'add_new_item'               => __( 'Ajouter un nouveau type'),
		'new_item_name'              => __( 'Nom du nouveau type'),
        'separate_items_with_commas' => __( 'Séparer les types avec une virgule'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un type'),
		'choose_from_most_used'      => __( 'Choisir parmi les types les plus utilisés'),
		'not_found'                  => __( 'Pas de type trouvés'),
        'no_terms'	                 => __( 'Aucun type'),
        'items_list_navigation'	     => __( 'Navigation de la liste des types'),
        'items_list'	             => __( 'Liste des types'),
        'most_used'	                 => __( 'Plus utilisés'),
        'back_to_items'	             => __( '&larr; Revenir aux types'),
		'menu_name'                  => __( 'Types')
	);

	$args_types = array(
            'label'               => __( 'Types'),
            'description'         => __( 'Types'),
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
		'name'                       => _x( 'Options', 'taxonomy general name'),
		'singular_name'              => _x( 'Option', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher une option'),
		'popular_items'              => __( 'Options populaires'),
		'all_items'                  => __( 'Toutes les options'),
        'parent_item'                => __( 'Option parente'),
        'parent_item_colon'        	 => __( 'Option parente'),
        'view_item'                  => __( 'Voir les options'),
		'edit_item'                  => __( 'Editer une option'),
		'update_item'                => __( 'Mettre à jour une option'),
		'add_new_item'               => __( 'Ajouter une nouvelle option'),
		'new_item_name'              => __( 'Nom de la nouvelle option'),
        'separate_items_with_commas' => __( 'Séparer les options avec une virgule'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer une option'),
		'choose_from_most_used'      => __( 'Choisir parmi les options les plus utilisées'),
		'not_found'                  => __( 'Pas d\'options trouvées'),
        'no_terms'	                 => __( 'Aucune option'),
        'items_list_navigation'	     => __( 'Navigation de la liste des options'),
        'items_list'	             => __( 'Liste des options'),
        'most_used'	                 => __( 'Plus utilisées'),
        'back_to_items'	             => __( '&larr; Revenir aux options'),
		'menu_name'                  => __( 'Options')
	);

	$args_options = array(
            'label'               => __( 'Options'),
            'description'         => __( 'Options'),
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
		'name'                       => _x( 'Pneus', 'taxonomy general name'),
		'singular_name'              => _x( 'Pneu', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher un pneu'),
		'popular_items'              => __( 'Pneus populaires'),
		'all_items'                  => __( 'Tous les pneus'),
        'parent_item'                => __( 'Pneu parent'),
        'parent_item_colon'        	 => __( 'Pneu parent'),
        'view_item'                  => __( 'Voir les pneus'),
		'edit_item'                  => __( 'Editer un pneu'),
		'update_item'                => __( 'Mettre à jour un pneu'),
		'add_new_item'               => __( 'Ajouter un nouveau pneu'),
		'new_item_name'              => __( 'Nom du nouveau pneu'),
        'separate_items_with_commas' => __( 'Séparer les pneus avec une virgule'),
        'no_terms'	                 => __( 'Aucun pneu'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un pneu'),
		'choose_from_most_used'      => __( 'Choisir parmi les pneus les plus utilisés'),
		'not_found'                  => __( 'Pas de pneus trouvés'),
        'items_list_navigation'	     => __( 'Navigation de la liste des pneus'),
        'items_list'	             => __( 'Liste des pneus'),
        'most_used'	                 => __( 'Plus utilisés'),
        'back_to_items'	             => __( '&larr; Revenir aux pneus'),
		'menu_name'                  => __( 'Pneus')
	);

	$args_pneus = array(
            'label'               => __( 'Pneus'),
            'description'         => __( 'Pneus'),
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
            'rewrite'             => array( 'slug' => 'pneus' ),
	);

	register_taxonomy( 'pneus', 'automobiles', $args_pneus );
    
    	// Prix

	$labels_p = array(
		'name'                       => _x( '_price', 'taxonomy general name'),
		'singular_name'              => _x( 'Prix', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher un prix'),
		'popular_items'              => __( 'Prix populaires'),
		'all_items'                  => __( 'Tous les prix'),
        'parent_item'                => __( 'Prix parent'),
        'parent_item_colon'        	 => __( 'Prix parent'),
        'view_item'                  => __( 'Voir les prix'),
		'edit_item'                  => __( 'Editer un prix'),
		'update_item'                => __( 'Mettre à jour un prix'),
		'add_new_item'               => __( 'Ajouter un nouveau prix'),
		'new_item_name'              => __( 'Nom du nouveau prix'),
        'separate_items_with_commas' => __( 'Séparer les pri axvec une virgule'),
        'no_terms'	                 => __( 'Aucun prix'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un prix'),
		'choose_from_most_used'      => __( 'Choisir parmi les prix les plus utilisés'),
		'not_found'                  => __( 'Pas de prix trouvés'),
        'items_list_navigation'	     => __( 'Navigation de la liste des prix'),
        'items_list'	             => __( 'Liste des prix'),
        'most_used'	                 => __( 'Plus utilisés'),
        'back_to_items'	             => __( '&larr; Revenir aux prix'),
		'menu_name'                  => __( 'Prix')
	);

	$args_prix = array(
            'label'               => __( 'Prix'),
            'description'         => __( 'Prix'),
            'labels'              => $labels_prix,
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
            1 => sprintf( __('automobile mis à jour <a href="%s">Voir l\'automobile</a>'), esc_url( get_permalink($post_ID) ) ),
            2 => __('Champ personnalisé mis à jour.'),
            3 => __('Champ personnalisé supprimé.'),
            4 => __('Automobile mis à jour.'),
            5 => isset($_GET['revision']) ? sprintf( __('Automobile restauré à la révision de %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6 => sprintf( __('Automobile publiée <a href="%s">Voir l\'automobile</a>'), esc_url( get_permalink($post_ID) ) ),
            7 => __('Automobile enregistrée'),
            8 => sprintf( __('Automobile soumise <a target="_blank" href="%s">Aperçu de l\'automobile</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
            9 => sprintf( __('Automobile prévue pour: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Aperçu de l\'automobile</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
            10 => sprintf( __('Version de l\'automobile mise à jour <a target="_blank" href="%s">Aperçu de l\'automobile</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
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
            'title'		=> __('Vue d\'ensemble'),
            'content'	=>
                '<p>' . __('Cet écran donne accès à toutes vos automobiles. Vous pouvez personnaliser l\'affichage de cet écran en fonction de votre flux de travail. ').'</p>'
        ) );
        $screen->add_help_tab( array(
            'id' => 'screen-content',
            'title' => 'Contenu de l\'écran',
            'content' =>
                '<p>' . __('Vous pouvez personnaliser l\'affichage du contenu de cet écran de plusieurs façons: ').'</p>'.
                    '<ul>' .
                        '<li>' . __('You can hide/display columns based on your needs and decide how many posts to list per screen using the Screen Options tab.') . '</li>'.
                        '<li>' .  __( 'You can filter the list of posts by post status using the text links above the posts list to only show posts with that status. The default view is to show all posts.' ) . '</li>'.
                        '<li>' .  __('You can view posts in a simple title list or with an excerpt using the Screen Options tab.') . '</li>'.
                        '<li>' .  __('You can refine the list to show only posts in a specific category or from a specific month by using the dropdown menus above the posts list. Click the Filter button after making your selection. You also can refine the list by clicking on the post author, category or tag in the posts list.').  '</li>'.
                        '<li>' . __('You can refine the list to show only posts in a specific category or from a specific month by using the dropdown menus above the posts list. Click the Filter button after making your selection. You also can refine the list by clicking on the post author, category or tag in the posts list.') . '</li>' .
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
                        '<li>' . __('<strong>Preview</strong> will show you what your draft post will look like if you publish it. View will take you to your live site to view the post. Which link is available depends on your post&#8217;s status.') . '</li>' .
                    '</ul>'
        ) );
        $screen->add_help_tab( array(
            'id'		=> 'bulk-actions',
            'title'		=> __('Bulk Actions'),
            'content'	=>
                '<p>' . __('You can also edit or move multiple posts to the trash at once. Select the posts you want to act on using the checkboxes, then select the action you want to take from the Bulk Actions menu and click Apply.') . '</p>' .
				'<p>' . __('When using Bulk Edit, you can change the metadata (categories, author, etc.) for all selected posts at once. To remove a post from the grouping, just click the x next to its name in the Bulk Edit area that appears.') . '</p>'
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