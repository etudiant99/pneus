<?php
include_once plugin_dir_path( __FILE__ ).'/inventairewidget.php';
include_once plugin_dir_path( __FILE__ ).'/pneuswidget.php';

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
        add_action('widgets_init', function(){register_widget('Pneus_Widget');});
        add_action('admin_menu', array($this, 'add_admin_menu'), 20);
        add_action('wp_loaded', array($this, 'save_infos'));
     }

    public static function install()
    {
        global $wpdb;
        
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inventaire (id INT AUTO_INCREMENT PRIMARY KEY, marque VARCHAR(255), modele VARCHAR(255), annee INT, pneu VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_pneus (id INT AUTO_INCREMENT PRIMARY KEY, pneu VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_marque (id INT AUTO_INCREMENT PRIMARY KEY, marque VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_annee (id INT AUTO_INCREMENT PRIMARY KEY, annee INT );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_type (id INT AUTO_INCREMENT PRIMARY KEY, type VARCHAR(255) );");
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}inv_options (id INT AUTO_INCREMENT PRIMARY KEY, options VARCHAR(255) );");
    }

    public static function uninstall()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inventaire;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_pneus;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_marque;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_annee;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_type;");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}inv_options;");
    }

    public function add_admin_menu()
    {
        add_submenu_page('pneus', 'Automobiles', 'Automobiles', 'manage_options', 'automobiles', array($this, 'menu_automobiles'));
        add_submenu_page('pneus', 'Ajouter', 'Ajouter', 'manage_options', 'ajouter', array($this, 'menu_ajouter'));
    }

    public function menu_automobiles()
    {
        global $wpdb;
        $sendback = wp_get_referer();
        $host = $_SERVER['PHP_SELF'];
        
        $screen = get_current_screen();
        $page = $screen->id;
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT  * FROM {$wpdb->prefix}inventaire ORDER BY annee,marque,modele", ‘foo’ )) ;
        
        ?>
        <h1><?php echo get_admin_page_title(); ?></h1>
        <div id="listecomplete">
            <span id="titre_marque">Marque</span>
            <span id="titre_modele2">Modèle</span>
            <span id="titre_annee">Année</span>
            <span id="titre_type">Type</span>
            <span id="titre_options">Options</span>
            <span id="titre_pneu">Pneu</span><br /><?php
            
        foreach ($resultats as &$singleItem) { ?>
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
    }
    
    public function menu_ajouter()
    {
        global $wpdb;
        $lesmarques = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_marque order by marque", ‘foo’ )) ;
        $lespneus = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_pneus order by pneu", ‘foo’ )) ;
        $lesannees = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_annee order by annee DESC", ‘foo’ )) ;
        $lestypes = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_type order by type", ‘foo’ )) ;
        $lesoptions = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}inv_options order by options", ‘foo’ )) ;
        
            $id = '';;
            $marque = '';
            $modele = '';
            $annee = '';
            $letype = '';
            $options = '';
            $pneu = '';
            $titre_bouton = 'Ajouter';
        
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
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <p>
                <label class="exemple" for="marque">Marque :</label>
                <select id="monselect" name="pneus_marque">
                    <?php
                    foreach ($lesmarques as $item){
                        ?>
                        <option  <?php if($item->marque == $marque){echo 'selected="selected"';} ?> value="<?php echo $item->marque; ?>"><?php echo $item->marque; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </p>
            <p>
                <label class="exemple" for="modele">Modèle :</label>
                <input id="pneus_modele" name="pneus_modele" type="text" value="<?php echo $modele ?>" />
            </p>
            <p>
                <label class="exemple" for="annee">Année :</label>
                <select id="monselect" name="annee">
                    <?php
                    foreach ($lesannees as $item){
                        ?>
                        <option  <?php if($item->annee == $annee){echo 'selected="selected"';} ?> value="<?php echo $item->annee; ?>"><?php echo $item->annee; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </p>
            <p>
                <label class="exemple" for="type">Type :</label>
                <select id="monselect" name="letype">
                    <option value="">Type</option>
                    <?php
                    foreach ($lestypes as $item){
                        ?>
                        <option  <?php if($item->type == $letype){echo 'selected="selected"';} ?> value="<?php echo $item->type; ?>"><?php echo $item->type; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </p>
            <p>
                <label class="exemple" for="type">Oprions :</label>
                <select id="monselect" name="options">
                    <option value="">Options</option>
                    <?php
                    foreach ($lesoptions as $item){
                        ?>
                        <option  <?php if($item->options == $options){echo 'selected="selected"';} ?> value="<?php echo $item->options; ?>"><?php echo $item->options; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </p>
            <p>
                <label class="exemple" for="pneu">Pneu :</label>
                <select id="monselect" name="pneu">
                    <option value="">Pneu</option>
                    <?php
                    foreach ($lespneus as $item){
                        ?>
                        <option  <?php if($item->pneu == $pneu){echo 'selected="selected"';} ?> value="<?php echo $item->pneu; ?>"><?php echo $item->pneu; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </p>

            <input type="submit" name="<?php echo $titre_bouton ?>" value="<?php echo $titre_bouton ?>" style="background-color: lightblue;" />
        </form>
        <br /><br />
        
        <?php
    }

    public function save_infos()
    {
        if (isset($_POST['pneus_marque']) && !empty($_POST['pneus_marque'])) {
            global $wpdb;
            $marque = $_POST['pneus_marque'];
            $modele = $_POST['pneus_modele'];
            $annee = $_POST['annee'];
            $letype = $_POST['letype'];
            $options = $_POST['options'];
            $pneu = $_POST['pneu'];

            if (isset($_POST['Ajouter'])){
                $row = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}inventaire WHERE marque = '$marque' && modele = '$modele'");        
                $ok = $wpdb->insert("{$wpdb->prefix}inventaire", array('marque' => $marque, 'modele' => $modele, 'annee' => $annee, 'letype' => $letype, 'options' => $options, 'pneu' => $pneu));
            }
            if (isset($_POST['Modifier'])){
                $id = $_POST['id'];
                $ok = $wpdb->update($wpdb->prefix.'inventaire',array('marque' => $marque, 'modele' => $modele, 'annee' => $annee, 'letype' => $letype, 'options' => $options, 'pneu' => $pneu),array( 'ID' => $id ),array('%s','%s','%d','%s','%s','%s'),array('%d'));
            }
        }
    }
    
    public function inventaire_results_before_content()
    {
        global $wpdb;
        $result = 0;
    
        if ((isset($_POST['marque']))&&($_POST['marque'] != "")){
            $marque = $_POST['marque'];
            $allItems = $wpdb->get_results("SELECT * FROM wp_inventaire WHERE marque = '$marque' ORDER BY marque,annee,modele");

            ?><div id="box-container">
                <h1 style="padding-left: 10px;">Résultat de la recherche</h1>
                <?php
                if ((isset($_POST['marque']))&&($_POST['marque'] != "")){
                    $marque = $_POST['marque'];
                    $allItems = $wpdb->get_results("SELECT * FROM wp_inventaire WHERE marque = '$marque' ORDER BY marque,annee,modele");
                    
                    // Ecriture du résultat trouvé
                    if (count($allItems) > 0)?>
                        <div id="resultat">
                            <span id="titre_marque">Marque</span>
                            <span id="titre_modele">Modèle</span>
                            <span id="titre_annee">Année</span>
                            <span id="titre_type">Type</span>
                            <span id="titre_options">Options</span>
                            <span id="titre_pneu">Pneu</span><?php
                            foreach ($allItems as $singleItem){
                                $result++; ?>
                                <article>
                                    <span id="marque"><?php echo $singleItem->marque ?></span>
                                    <span id="modele"><?php echo $singleItem->modele ?></span>
                                    <span id="annee"><?php echo $singleItem->annee ?></span>
                                    <span id="type"><?php echo $singleItem->letype ?></span>
                                    <span id="options"><?php echo $singleItem->options ?></span>
                                    <span id="pneu"><?php echo $singleItem->pneu ?></span>
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