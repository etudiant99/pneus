function submit_me(){
    jQuery.post(the_ajax_script.ajaxurl, jQuery("#theForm").serialize(),

    function(response_from_the_action_function){
        var id = document.getElementById('theForm');
        jQuery(id).html(response_from_the_action_function);
    }
);
}