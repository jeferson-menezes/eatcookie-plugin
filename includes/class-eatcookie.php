<?php

class Eatcookie {

    
// O carregador que é responsável por manter e registrar todos os ganchos desse poder
    protected $loader;
// O identificador exclusivo deste plugin.
    protected $plugin_name;
// a versão corrente do pluguin
    protected $version;

    public function getLoader(){
        return $this->loader;
    }

    public function getPluginName(){
        return $this->plugin_name;
    }

    public function getVersion(){
        return $this->version;
    }

    public function __construct(){
        if ( defined( 'EATCOOKIE_VERSION' ) ) {
			$this->version = EATCOOKIE_VERSION;
		} else {
			$this->version = '1.0.0';
        }

        $this->plugin_name = 'eatcookie-navigation';

        $this->loadDependencies();
        $this->defineAdminHooks();
        $this->definePublicHooks();
    }

    public function run(){
        $this->loader->run();
    }

    public function loadDependencies(){
        require plugin_dir_path( dirname(__FILE__)) . 'includes/class-eatcookie-helper.php';

        require plugin_dir_path( dirname(__FILE__)) . 'includes/class-eatcookie-tarefa.php';

        require plugin_dir_path( dirname(__FILE__)) . 'includes/class-eatcookie-controller.php';
        //  A classe responsável por orquestrar as ações e filtros do plugin principal.
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-eatcookie-carregador.php';
        // A classe responsável por definir todas as ações que ocorrem na área administrativa.
        require_once plugin_dir_path( dirname(__FILE__)) . 'admin/class-eatcookie-admin.php';

        require_once plugin_dir_path( dirname(__FILE__)) . 'public/class-eatcookie-public.php';
        
        $this->loader = new EatcookieCarregador();
    }

    public function defineAdminHooks(){
        
        $ajax_controller = new EatcookieController();
        $this->loader->addAction('wp_ajax_minha_acao_ajax', $ajax_controller, 'ajaxAcaoNotificacao');
        $this->loader->addAction('wp_ajax_nopriv_minha_acao_ajax', $ajax_controller, 'ajaxAcaoNotificacao');
        
        $plugin_admin = new EatcookieAdmin($this->getPluginName(), $this->getVersion());
        // $this->loader->addAction('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        // $this->loader->addAction('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->addFilter( 'cron_schedules', $plugin_admin, 'jec_custon_tarefa_dia');

        $tasks = new EatcookieTarefa();
        $this->loader->addAction('ec_cron_hook_eatcookie_expire', $tasks, 'excluirLogsExpirados');
    }

    public function definePublicHooks() {

        $plugin_public = new EatcookiePublic($this->getPluginName(), $this->getVersion());
        
		$this->loader->addAction( 'wp_enqueue_scripts', $plugin_public, 'enqueueStyles' );
        $this->loader->addAction( 'wp_enqueue_scripts', $plugin_public, 'enqueueScripts' );

        $this->loader->addFilter( 'the_content', $plugin_public, 'render_template_alerta');
    }
}
?>