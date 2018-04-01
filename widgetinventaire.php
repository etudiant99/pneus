<?php
class Inventaire_Widget extends WP_Widget
{
	public function __construct() {
		parent::__construct(
			'Inventaire',
			__( 'inventaire', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
                'description' => 'Inventaire des différents pneus.',
			)
		);
        add_action("wp_footer", array($this, 'voitures_results'));
	}
    /**
     * La fonction affiche un formulaire demandant le titre,
     * lorsque nous sélectionnant le widget pour l'afficher.
    */
    public function form($instance)
    {
		// Valeurs par défaut
		$defaults = array(
			'title'    => 'Automobiles',
            'select'   => 'annee',
		);
        
        extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>
        
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Titre du Widget', 'text_domain' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	   </p>

        <?php
    }
    /**
     * la fonction enregistre le titre entré lorsque l'on installe le widget
     * 
    */
    public function update( $new_instance, $old_instance )
    {
        $instance = $old_instance;
        $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        return $instance;
    }
    /**
     * la fonction affiche un formulaire
     * qui permet d'entrer l'année, la marque, et le modèle du véhicule
     * pour lequel nous voulons effectuer une recherche de pneu.
     * Elle appelle ensuite la fonction "voitures_results()" pour un affichage de ce qui est trouvé
     * 
    */
    public function widget($args, $instance)
    {
        global $wpdb;
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT  DISTINCT marque FROM {$wpdb->prefix}inventaire ORDER BY marque,annee,modele", ‘foo’ )) ;
        $resultatsannees = $wpdb->get_results($wpdb->prepare("SELECT  DISTINCT annee FROM {$wpdb->prefix}inventaire ORDER BY annee DESC", ‘foo’ )) ;
        
        // Extraction des paramètres du widget
        extract( $args );
        
        // Vérifiez les options du widget
        $title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
        
        // WordPress core before_widget hook (toujours inclure)
        echo $before_widget;
        
        // Afficher le widget
        // Display widget title if defined
        if ( $title )
            echo $before_title . $title . $after_title;

        if ($resultats == null)
            echo '<h5>Base de données vide !</h5>';
        else{?>
            <form method="post">
                <p>
                <label>Année :</label>
                <select  id="annee" name="annee" >
                    <option value="Toutes">Toutes</option><?php
                    // Faites défiler les options et ajoutez-les à la liste déroulante
                    foreach ($resultatsannees as &$value) {
                        if (($_POST['annee']) && $_POST['annee']== $value->annee)
                            $selected = "selected";
                        else
                            $selected = "";
                        echo '<option '.$selected.'>'.$value->annee.'</option>';
                    }?>
                </select>
                </p>
                <p>
                <label>Marque :</label><?php
                if ($_POST['marque'])
                    $valeurmarque = $_POST['marque'];
                else
                    $valeurmarque = "";?>
                <input type="text" required="required" id="marque" name="marque" value="<?php echo $valeurmarque ?>" />
                </p>
                <p>
                <label>Modèle :</label><?php
                if ($_POST['modele'])
                    $valeurmodele = $_POST['modele'];
                else
                    $valeurmodele = "";?>
                <input type="text" id="modele" name="modele" value="<?php echo $valeurmodele ?>" />
                </p>
                <div>
                    <input type="submit" name="recherche" value="Recherche" />
                </div>
            </form><?php
        }
        // WordPress core after_widget hook (toujours inclure)
        echo $after_widget;
    }
    /**
     * La fonction récupère les différents $_POST
     * Elle vérifie si ce qui a été entré pour la marque existe, et ajuste possiblement le message d'erreur
     * Elle fait une recherche avec toutes les informations entrées
     * Elle affiche ensuite ce qui a été trouvé
     * Si rien n'a été trouvé, un message approprié est affiché
    */
    public function voitures_results()
    {
        global $wpdb;
        $result = 0;
            
        if (isset($_POST['recherche'])){
            $annee = $_POST['annee'];
            $marque = $_POST['marque'];
            $modele = $_POST['modele'];
            $row_marque = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}inv_marque WHERE marque LIKE '%$marque%'");
            if ($annee == 'Toutes')
            {
                if ($modele == '')
                    $allItems = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}inventaire WHERE marque LIKE '%$marque%' order by annee,modele, letype, options");
                else
                    $allItems = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}inventaire WHERE marque LIKE '%$marque%' and modele LIKE '%$modele%' order by annee,modele, letype, options");
            }  
            else
                if ($modele == '')
                    $allItems = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}inventaire WHERE annee='$annee' and marque LIKE '%$marque%' order by modele, letype, options");
                else
                    $allItems = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}inventaire WHERE annee='$annee' and marque LIKE '%$marque%' and modele LIKE '%$modele%' order by modele, letype, options");
                
            $erreur = 'Malheureusement, aucun résultat trouvé';
            if ($row_marque == null)
                $erreur = 'Erreur dans la marque entrée';
            $max = sizeof($allItems);?>
            
            <div id="box-widget-inventaire">
                <h1 style="padding-left: 10px;">Résultat de la recherche</h1><?php                    
                // Ecriture du résultat trouvé
                if (sizeof($allItems) > 0){?>
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
                    <?php
                    }
                }
                if ($result == 0)
                    echo '<span id="rien">'.$erreur.'</span>'?>
            </div><?php
        }
}