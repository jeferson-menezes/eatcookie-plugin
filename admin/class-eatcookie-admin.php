<?php

class EatcookieAdmin {

    private $plugin_name;

    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action( 'admin_menu', array($this, 'addPluginAdminMenu'), 9);
        add_action( 'admin_init', array($this, 'registerAndBuildFields'));
    }

    public function jec_custon_tarefa_dia($schedules) {
        $schedules['1dia'] = array(
            'interval' => 86400,
            'display' => __('1 Dia', 'jec_long_domain')
        );
        return $schedules;
    }
    // public function enqueue_styles() {
	// 	wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/eatcookie-admin.css', array(), $this->version, 'all' );
    // }

    // public function enqueue_scripts() {
	// 	wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/eatcookie-admin.js', array( 'jquery' ), $this->version, false );
	// }
    
    public function addPluginAdminMenu(){
        add_menu_page(  
            $this->plugin_name, 
            'Eatcookie', 
            'administrator', 
            $this->plugin_name, 
            array( $this, 'displayPluginAdminDashboard' ), 
            'dashicons-drumstick', 
            26 );
		
		//add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
        add_submenu_page( $this->plugin_name, 
            'Eatcookies Navigation Settings', 
            'Configurações',
            'administrator', 
            $this->plugin_name.'-settings', 
            array( $this, 'displayPluginAdminSettings' ));
    }

    public function displayPluginAdminDashboard() {
        require_once 'partials/eatcookie-pagina-display.php';
    }

    public function displayPluginAdminSettings(){
        $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
		if(isset($_GET['error_message'])){
			add_action('admin_notices', array($this,'settingsPageSettingsMessages'));
			do_action( 'admin_notices', $_GET['error_message'] );
		}
		require_once 'partials/eatcookie-pagina-configuracao.php';
    }

    public function settingsPageSettingsMessages($error_message){
		switch ($error_message) {
			case '1':
                $message = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'my-text-domain' );               
                $err_code = esc_attr( 'settings_page_example_setting' );                 
                $setting_field = 'settings_page_example_setting';                 
			    break;
        }
        
		$type = 'error';
		add_settings_error($setting_field, $err_code, $message, $type);
	}
    
	public function registerAndBuildFields() {
        /**
         * Primeiro, adicionamos_settings_section. Isso é necessário porque todas as configurações futuras devem pertencer a um.
         * Em segundo lugar, add_settings_field
         * Terceiro, register_setting
         */     
        add_settings_section(
        // ID usado para identificar esta seção e com o qual registrar opções
        'eatcookie_general_section', 
        // Título a ser exibido na página de administração
        '',  
        // Callback used to render the description of the section
            array( $this, 'settings_page_display_general_account' ),    
        // Callback usado para renderizar a descrição da seção
        'eatcookie_general_settings'                   
        );
        
        add_settings_field('ec_texto', 'Configuracão de exemplo', array( $this, 'renderTexto' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_link_pagina_politica', 'Link da página de política', array( $this, 'renderLinkPolitica' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_texto_pagina_politica', 'Texto do botão da política', array( $this, 'renderTextoPolitica' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_button_aceito', 'Texto do botão de aceito', array( $this, 'renderTextoAceito' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_button_recusa', 'Texto do botão de rejeitar', array( $this, 'renderTextoRecusa' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_buttons_bg', 'Cor dos botões', array( $this, 'renderBgButtons' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_buttons_color', 'Cor do texto dos botões', array( $this, 'renderColorButtons' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_text_bg', 'Cor da notificação', array( $this, 'renderBgTexto' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_text_color', 'Cor do texto notificação', array( $this, 'renderColorTexto' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_possicao_notificacao', 'Posição que aparece a notificação', array( $this, 'renderPosition' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 
        add_settings_field('ec_tempo', 'Tempo que expira a ocultação', array( $this, 'renderSelectTime' ), 'eatcookie_general_settings', 'eatcookie_general_section'); 


        register_setting('eatcookie_general_settings', 'ec_texto');
        register_setting('eatcookie_general_settings', 'ec_link_pagina_politica');
        register_setting('eatcookie_general_settings', 'ec_texto_pagina_politica');
        register_setting('eatcookie_general_settings', 'ec_button_aceito');
        register_setting('eatcookie_general_settings', 'ec_button_recusa');
        register_setting('eatcookie_general_settings', 'ec_buttons_bg');
        register_setting('eatcookie_general_settings', 'ec_buttons_color');
        register_setting('eatcookie_general_settings', 'ec_text_bg');
        register_setting('eatcookie_general_settings', 'ec_text_color');
        register_setting('eatcookie_general_settings', 'ec_possicao_notificacao');       
        register_setting('eatcookie_general_settings', 'ec_tempo');       
    }

    public function settings_page_display_general_account() {
		echo '<p>Essas configurações se aplicam a todas as funcionalidades de nome de plug-in.</p>';
    } 

    public function renderTexto(){
        echo '<textarea id="ec_texto"  class="large-text code" rows="3" name="ec_texto">' . get_option( 'ec_texto' ) . '</textarea>';
    }

    public function renderLinkPolitica(){
        echo '<input id="ec_link_pagina_politica" class="regular-text" type="text" name="ec_link_pagina_politica" value="' . get_option( 'ec_link_pagina_politica' ) .'"/>';
    }

    public function renderTextoPolitica(){
        echo '<input id="ec_texto_pagina_politica" class="regular-text" type="text" name="ec_texto_pagina_politica" value="' . get_option( 'ec_texto_pagina_politica' ) . '"/>';
    }

    public function renderTextoAceito(){
        echo '<input id="ec_button_aceito" class="regular-text" type="text" name="ec_button_aceito" value="' . get_option( 'ec_button_aceito' ) . '"/>';
    }

    public function renderTextoRecusa(){
        echo '<input id="ec_button_recusa" class="regular-text" type="text" name="ec_button_recusa" value="' . get_option( 'ec_button_recusa' ) . '"/>';
    }

    public function renderBgButtons() {
        echo '<input id="ec_buttons_bg" type="text" name="ec_buttons_bg" value="'. get_option( 'ec_buttons_bg' ) . '"/>';
    }

    public function renderColorButtons() {
        echo '<input id="ec_buttons_color" type="text" name="ec_buttons_color" value="'. get_option( 'ec_buttons_color' ). '"/>';
    }

    public function renderBgTexto() {
        echo '<input id="ec_text_bg" type="text" name="ec_text_bg" value="' . get_option( 'ec_text_bg' ) . '"/>';
    }

    public function renderColorTexto() {
        echo '<input id="ec_text_color" type="text" name="ec_text_color" value="' . get_option( 'ec_text_color' ) . '"/>';
    }

    public function renderPosition( ){
        $checkbox_val = get_option('ec_possicao_notificacao' );
        $html = '';
        $html .= '<label><input type="radio" name="ec_possicao_notificacao" value="top"';
        $html .= $checkbox_val == "top" ? 'checked/><span>Top</span></label>' : '/><span>Top</span></label> ';
        $html .= ' <label><input type="radio" name="ec_possicao_notificacao" value="bottom"';
        $html .= $checkbox_val == "bottom" ? 'checked/><span>Bottom</span></label>' : '/> <span>Bottom</span></label>';        
        echo $html;
    }

    public function renderSelectTime() {
        $times = array(
            'day' => array( __( '1 dia', 'eatcookie' ), 86400 ),
            'week' => array( __( '1 semana', 'eatcookie' ), 604800 ),
            'month' => array( __( '1 mes', 'eatcookie' ), 2592000 ),
            '3months' => array( __( '3 meses', 'eatcookie' ), 7862400 ),
            '6months' => array( __( '6 meses', 'eatcookie' ), 15811200 ),
            'year' => array( __( '1 ano', 'eatcookie' ), 31536000 ),
            'infinity' => array( __( 'infinito', 'eatcookie' ), 2147483647 )
        );
        $selected = get_option( 'ec_tempo' );
        $options = "<select name='ec_tempo' id='ec_tempo'>";
        foreach ($times as $value => $arr) {
            $options .= "<option value='$value'";
            $options .= $value == $selected ? "selected>" : ">";
            $options .= $arr[0] . "</option>";
        };
        echo $options .= "</select>";
    }
}
?>