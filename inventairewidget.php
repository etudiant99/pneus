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
        
        echo $args['before_widget'];
        echo $args['before_title'];
        echo apply_filters('widget_title', $instance['title']);
        echo $args['after_title'];
        
        //Pour le débogage: var_dump($resultats);
        $resultats = $wpdb->get_results($wpdb->prepare("SELECT  DISTINCT marque FROM {$wpdb->prefix}inventaire ORDER BY marque", ‘foo’ )) ;
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
         
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="denis" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo  $title; ?>" />
        </p>
        <?php
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