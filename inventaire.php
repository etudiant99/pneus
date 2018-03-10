<?php
include_once plugin_dir_path( __FILE__ ).'/inventairewidget.php';

class Inventaire{
    const CSS = 'mon.css';
    const LANG = 'some_textdomain';
    
    public function __construct(){
        $ok = wp_register_style('pneus', plugins_url(self::CSS, __FILE__));
        wp_enqueue_style('pneus');
        $ok = wp_register_style('pneus2', plugins_url('jquery.superbox.css', __FILE__));
        wp_enqueue_style( 'pneus2');
        
        $ok = wp_register_script('pneus', get_template_directory_uri().'/jquery.superbox-min.js', array('jquery'));
        wp_enqueue_script('pneus');
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
        add_submenu_page('pneus', 'Automobiles', 'Automobiles', 'manage_options', 'automobiles', array($this, 'menu_automobiles'));
        add_submenu_page('pneus', 'Ajouter', 'Ajouter', 'manage_options', 'ajouter', array($this, 'menu_ajouter'));
        //add_submenu_page('pneus', 'Modifier', 'Modifier', 'manage_options', 'modifier', array($this, 'menu_modifier'));
    }

    public function menu_automobiles()
    {
        global $wpdb;
        $sendback = wp_get_referer();
        $host = $_SERVER['PHP_SELF'];
        //var_dump($host);
        
        $screen = get_current_screen();
        $page = $screen->id;
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inventaire ORDER BY marque,modele", ‘foo’ )) ;
        //var_dump($page);
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <div id="listecomplete">
            <span id="titre_marque">Marque</span>
            <span id="titre_modele2">Modèle</span>
            <span id="titre_annee">Année</span>
            <span id="titre_largeur">Largeur</span>
            <span id="titre_hauteur">Hauteur</span>
            <span id="titre_diametre">Diamètre</span><br /><?php
        foreach ($resultats as &$singleItem) { ?>
            <a href="?page=ajouter&id=<?php echo $singleItem->id; ?>">
                <span id="marque"><?php echo $singleItem->marque; ?></span>
                <span id="modele"><?php echo $singleItem->modele; ?></span>
                <span id="annee"><?php echo $singleItem->annee; ?></span>
                <span id="largeur"><?php echo $singleItem->largeur; ?></span>
                <span id="hauteur"><?php echo $singleItem->hauteur; ?></span>
                <span id="diametre"><?php echo $singleItem->diametre; ?></span><br />
            </a> <?php
        }
    }
    
    public function menu_ajouter()
    {
        global $wpdb;
            $id = '';
            $marque = '';
            $modele = '';
            $annee = '';
            $largeur = '';
            $hauteur = '';
            $diametre = '';
            $titre_bouton = 'Ajouter';
        
        if (isset($_GET['id'])){
            $id = $_GET['id'];
            $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inventaire WHERE id='$id'", ‘foo’ ));

            $marque = $row->marque;
            $modele = $row->modele;
            $annee = $row->annee;
            $largeur = $row->largeur;
            $hauteur = $row->hauteur;
            $diametre = $row->diametre;
            $titre_bouton = 'Modifier';
        }
        
        ?>
        <h1><?php echo $titre_bouton ?></h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <p>
                <label class="exemple" for="marque">Marque :</label>
                <input id="pneus_marque" name="pneus_marque" type="text" value="<?php echo $marque ?>"/>
            </p>
            <p>
                <label class="exemple" for="modele">Modèle :</label>
                <input id="pneus_modele" name="pneus_modele" type="text" value="<?php echo $modele ?>" />
            </p>
            <p>
                <label class="exemple" for="annee">Année :</label>
                <input id="annee" name="annee" type="text" value="<?php echo $annee ?>" />
            </p>
            <p>
                <label class="exemple" for="largeur">Largeur :</label>
                <input id="largeur" name="largeur" type="text" value="<?php echo $largeur ?>" />
            </p>
            <p>
                <label class="exemple" for="hauteur">Hauteur :</label>
                <input id="hauteur" name="hauteur" type="text" value="<?php echo $hauteur ?>" />
            </p>
            <p>
                <label class="exemple" for="diametre">Diamètre :</label>
                <input id="diametre" name="diametre" type="text" value="<?php echo $diametre ?>" />
            </p>

            <input type="submit" name="<?php echo $titre_bouton ?>" value="<?php echo $titre_bouton ?>" style="background-color: lightblue;" />
        </form>
        <br /><br />
        
        <?php
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
            
            if (isset($_POST['Ajouter'])){
                
                $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}inventaire WHERE marque = '$marque' && modele = '$modele'");        
                if (is_null($row))
                    $ok = $wpdb->insert("{$wpdb->prefix}inventaire", array('marque' => $marque, 'modele' => $modele, 'annee' => $annee, 'largeur' => $largeur, 'hauteur' => $hauteur, 'diametre' => $diametre));
            }
            if (isset($_POST['Modifier'])){
                $id = $_POST['id'];
                $ok = $wpdb->update($wpdb->prefix.'inventaire',array('marque' => $marque, 'modele' => $modele, 'annee' => $annee, 'largeur' => $largeur, 'hauteur' => $hauteur, 'diametre' => $diametre),array( 'ID' => $id ),array('%s','%s','%d','%d','%d','%d'),array('%d'));
            }
        }
    }
    
    public function inventaire_results_before_content()
    {
        global $wpdb;
        $result = 0;
    
        if ((isset($_POST['marque']))&&($_POST['marque'] != "")){
            $marque = $_POST['marque'];
            $allItems = $wpdb->get_results("SELECT * FROM wp_inventaire WHERE marque = '$marque' ORDER BY marque,modele");

            ?><div id="box-container">
                <h1 style="padding-left: 10px;">Résultat de la recherche</h1>
                <?php
                if ((isset($_POST['marque']))&&($_POST['marque'] != "")){
                    $marque = $_POST['marque'];
                    $allItems = $wpdb->get_results("SELECT * FROM wp_inventaire WHERE marque = '$marque' ORDER BY marque,modele");
                    
                    // Ecriture du résultat trouvé
                    if (count($allItems) > 0)?>
                        <div id="resultat">
                            <span id="titre_marque">Marque</span>
                            <span id="titre_modele">Modèle</span>
                            <span id="titre_annee">Année</span>
                            <span id="titre_largeur">Largeur</span>
                            <span id="titre_hauteur">Hauteur</span>
                            <span id="titre_diametre">Diamètre</span><br /><?php
                            foreach ($allItems as $singleItem){
                                $result++; ?>
                                <article>
                                    <span id="marque"><?php echo $singleItem->marque ?></span>
                                    <span id="modele"><?php echo $singleItem->modele ?></span>
                                    <span id="annee"><?php echo $singleItem->annee ?></span>
                                    <span id="largeur"><?php echo $singleItem->largeur ?></span>
                                    <span id="hauteur"><?php echo $singleItem->hauteur ?></span>
                                    <span id="diametre"><?php echo $singleItem->diametre ?></span>
                                </article><?php
                            }?>
                         </div>
                    <?php }
         			if ($result == 0)
         			    echo "Aucun résultat pour cette recherche (<b>".$marque."</b>).";
                    ?>
                    </div><?php
        }
    }
}