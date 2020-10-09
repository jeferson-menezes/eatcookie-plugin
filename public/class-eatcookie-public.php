<?php

class EatcookiePublic {

    private $plugin_name;

    private $version;

    public function __construct( $plugin_name, $version ) {
		    $this->plugin_name = $plugin_name;
		    $this->version = $version;
    }
    
    public function enqueueStyles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/eatcookie-public.css', array(), $this->version, 'all' );
    }

    public function enqueueScripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/eatcookie-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'jecArgsAlert', array('ajaxUrl' => admin_url('admin-ajax.php'), 'value'=>'Zion'));
	}

    public function render_template_alerta($the_Post) {
        if ($this->existeRegistro()) {
            return $the_Post;
        } else {
            $ec_text = get_option( 'ec_texto' );
            $ec_link_policy =  get_option( 'ec_link_pagina_politica' );
            $ec_texto_police = get_option('ec_texto_pagina_politica');
            $ec_button_aceito = get_option( 'ec_button_aceito' );
            $ec_button_recusa = get_option( 'ec_button_recusa' );
            $ec_position = get_option('ec_possicao_notificacao' );
            $ec_buttons_bg = get_option( 'ec_buttons_bg' );
            $ec_buttons_color = get_option( 'ec_buttons_color' );
            $ec_text_color = get_option( 'ec_text_color' );
            $ec_text_bg = get_option( 'ec_text_bg' );
            
            $the_New_Post = "<div id='eatcookie-alert' class='ea-$ec_position' style='background:$ec_text_bg ;'>";
            $the_New_Post = $the_New_Post . "<div class='eatcookie-alert-container'>";
            $the_New_Post = $the_New_Post . "<span class='ea-alert-text' style='color: $ec_text_color;'> $ec_text </span>";
            $the_New_Post = $the_New_Post . "<span class='ea-alert-buttons'>";
            $the_New_Post = $the_New_Post . "<a href='#' id='ea-accept-cookie' class='ea-button' style='background:$ec_buttons_bg ; color: $ec_buttons_color;'>$ec_button_aceito</a>";
            
            if (!empty($ec_button_recusa)) {
              $the_New_Post = $the_New_Post . "<a href='#' id='ea-refuse-cookie' class='ea-button' style='background:$ec_buttons_bg ; color: $ec_buttons_color;' >$ec_button_recusa</a>";
            }
            
            if (!empty($ec_link_policy) && !empty($ec_link_policy)) {
              $the_New_Post = $the_New_Post . " <a href='$ec_link_policy' target='_about' class='ea-button' style='background:$ec_buttons_bg ; color: $ec_buttons_color;'>$ec_texto_police</a>";
            }
            $the_New_Post = $the_New_Post . "</span></div></div>";
            
            return $the_New_Post . $the_Post;
        }
    }

    private function existeRegistro(){
        global $wpdb;
        $table_name = $wpdb->prefix. TABLE_NAME_EATCOOKIE_LOG;
        $ip = EatcookieHelper::getIpCliente();
        $sql = "SELECT * FROM $table_name WHERE address = '$ip'";

        $results = $wpdb->get_row($sql);
        return $results !== null;
    }

}
?>