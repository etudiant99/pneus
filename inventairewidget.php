<?php
class Inventaire_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('inventaire', 'inventaire', array('description' => 'Inventaire des différents pneus.'));
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        echo $args['before_title'];
        echo apply_filters('widget_title', $instance['title']);
        echo $args['after_title'];
        
        ?>
        <form method="post">
            <div>
                <p><input type="search" id="marque" name="marque"  placeholder="Marque automobile" /></p>
                <input type="submit" value="Lancer la recherche" />
            </div>
        </form>
        <?php
         
        echo $args['after_widget'];
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