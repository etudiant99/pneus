<?php
class Inventaire_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('inventaire', 'inventaire', array('description' => 'Inventaire des différents pneus.'));
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
        
        //Pour le débogage: var_dump($resultats);
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT  DISTINCT marque FROM {$wpdb->prefix}inventaire ORDER BY marque,annee,modele", ‘foo’ )) ;
        
        if ($resultats == null){
            echo '<h5>Base de données vide !</h5>';
        }
        else{
        ?>
        <form method="post">
            <p>
		      <label>Marque :</label>
              <select  id="marque" name="marque" style="width:100%;margin-top:0px;margin-bottom: 10px">
                <?php
                foreach ($resultats as &$value) {
                    if (($_POST['marque']) && $_POST['marque']== $value->marque)
                        $selected = "selected";
                    else
                        $selected = "";
                    echo '<option '.$selected.'>'.$value->marque.'</option>';
                }
                ?>
              </select>
            </p>
            <div>
                <input type="submit" value="Recherche" />
            </div>
        </form>
        <?php
        }
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label id="titre_widget" for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo  $title; ?>" />
        </p>
        <?php
    }
    
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        
        return $instance;
    }
    
    public function find_infos()
    {
        if (isset($_GET['marque']) && !empty($_GET['marque'])) {
            global $wpdb;
            $marque = $_GET['marque'];

            $allItems = $wpdb->get_results("SELECT * FROM wp_inventaire WHERE marque = '$marque'");
            
            return $allItems;
        }
        return true;
    }
    
    
}