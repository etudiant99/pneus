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
        echo '<h1>'.get_admin_page_title().'</h1>';
        echo '<p>Bienvenue sur la page d\'accueil du plugin</p>';
    }


 }
 new Pneus_Plugin();