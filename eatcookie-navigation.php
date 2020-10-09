<?php
/**
* Plugin Name:  Eatcookie Navigation
* Author:       Jeferson Menezes
* Author URI:       http://www.jefersonmenezes.com.br/
* Description:  Notifica a utilização de cookies nas páginas, e armazena a permissões do uso.
* Version:      1.0.0
* Text Domain: eatcookie_navigation
*/

// Se este arquivo for chamado diretamente, aborte.
if ( ! defined( 'ABSPATH' ) )
	exit;

define( 'EATCOOKIE_VERSION', '1.0.0' );
define( 'TABLE_NAME_EATCOOKIE_LOG', 'eatcookies_log');

function ativaConfiguracaoPagina() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-eatcookie-ativador.php';
    EatcookieAtivador::activate();
}

function desativaConfiguracaoPagina() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-eatcookie-desativador.php';
    EatcookieDesativador::deactivate();
}

register_activation_hook( __FILE__, 'ativaConfiguracaoPagina' );
register_deactivation_hook( __FILE__, 'desativaConfiguracaoPagina' );

require plugin_dir_path( __FILE__ ) . 'includes/class-eatcookie.php';

function runConfiguracao() {

    $plugin = new Eatcookie();
    $plugin->run();
}

runConfiguracao();
?>