<?php
include_once plugin_dir_path( __FILE__ ).'/inventairewidget.php';

class Inventaire{
    const CSS = 'mon.css';
    public function __construct(){
        wp_enqueue_style( 'pneus', plugins_url(self::CSS, __FILE__) );
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
        $hook = add_submenu_page('pneus', 'Inventaire', 'Inventaire', 'manage_options', 'inventaire', array($this, 'menu_html'));
        add_action('load-'.$hook, array($this, 'process_action'));
    }
    
    public function menu_html()
    {
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <form action="" method="post">
            <p>
                <label class="exemple" for="marque">Marque :</label>
                <input id="pneus_marque" name="pneus_marque" type="text"/>
            </p>
            <p>
                <label class="exemple" for="modele">Modèle :</label>
                <input id="pneus_modele" name="pneus_modele" type="text"/>
            </p>
            <p>
                <label class="exemple" for="annee">Année :</label>
                <input id="annee" name="annee" type="text"/>
            </p>
            <p>
                <label class="exemple" for="largeur">Largeur :</label>
                <input id="largeur" name="largeur" type="text"/>
            </p>
            <p>
                <label class="exemple" for="hauteur">Hauteur :</label>
                <input id="hauteur" name="hauteur" type="text"/>
            </p>
            <p>
                <label class="exemple" for="diametre">Diamètre :</label>
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
        
        $list = $debug.'<div class="latable"><div class="content-headline"><h1 class="entry-headline"><span class="entry-headline-text">Résultat de la recherche</span></h1></div><hr />';
    
        if ((isset($_POST['marque']))&&($_POST['marque'] != "")){
            $marque = $_POST['marque'];
            $allItems = $wpdb->get_results("SELECT * FROM wp_inventaire WHERE marque = '$marque' ORDER BY marque,modele");

            // Ecriture du résultat trouvé
            if (count($allItems) > 0)
                $list .= '<span id="titre_marque">Marque</span><span id="titre_modele">Modèle</span><span id="titre_annee">Année</span><span id="titre_largeur">Largeur</span><span id="titre_hauteur">Hauteur</span><span id="titre_diametre">Diamètre</span><br />';
            foreach ($allItems as $singleItem) {
                $result++;
                $list .= '<article><span id="marque">'.$singleItem->marque.'</span><span id="modele">'.$singleItem->modele.'</span><span id="annee">'.$singleItem->annee.'</span><span id="hauteur">'.$singleItem->hauteur.'</span><span id="largeur">'.$singleItem->largeur.'</span><span id="diametre">'.$singleItem->diametre.'</span></article>';
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