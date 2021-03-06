<?php
include_once plugin_dir_path( __FILE__ ).'/widgetinventaire.php';
include_once plugin_dir_path( __FILE__ ).'/widgetpneus.php';

class Inventaire{
    
    public function __construct(){
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
        add_action('widgets_init', function(){register_widget('Inventaire_Widget');});
        add_action('widgets_init', function(){register_widget('Pneus_Widget');});
        add_action('admin_menu', array($this, 'add_admin_menu'), 20);
        add_action('wp_loaded', array($this, 'save_infos'));
     }
     /**
      * Register style sheet.
     */
     function register_plugin_styles() {
        wp_register_style( 'pneus', plugins_url( 'pneus/mon.css' ) );
        wp_enqueue_style( 'pneus' );
        }
    /**
     * Pour que quelque chose fonctionne avec ce plugin,
     * il nous faut bien sûr une existence des tables associées à celui-ci
     * Donc, on l'installant, ou en l'activant, on veille à ...
     * l'existence des tables nécessaires à son fonctionement
     * Si ce n'est qu'une simple activation, normalement toutes les tables sont déjà présentes
     * et aucune de nos données entrées précédemment ne sont perdues.
     * 
    */
    public static function install()
    {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inventaire (id INT AUTO_INCREMENT PRIMARY KEY, marque VARCHAR(255), modele VARCHAR(255), annee INT, letype VARCHAR(255), options VARCHAR(255), pneu VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_marque (id INT AUTO_INCREMENT PRIMARY KEY, marque VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_modele (id INT AUTO_INCREMENT PRIMARY KEY, modele VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_annee (id INT AUTO_INCREMENT PRIMARY KEY, annee INT );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_type (id INT AUTO_INCREMENT PRIMARY KEY, type VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_options (id INT AUTO_INCREMENT PRIMARY KEY, options VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_pneus (id INT AUTO_INCREMENT PRIMARY KEY, pneu VARCHAR(255), largeur VARCHAR(255), rapport_aspect VARCHAR(255), diametre FLOAT );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}marque_modele_pneu (id INT AUTO_INCREMENT PRIMARY KEY, marque_id INT, modele_id INT, pneu_id INT );");    
    }

    /**
     * On prend soin d'effacer tous les fichiers
     * que le plugin a pu créer, si on le retire en le supprimant
     * et non pas seulement en le désactivant
     * on voit qu'il n'y a pas de table pour le modèle
     * 
    */
    public static function uninstall()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inventaire;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_marque;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_modele;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_annee;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_type;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_options;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_pneus;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}marque_modele_pneu;");
    }

    /**
     * Simplement une fonction qui ajoute 2 sous-menus
     * "Automibiles" et "Ajouter"
     * 
    */
    public function add_admin_menu()
    {
        
        add_submenu_page('pneus', __( 'Cars','pneus'), __( 'visualization','pneus'), 'manage_options', 'automobiles', array($this, 'sousmenu_automobiles'));
        add_submenu_page('pneus', __( 'Resume','pneus'), __( 'Resum','pneus'), 'manage_options', 'resume', array($this, 'sousmenu_resume'));
        add_submenu_page('pneus', __( 'Historic models','pneus'), __( 'Historic models','pneus'), 'manage_options', 'modeles', array($this, 'sousmenu_modeles'));
        add_submenu_page('pneus', __( 'Historic tires','pneus'), __( 'Historic tires','pneus'), 'manage_options', 'hist_pneus', array($this, 'sousmenu_pneus'));
        add_submenu_page('pneus', __( 'Add','pneus'), __( 'Adds','pneus'), 'manage_options', 'ajout', array($this, 'sousmenu_ajouter'));
        add_submenu_page('pneus', __( 'Add','pneus'),__( 'Various additions','pneus') , 'manage_options', 'ajout_divers', array($this, 'sousmenu_ajout_divers'));
    }
    
    public function sousmenu_resume()
    {
        global $wpdb;
        
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT marque,modele,pneu FROM {$wpdb->prefix}marque_modele_pneu INNER JOIN {$wpdb->prefix}inv_marque ma ON ma.id = marque_id INNER JOIN {$wpdb->prefix}inv_modele mo ON mo.id = modele_id INNER JOIN {$wpdb->prefix}inv_pneus p ON p.id = pneu_id order by marque,modele,pneu", ‘foo’ )) ;
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <!-- Affichage des titres avec debut de la boîte -->
        <div id="titrelisteresume">
            <span id="titre_marque"><?php _e( 'Brand','pneus' ); ?></span>
            <span id="titre_modele2"><?php _e( 'Model','pneus' ); ?></span>
            <span id="titre_pneu"><?php _e( 'Tire','pneus' ); ?></span><br />
        </div>
            
        <!-- Affichage du contenu -->
        <div id="listeresume"><?php
            foreach ($resultats as &$singleItem) {?>
                <span class="span">
                    <span id="marque"><?php echo $singleItem->marque; ?></span>
                    <span id="modele"><?php echo $singleItem->modele; ?></span>
                    <span id="pneu"><?php echo $singleItem->pneu; ?></span><br />
                </span><?php
            }
            ?>
        </div>
        <?php
        /*
        echo '<select>';
        foreach ($resultats as $singleitem){
            echo '<option><column>'.$singleitem->marque.'&nbsp&nbsp&nbsp&nbsp&nbsp</column><column>'.$singleitem->modele.'&nbsp&nbsp&nbsp&nbsp&nbsp</column><column>'.$singleitem->pneu.'</column></option><br />'; 
        }
        echo '</select>';
       */
    }
    /** 
     * La fonction nous permet d'afficher l'ensemble de ce qui est dans l'inventaire
     * Elle va d'abord chercher l'ensemble du contenu de la table principale, pour ensuite l'afficher
     * Par un <a href >, elle pourra transmettre un id, pour une modification éventuelle
    */
    public function sousmenu_automobiles()
    {
        global $wpdb;
        
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inventaire ORDER BY annee,marque,modele", ‘foo’ )) ;
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <!-- Affichage des titres avec debut de la boîte -->
        <div id="titrelistecomplete">
            <span id="titre_marque"><?php _e( 'Brand','pneus' ); ?></span>
            <span id="titre_modele2"><?php _e( 'Model','pneus' ); ?></span>
            <span id="titre_annee"><?php _e( 'Year','pneus' ); ?></span>
            <span id="titre_type"><?php _e( 'Type','pneus' ); ?></span>
            <span id="titre_options"><?php _e( 'Option','pneus' ); ?></span>
            <span id="titre_pneu"><?php _e( 'Tire','pneus' ); ?></span><br />
        </div>
        <div id="listecomplete"><?php
            
        // Affichage du contenu
        foreach ($resultats as &$singleItem) { ?>
            <!-- Le <a href > si important pour la transmission de l'id -->
            <a href="?page=ajout&id=<?php echo $singleItem->id; ?>">
            <span  class="span">
                <span id="marque"><?php echo $singleItem->marque; ?></span>
                <span id="modele"><?php echo $singleItem->modele; ?></span>
                <span id="annee"><?php echo $singleItem->annee; ?></span>
                <span id="type"><?php echo $singleItem->letype; ?></span>
                <span id="options"><?php echo $singleItem->options; ?></span>
                <span id="pneu"><?php echo $singleItem->pneu; ?></span>
            </span>
                <br />
            </a> <?php
        }
        ?> </div> <?php
        // Fin de la boîte pour le contenu affiché
    }

    public function sousmenu_modeles()
    {
        global $wpdb;
        $voitures = $wpdb->get_results($wpdb->prepare("SELECT marque, modele, annee, pneu FROM {$wpdb->prefix}inventaire GROUP BY marque, modele order by annee, marque,modele", ‘foo’ )) ;
        
        ?><h1><?php echo get_admin_page_title(); ?></h1>
          <div id="titrelistemodeles">
            <span id="titre_marque"><?php _e( 'Brand','pneus' ); ?></span>
            <span id="titre_modele2"><?php _e( 'Model','pneus' ); ?></span>
            <span id="titre_annee"><?php _e( 'Year','pneus' ); ?></span>
            <span id="titre_pneu"><?php _e( 'Tire','pneus' ); ?></span>
          </div>
          <div id="listemodeles"><?php
            foreach ($voitures as $singleItem){?>
            <span  class="span">
                <span id="marque"><?php echo $singleItem->marque; ?></span>
                <span id="modele"><?php echo $singleItem->modele; ?></span>
                <span id="annee"><?php echo $singleItem->annee; ?></span>
                <span id="pneu"><?php echo $singleItem->pneu; ?></span>
            </span><br /><?php
            }
          ?></div>
        <?php
    }
    
    public function sousmenu_pneus()
    {
        global $wpdb;
        
        $pneus = $wpdb->get_results($wpdb->prepare("SELECT COUNT(Id) as nb, annee,pneu,marque,modele,letype,options FROM {$wpdb->prefix}inventaire WHERE pneu != '' GROUP BY pneu order by annee", ‘foo’ )) ;
        
        ?><h1><?php echo get_admin_page_title(); ?></h1>
          <div id="titrelistepneus">
            <span id="titre_pneu"><?php _e( 'Tire','pneus' ); ?></span>
            <span id="titre_annee"><?php _e( 'Year','pneus' ); ?></span>
            <span id="titre_marque"><?php _e( 'Brand','pneus' ); ?></span>
            <span id="titre_modele2"><?php _e( 'Model','pneus' ); ?></span>
            <span id="titre_type"><?php _e( 'Type','pneus' ); ?></span>
            <span id="titre_options"><?php _e( 'Total','pneus' ); ?></span>
          </div>
          <div id="listepneus"><?php
            foreach ($pneus as $singleItem){?>
            <span class="span">
                <span id="pneu"><?php echo $singleItem->pneu; ?></span>
                <span id="annee"><?php echo $singleItem->annee; ?></span>  
                <span id="marque"><?php echo $singleItem->marque; ?></span>
                <span id="modele"><?php echo $singleItem->modele; ?></span>
                <span id="type"><?php echo $singleItem->letype; ?></span>
                <span id="options"><?php echo $singleItem->options; ?></span>
                <span id="letotal"><?php echo $singleItem->nb; ?></span>
            </span><br /><?php
            }
          ?></div>
        <?php
    }    
    /**
     * La fonction fait en sorte l' Ajout/Modification
     * Elle récupère les valeurs pour les différents <select>
     * Si c'est une modification l'id nous sera retourné par un $_GET
     * C'est essentiellement le même formulaire qui est affiché
     * Le formulaire retournera la valeur par un "name=" qui aura la valeur appropriée
     * 
    */
    public function sousmenu_ajouter()
    {
        global $wpdb;
        // Avec la table appropriée, on va chercher les infos pour les <select>
        $lesmarques = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_marque order by marque", ‘foo’ )) ;
        $lesmodeles = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_modele order by modele", ‘foo’ )) ;
        $lesannees = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_annee order by annee DESC", ‘foo’ )) ;
        $lestypes = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_type order by type", ‘foo’ )) ;
        $lesoptions = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_options order by options", ‘foo’ )) ;
        $lespneus = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_pneus order by pneu", ‘foo’ )) ;
        
            $id = '';;
            $marque = '';
            $modele = '';
            $annee = '';
            $letype = '';
            $options = '';
            $pneu = '';
            $titre_bouton = __( 'Add','pneus' );
        
        // On s'occupe ici de la modification (avec un id retourné par un GET)
        // Nous pourons ainsi aller chercher la valeur de chacun des champs nécessaires
        if (isset($_GET['id'])){
            $id = $_GET['id'];
            $titre_bouton = __( 'Edit','pneus' );
            $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inventaire WHERE id='$id'", ‘foo’ ));
            $marque = $row->marque;
            $modele = $row->modele;
            $annee = $row->annee;
            $letype = $row->letype;
            $options = $row->options;
            $pneu = $row->pneu;
        }
        
        ?>
        <h1><?php echo $titre_bouton ?></h1>
        <!-- Début du formulaire général (Modification/Ajout) -->
        <!-- Si c'est une modification, on prend soin d'afficher la valeur de départ -->
        <div class="ajouts">
            <form action="" method="post" name="Marque">
                <input type="hidden" name="id" value="<?php echo $id ?>" />
                <p>
                <label class="exemple" for="marque"><?php _e( 'Brand : ','pneus' ); ?></label>
                <!-- Les options pour la marque -->
                <select id="monselect" name="pneus_marque">
                    <option value=""><?php _e( 'Brand','pneus' ); ?></option>
                    <?php
                    foreach ($lesmarques as $item){
                        ?><option  <?php if($item->marque == $marque){echo 'selected="selected"';} ?> value="<?php echo $item->marque; ?>"><?php echo $item->marque; ?></option><?php
                    }
                    ?>
                </select>
                </p>
                <p>
                <label class="exemple" for="modele"><?php _e( 'Model : ','pneus' ); ?></label>
                <!-- Les options pour le modèle -->
                <select id="monselect" name="pneus_modele">
                    <?php
                    foreach ($lesmodeles as $item){
                        ?><option  <?php if($item->modele == $modele){echo 'selected="selected"';} ?> value="<?php echo $item->modele; ?>"><?php echo $item->modele; ?></option><?php
                    }
                    ?>
                </select>
                </p>
                <p>
                <label class="exemple" for="annee"><?php _e( 'Year : ','pneus' ); ?></label>
                <!-- Les options pour l'année -->
                <select id="monselect" name="annee">
                    <?php
                    foreach ($lesannees as $item){
                        ?><option  <?php if($item->annee == $annee){echo 'selected="selected"';} ?> value="<?php echo $item->annee; ?>"><?php echo $item->annee; ?></option><?php
                    }
                    ?>
                </select>
                </p>
                <p>
                <label class="exemple" for="type"><?php _e( 'Type : ','pneus' ); ?></label>
                <!-- Les options pour le type, qui peut avoir une valeur nulle -->
                <select id="monselect" name="letype">
                    <option value=""><?php _e( 'Type','pneus' ); ?></option>
                    <?php
                    foreach ($lestypes as $item){
                        ?><option  <?php if($item->type == $letype){echo 'selected="selected"';} ?> value="<?php echo $item->type; ?>"><?php echo $item->type; ?></option><?php
                    }
                    ?>
                </select>
                </p>
                <p>
                <label class="exemple" for="type"><?php _e( 'Option :','pneus' ); ?></label>
                <!-- Les options pour les options du véhicule, qui peut avoir une valeur nulle -->
                <select id="monselect" name="options">
                    <option value=""><?php _e( 'Options','pneus' ); ?></option>
                    <?php
                    foreach ($lesoptions as $item){
                        ?><option  <?php if($item->options == $options){echo 'selected="selected"';} ?> value="<?php echo $item->options; ?>"><?php echo $item->options; ?></option><?php
                    }
                    ?>
                </select>
                </p>
                <p>
                <label class="exemple" for="pneu"><?php _e( 'Tire :','pneus' ); ?></label>
                <!-- Les options pour le pneu, qui peut avoir une valeur nulle -->
                <select id="monselect" name="pneu">
                    <option value=""><?php _e( 'Tire','pneus' ); ?></option>
                    <?php
                    foreach ($lespneus as $item){
                        ?><option  <?php if($item->pneu == $pneu){echo 'selected="selected"';} ?> value="<?php echo $item->pneu; ?>"><?php echo $item->pneu; ?></option><?php
                    }
                    ?>
                </select>
                </p>

                <!-- Le bouton qui affichera la valeur de $titre_bouton (Ajouter/Modifier) -->
                <!-- Il aura aussi la valeur de $titre_bouton -->
                <input type="submit" name="<?php echo $titre_bouton ?>" value="<?php echo $titre_bouton ?>" style="background-color: lightblue;" />
            <!-- Fin du formulaire général -->
            </form>
        </div>
        <br /><br />
        <?php
    }

    public function sousmenu_ajout_divers()
    {
        global $wpdb;
        
        if (isset($_POST['marqueChoix'])){
            $nouvelle_marque = $_POST['marqueChoix'];
            $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_marque WHERE marque ='$nouvelle_marque'", ‘foo’ ));
            if ($row == null)
                $wpdb->insert("{$wpdb->prefix}inv_marque", array('marque' => $nouvelle_marque));
        }
        if (isset($_POST['modeleChoix'])){
            $nouveau_modele = $_POST['modeleChoix'];
            $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_modele WHERE modele ='$nouveau_modele'", ‘foo’ ));
            if ($row == null)
                $wpdb->insert("{$wpdb->prefix}inv_modele", array('modele' => $nouveau_modele));
        }
        if (isset($_POST['anneeChoix'])){
            $nouvelle_annee = $_POST['anneeChoix'];
            $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_annee WHERE annee ='$nouvelle_annee'", ‘foo’ ));
            if ($row == null)
                $wpdb->insert("{$wpdb->prefix}inv_annee", array('annee' => $nouvelle_annee));
        }
        if (isset($_POST['typeChoix'])){
            $nouveau_type = $_POST['typeChoix'];
            $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_type WHERE type ='$nouveau_type'", ‘foo’ ));
            if ($row == null)
                $wpdb->insert("{$wpdb->prefix}inv_type", array('type' => $nouveau_type));
        }
        if (isset($_POST['optionsChoix'])){
            $nouvelle_option = $_POST['optionsChoix'];
            $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_options WHERE options ='$nouvelle_option'", ‘foo’ ));
            if ($row == null)
                $wpdb->insert("{$wpdb->prefix}inv_options", array('options' => $nouvelle_option));
        }
        if (isset($_POST['pneuChoix'])){
            $nouveau_pneu = $_POST['pneuChoix'];
            $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_pneus WHERE pneu ='$nouveau_pneu'", ‘foo’ ));
            if ($row == null)
                $wpdb->insert("{$wpdb->prefix}inv_pneus", array('pneu' => $nouveau_pneu));
        }
        ?>
        <h1><?php _e('Various additions', 'pneus') ?></h1><br />
        <div class="monrow">
            <div class="moncol-sm-3">
                <div class="ajouts">
                    <form method="post">
                        <p>
                            <label class="exemple" for="marque"><h3><?php _e('Brand :', 'pneus') ?></h3></label>
                            <input id="pneus_marque" name="marqueChoix" type="text" required="required" />
                        </p>
                    <input type="submit" name="Ajouter" value="<?php _e('Add', 'pneus') ?>" style="background-color: lightblue;" />
                    </form>
                </div>
            </div>
            <div class="moncol-sm-3">
                <div class="ajouts">
                    <form method="post">
                        <p>
                            <label class="exemple" for="modele"><h3><?php _e('Model :', 'pneus') ?></h3></label>
                            <input id="pneus_modele" name="modeleChoix" type="text" required="required" />
                        </p>
                    <input type="submit" name="Ajouter" value="<?php _e('Add', 'pneus') ?>" style="background-color: lightblue;" />
                    </form>
                </div>
            </div>
            <div class="moncol-sm-3">
                <div class="ajouts">
                    <form method="post">
                        <p>
                            <label class="exemple" for="annee"><h3><?php _e('Year :', 'pneus') ?></h3></label>
                            <input id="annee" name="anneeChoix" type="text" required="required" />
                        </p>
                        <input type="submit" name="Ajouter" value="<?php _e('Add', 'pneus') ?>" style="background-color: lightblue;" />
                    </form>
                </div>
            </div>
        </div><br />
        <br />
        <div class="monrow">
            <div class="moncol-sm-3">
                <div class="ajouts">
                    <form method="post">
                        <p>
                            <label class="exemple" for="type"><h3><?php _e('Type :', 'pneus') ?></h3></label>
                            <input id="type" name="typeChoix" type="text" required="required" />
                        </p>
                        <input type="submit" name="Ajouter" value="<?php _e('Add', 'pneus') ?>" style="background-color: lightblue;" />
                    </form>
                </div>
            </div>
            <div class="moncol-sm-3">
                <div class="ajouts">
                    <form method="post">
                        <p>
                            <label class="exemple" for="type"><h3><?php _e('Options :', 'pneus') ?></h3></label>
                            <input id="type" name="optionsChoix" type="text" required="required" />
                        </p>
                        <input type="submit" name="Ajouter" value="<?php _e('Add', 'pneus') ?>" style="background-color: lightblue;" />
                    </form>
                </div>
            </div>
            <div class="moncol-sm-3">
                <div class="ajouts">
                    <form method="post">
                        <p>
                            <label class="exemple" for="type"><h3><?php _e('Tire :', 'pneus') ?></h3></label>
                            <input id="type" name="pneuChoix" type="text" required="required" />
                        </p>
                        <input type="submit" name="Ajouter" value="<?php _e('Add', 'pneus') ?>" style="background-color: lightblue;" />
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    /**
     * La fonction vérifie toujours les $_POST
     * Elle en a besoin pour ajouter & modifier)
     * S'il y en a pas, elle n'a absolument rien à faire
     * Dépendament de la valeur du $_POST, elle fera un Ajout/Modification
    */
    public function save_infos()
    {
        global $wpdb;
        
        if (isset($_POST['pneus_marque']) && !empty($_POST['pneus_marque'])) { 
            $marque = $_POST['pneus_marque'];
            $modele = $_POST['pneus_modele'];
            $annee = $_POST['annee'];
            $letype = $_POST['letype'];
            $options = $_POST['options'];
            $pneu = $_POST['pneu'];
            // mise à jour particulier d'un fichier
            if ($pneu |= ''){
                $id_marque = $row = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_marque WHERE marque ='$marque'", ‘foo’ ));
                $id_modele = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_modele WHERE modele ='$modele'", ‘foo’ ));
                $id_pneu = $wpdb->get_row($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inv_pneus WHERE pneu ='$pneu'", ‘foo’ ));
                
                $row = $wpdb->get_row($wpdb->prepare("SELECT ma.marque, mo.modele, p.pneu FROM {$wpdb->prefix}inv_marque ma INNER JOIN {$wpdb->prefix}inv_modele mo INNER JOIN {$wpdb->prefix}marque_modele_pneu li INNER JOIN {$wpdb->prefix}inv_pneus p ON (li.marque_id=ma.id and li.modele_id=mo.id and li.pneu_id=p.id) where li.marque_id=$id_marque->id and li.modele_id=$id_modele->id and li.pneu_id=$id_pneu->id", ‘foo’ )) ;
                if ($row == null)
                    $wpdb->insert("{$wpdb->prefix}marque_modele_pneu", array('marque_id' => $id_marque->id, 'modele_id' => $id_modele->id, 'pneu_id' => $id_pneu->id));
            }

            // Si le label du bouton est Ajouter, alors c'est un INSERT
            if (isset($_POST['Ajouter']))
                $wpdb->insert("{$wpdb->prefix}inventaire", array('marque' => $marque, 'modele' => $modele, 'annee' => $annee, 'letype' => $letype, 'options' => $options, 'pneu' => $pneu));
            
            // Si le label du bouton est Ajouter, alors c'est un UPDATE
            if (isset($_POST['Modifier'])){
                $id = $_POST['id'];
                $wpdb->update($wpdb->prefix.'inventaire',array('marque' => $marque, 'modele' => $modele, 'annee' => $annee, 'letype' => $letype, 'options' => $options, 'pneu' => $pneu),array( 'ID' => $id ),array('%s','%s','%d','%s','%s','%s'),array('%d'));
            }
        }
    }
  
}