<?php
include_once plugin_dir_path( __FILE__ ).'/inventairewidget.php';

class Inventaire{
    public function __construct(){
        
        add_action("wp_footer", array($this, 'inventaire_results_before_content'));
        add_action('widgets_init', function(){register_widget('Inventaire_Widget');});
        add_action('admin_menu', array($this, 'add_admin_menu'), 20);
        add_action('wp_loaded', array($this, 'save_infos'));
     }

    public static function install()
    {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inventaire (id INT AUTO_INCREMENT PRIMARY KEY, marque VARCHAR(255), modele VARCHAR(255) );");
    }

    public static function uninstall()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inventaire;");
    }

    public function add_admin_menu()
    {
        $hook = add_submenu_page('pneus', 'Inventaire', 'Inventaire', 'manage_options', 'zero_newsletter', array($this, 'menu_html'));
        add_action('load-'.$hook, array($this, 'process_action'));
    }
    
    public function menu_html()
    {
        echo '<h1>'.get_admin_page_title().'</h1>';
        ?>
        <form action="" method="post">
            <p>
                <label for="marque">Marque :</label>
                <input id="pneus_marque" name="pneus_marque" type="text"/>
                <label for="modele">Modèle :</label>
                <input id="pneus_modele" name="pneus_modele" type="text"/>
            </p>
            <?php submit_button(); ?>
        </form>
        <?php
    }

    public function process_action()
    {
        if (isset($_POST['send_infos'])) {
            $this->send_infos();
        }
    }

    public function save_infos()
    {
        if (isset($_POST['pneus_marque']) && !empty($_POST['pneus_marque']) && !empty($_POST['pneus_modele'])) {
            global $wpdb;
            $marque = $_POST['pneus_marque'];
            $modele = $_POST['pneus_modele'];

            $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}inventaire WHERE marque = '$marque' && modele = '$modele'");
            if (is_null($row)) {
                $wpdb->insert("{$wpdb->prefix}inventaire", array('marque' => $marque, 'modele' => $modele));
            }
        }
    }
    
    public function inventaire_results_before_content()
    {
        global $wpdb;
        $result = 0;
        
        $list = $debug.'<div style="margin: 20px 0 20px 0; padding:10px; "><div class="content-headline"><h1 class="entry-headline"><span class="entry-headline-text">Résultat de la recherche</span></h1></div><hr />';
    
        if ((isset($_POST['marque']))&&($_POST['marque'] != "")){
            $marque = $_POST['marque'];
            $allItems = $wpdb->get_results("SELECT * FROM wp_inventaire WHERE marque = '$marque'");
            
            // Ecriture du résultat trouvé
            foreach ($allItems as $singleItem) {
                $result++;
                $list .= '<article style="float: left;margin: 0 20px 20px 0;width: 100%;">'.$singleItem->marque.' '.$singleItem->modele.'</article>';
            }

			if ($result == 0){
				$list .= "Aucun résultat pour cette recherche.";
			}
            
            $list .= '<br style="clear:both;"></div>';
            ?>
            <script>
                var div = document.createElement('div');
                div.innerHTML = '<?php echo $list; ?>';
        
                var child = document.getElementById('main');
                child.parentNode.insertBefore(div, child);
            </script>
        <?php
        }
    }
}