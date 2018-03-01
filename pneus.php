<?php
/**
 * Plugin Name: Pneus
 * Description: Classification de pneus
 * Version: 1.0
 * Author: Denis Boucher
 */
 class Pneus_Plugin
 {
    public function __construct(){
        include_once plugin_dir_path( __FILE__ ).'/inventaire.php';
        new Inventaire();
        
        register_activation_hook(__FILE__, array('Inventaire', 'install'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        register_uninstall_hook(__FILE__, array('Inventaire', 'uninstall'));
    }
    
    public function add_admin_menu()
    {
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

 }
 new Pneus_Plugin();