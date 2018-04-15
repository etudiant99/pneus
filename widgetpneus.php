<?php
class Pneus_Widget extends WP_Widget
{    
    public function __construct()
    {
        parent::__construct('pneus', 'pneus', array('description' => 'Indication de ce sur quoi va un pneu.'));    
        add_action("wp_footer", array($this, 'pneus_results'));
    }
    
    public function widget($args, $instance)
    {    
        global $wpdb;
        
        // Extraction des paramètres du widget
        extract( $args );
        echo $before_widget;
        
        // Récupération de chaque paramètre
        $title = apply_filters('widget_title', $instance['title']);
        
        // On affiche un titre si le paramètre est rempli
        if($title)
            echo $before_title . $title . $after_title;
            
        echo $after_widget;   
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT  DISTINCT pneu FROM {$wpdb->prefix}inventaire ORDER BY pneu", ‘foo’ )) ;
        
        if ($resultats == null)
            echo '<h5>Base de données vide !</h5>';
        else{?>
            <form method="post">
                <p>
                <select  id="pneu" name="pneu" style="width:100%;margin-top:0px;margin-bottom: 10px"><?php
                    foreach ($resultats as &$value) {
                        if (($_POST['pneu']) && $_POST['pneu']== $value->pneu)
                            $selected = "selected";
                        else
                            $selected = "";
                        echo '<option '.$selected.'>'.$value->pneu.'</option>';
                    }?>
                </select>
                </p>
                <div>
                    <input type="submit" value="<?php _e( 'Search','pneus' ); ?>" />
                </div>
            </form><?php
        }
        echo $args['after_widget'];
    }
    
    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : '';?>
        <p>
            <label id="titre_widget" for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:','pneus' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo  $title; ?>" />
        </p><?php
    }

    public function update( $new_instance, $old_instance )
    {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        
        return $instance;
    }
    
    public function pneus_results()
    {    
        global $wpdb;
        $result = 0;
        
        if ((isset($_POST['pneu']))&&($_POST['pneu'] != "")){
            $pneu = $_POST['pneu'];
            $allItems = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}inventaire WHERE pneu = '$pneu' order by annee,marque,modele,letype,options");?>
            
            <div id="box-container">
                <h1 style="padding-left: 10px;"><?php _e('Result of the research', 'pneus') ?></h1><?php
                // Ecriture du résultat trouvé
                if (count($allItems) > 0)?>
                    <div id="resultat">
                        <span id="titre_marque"><?php _e('Brands', 'pneus') ?></span>
                        <span id="titre_modele"><?php _e('Models', 'pneus') ?></span>
                        <span id="titre_annee"><?php _e('Years', 'pneus') ?></span>
                        <span id="titre_type"><?php _e('Types', 'pneus') ?></span>
                        <span id="titre_options"><?php _e('Options', 'pneus') ?></span><?php
                        foreach ($allItems as $singleItem){
                            $result++; ?>
                            <article>
                                <span id="marque"><?php echo $singleItem->marque ?></span>
                                <span id="modele"><?php echo $singleItem->modele ?></span>
                                <span id="annee"><?php echo $singleItem->annee ?></span>
                                <span id="type"><?php echo $singleItem->letype ?></span>
                                <span id="options"><?php echo $singleItem->options ?></span>
                            </article><?php
                        }?>
                    </div><?php
                if ($result == 0)
                    echo "Aucun résultat pour cette recherche.";?>
            </div><?php
        }
    }
}