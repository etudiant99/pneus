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
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inventaire (id INT AUTO_INCREMENT PRIMARY KEY, marque VARCHAR(255), modele VARCHAR(255), annee INT, largeur INT, hauteur INT, diametre INT );");
    }

    public static function uninstall()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inventaire;");
    }

    public function add_admin_menu()
    {
        $hook = add_submenu_page('pneus', 'Inventaire', 'Inventaire', 'manage_options', 'newsletter', array($this, 'menu_html'));
        add_action('load-'.$hook, array($this, 'process_action'));
    }
    
    public function menu_html()
    {
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <form action="" method="post">
            <p>
                <label style="display:inline-block; width:65px;" for="marque">Marque :</label>
                <input id="pneus_marque" name="pneus_marque" type="text"/>
            </p>
            <p>
                <label style="display:inline-block; width:65px;" for="modele">Modèle :</label>
                <input id="pneus_modele" name="pneus_modele" type="text"/>
            </p>
            <p>
                <label style="display:inline-block; width:65px;" for="annee">Année :</label>
                <input id="annee" name="annee" type="text"/>
            </p>
            <p>
                <label style="display:inline-block; width:65px;" for="largeur">Largeur :</label>
                <input id="largeur" name="largeur" type="text"/>
            </p>
            <p>
                <label style="display:inline-block; width:65px;" for="hauteur">Hauteur :</label>
                <input id="hauteur" name="hauteur" type="text"/>
            </p>
            <p>
                <label style="display:inline-block; width:65px;" for="diametre">Diamètre :</label>
                <input id="diametre" name="diametre" type="text"/>
            </p>

            <input type="submit" value="Enregistrer" style="background-color: lightblue;" />
        </form>
        <br /><br />
        
        <?php
    }

    public function process_action()
    {
        if (isset($_POST['send_infos']))
            $this->send_infos();
    }

    public function save_infos()
    {
        if (isset($_POST['pneus_marque']) && !empty($_POST['pneus_marque']) && !empty($_POST['pneus_modele'])) {
            global $wpdb;
            $marque = $_POST['pneus_marque'];
            $modele = $_POST['pneus_modele'];
            $annee = $_POST['annee'];
            $largeur = $_POST['largeur'];
            $hauteur = $_POST['hauteur'];
            $diametre = $_POST['diametre'];

            $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}inventaire WHERE marque = '$marque' && modele = '$modele'");        
            if (is_null($row))
                $wpdb->insert("{$wpdb->prefix}inventaire", array('marque' => $marque, 'modele' => $modele, 'annee' => $annee, 'largeur' => $largeur, 'hauteur' => $hauteur, 'diametre' => $diametre));
        }
    }
    
    public function inventaire_results_before_content()
    {
        global $wpdb;
        $result = 0;
        
        $list = $debug.'<div style="margin: 20px 0 20px 0; padding:10px; "><div class="content-headline"><h1 class="entry-headline"><span class="entry-headline-text">Résultat de la recherche</span></h1></div><hr />';
    
        if ((isset($_POST['marque']))&&($_POST['marque'] != "")){
            $marque = $_POST['marque'];
            $allItems = $wpdb->get_results("SELECT * FROM wp_inventaire WHERE marque = '$marque' ORDER BY marque,modele");

            // Ecriture du résultat trouvé
            if (count($allItems) > 0)
                $list .= '<span style="display:inline-block; width:65px; margin-bottom: 10px; font-weight: bold;">Marque</span><span style="display:inline-block; width:175px; font-weight: bold;">Modèle</span><span style="display:inline-block; width:65px; font-weight: bold;">Année</span><span style="display:inline-block; width:65px; font-weight: bold;">Largeur</span><span style="display:inline-block; width:65px; font-weight: bold;">Hauteur</span><span style="display:inline-block; width:65px; font-weight: bold;">Diamètre</span><br />';
            foreach ($allItems as $singleItem) {
                $result++;
                $list .= '<article style="float: left; margin: 0 20px 5px 0; width: 100%;"><span style="display:inline-block; width:65px;">'.$singleItem->marque.'</span><span style="display:inline-block; width:175px;">'.$singleItem->modele.'</span><span style="display:inline-block; width:65px;">'.$singleItem->annee.'</span><span style="display:inline-block; width:65px;">'.$singleItem->hauteur.'</span><span style="display:inline-block; width:65px;">'.$singleItem->largeur.'</span><span style="display:inline-block; width:65px;">'.$singleItem->diametre.'</span></article>';
            }

			if ($result == 0){
				$list .= "Aucun résultat pour cette recherche (<b>".$marque."</b>).";
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