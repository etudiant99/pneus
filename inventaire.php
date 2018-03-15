<?php
include_once plugin_dir_path( __FILE__ ).'/widgetinventaire.php';
include_once plugin_dir_path( __FILE__ ).'/widgetpneus.php';

class Inventaire{
    const CSS = 'mon.css';
    
    public function __construct(){
        wp_register_style('pneus', plugins_url(self::CSS, __FILE__));
        wp_enqueue_style('pneus');
        add_action('widgets_init', function(){register_widget('Inventaire_Widget');});
        add_action('widgets_init', function(){register_widget('Pneus_Widget');});
        add_action('admin_menu', array($this, 'add_admin_menu'), 20);
        add_action('wp_loaded', array($this, 'save_infos'));
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
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_annee (id INT AUTO_INCREMENT PRIMARY KEY, annee INT );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_type (id INT AUTO_INCREMENT PRIMARY KEY, type VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_options (id INT AUTO_INCREMENT PRIMARY KEY, options VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_pneus (id INT AUTO_INCREMENT PRIMARY KEY, pneu VARCHAR(255), largeur VARCHAR(255), rapport_aspect VARCHAR(255), diametre FLOAT );");        
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
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_annee;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_type;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_options;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_pneus;");
    }

    /**
     * Simplement une fonction qui ajoute 2 sous-menus
     * "Automibiles" et "Ajouter"
     * 
    */
    public function add_admin_menu()
    {
        add_submenu_page('pneus', 'Automobiles', 'Automobiles', 'manage_options', 'automobiles', array($this, 'menu_automobiles'));
        add_submenu_page('pneus', 'Ajouter', 'Ajouter', 'manage_options', 'ajouter', array($this, 'menu_ajouter'));
    }

    /**
     * La fonction nous permet d'afficher l'ensemble de ce qui est dans l'inventaire
     * Elle va d'abord chercher l'ensemble du contenu de la table principale, pour ensuite l'afficher
     * Par un <a href >, elle pourra transmettre un id, pour une modification éventuelle
    */
    public function menu_automobiles()
    {
        global $wpdb;
        
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inventaire ORDER BY annee,marque,modele", ‘foo’ )) ;
        
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <!-- Affichage des titres avec debut de la boîte -->
        <div id="listecomplete">
            <span id="titre_marque">Marque</span>
            <span id="titre_modele2">Modèle</span>
            <span id="titre_annee">Année</span>
            <span id="titre_type">Type</span>
            <span id="titre_options">Options</span>
            <span id="titre_pneu">Pneu</span><br /><?php
            
        // Affichage du contenu
        foreach ($resultats as &$singleItem) { ?>
            <!-- Le <a href > si important pour la transmission de l'id -->
            <a href="?page=ajouter&id=<?php echo $singleItem->id; ?>">
                <span id="marque"><?php echo $singleItem->marque; ?></span>
                <span id="modele"><?php echo $singleItem->modele; ?></span>
                <span id="annee"><?php echo $singleItem->annee; ?></span>
                <span id="type"><?php echo $singleItem->letype; ?></span>
                <span id="options"><?php echo $singleItem->options; ?></span>
                <span id="pneu"><?php echo $singleItem->pneu; ?></span>
                <br />
            </a> <?php
        }
        ?> </div> <?php
        // Fin de la boîte pour le contenu affiché
    }
    
    /**
     * La fonction fait en sorte l' Ajout/Modification
     * Elle récupère les valeurs pour les différents <select>
     * Si c'est une modification l'id nous sera retourné par un $_GET
     * C'est essentiellement le même formulaire qui est affiché
     * Le formulaire retournera la valeur par un "name=" qui aura la valeur appropriée
     * 
    */
    public function menu_ajouter()
    {
        global $wpdb;
        // Avec la table appropriée, on va chercher les infos pour les <select>
        $lesmarques = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_marque order by marque", ‘foo’ )) ;
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
            $titre_bouton = 'Ajouter';
        
        // On s'occupe ici de la modification (avec un id retourné par un GET)
        // Nous pourons ainsi aller chercher la valeur de chacun des champs nécessaires
        if (isset($_GET['id'])){
            $id = $_GET['id'];
            $titre_bouton = 'Modifier';
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
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <p>
            <label class="exemple" for="marque">Marque :</label>
            <!-- Les options pour la marque -->
            <select id="monselect" name="pneus_marque">
                <?php
                foreach ($lesmarques as $item){
                    ?><option  <?php if($item->marque == $marque){echo 'selected="selected"';} ?> value="<?php echo $item->marque; ?>"><?php echo $item->marque; ?></option><?php
                }
                ?>
            </select>
            </p>
            <!-- Pour le modèle, on entre à la main -->
            <p>
                <label class="exemple" for="modele">Modèle :</label>
                <input id="pneus_modele" name="pneus_modele" type="text" value="<?php echo $modele ?>" />
            </p>
            <p>
            <label class="exemple" for="annee">Année :</label>
            <!-- Les options pour le modèle -->
            <select id="monselect" name="annee">
                <?php
                foreach ($lesannees as $item){
                    ?><option  <?php if($item->annee == $annee){echo 'selected="selected"';} ?> value="<?php echo $item->annee; ?>"><?php echo $item->annee; ?></option><?php
                }
                ?>
            </select>
            </p>
            <p>
            <label class="exemple" for="type">Type :</label>
            <!-- Les options pour le type, qui peut avoir une valeur nulle -->
            <select id="monselect" name="letype">
                <option value="">Type</option>
                <?php
                foreach ($lestypes as $item){
                    ?><option  <?php if($item->type == $letype){echo 'selected="selected"';} ?> value="<?php echo $item->type; ?>"><?php echo $item->type; ?></option><?php
                }
                ?>
            </select>
            </p>
            <p>
            <label class="exemple" for="type">Oprions :</label>
            <!-- Les options pour les options du véhicule, qui peut avoir une valeur nulle -->
            <select id="monselect" name="options">
                <option value="">Options</option>
                <?php
                foreach ($lesoptions as $item){
                    ?><option  <?php if($item->options == $options){echo 'selected="selected"';} ?> value="<?php echo $item->options; ?>"><?php echo $item->options; ?></option><?php
                }
                ?>
            </select>
            </p>
            <p>
            <label class="exemple" for="pneu">Pneu :</label>
            <!-- Les options pour le pneu, qui peut avoir une valeur nulle -->
            <select id="monselect" name="pneu">
                <option value="">Pneu</option>
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
        <br /><br />
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