<?php

class EatcookieCarregador{

    // ele conjunto de ações registradas no WordPress.
    // As ações registradas com WordPress para disparar quando o plugin é carregado.
    protected $actions;
    // Os filtros registrados com WordPress para disparar quando o plugin é carregado.
    protected $filters;

    public function __construct(){

        $this->actions = array();
        $this->filters = array();
    }
    /**
    * Adicione uma nova ação à coleção a ser registrada no WordPress.
    *
    * @since 1.0.0
    * @param string $ hook O nome da ação do WordPress que está sendo registrada.
    * @param object $ component Uma referência à instância do objeto no qual a ação é definida.
    * @param string $ callback O nome da definição da função no $ componente.
    * @param int $ priority Opcional. A prioridade na qual a função deve ser disparada. O padrão é 10.
    * @param int $ accept_args Opcional. O número de argumentos que devem ser passados ​​para o retorno de chamada $. O padrão é 1.
    */
    public function addAction( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
    }
    /**
    * Adicione um novo filtro à coleção para ser registrado no WordPress.
    *
    * @since 1.0.0
    * @param string $ hook O nome do filtro do WordPress que está sendo registrado.
    * @param object $ component Uma referência à instância do objeto no qual o filtro é definido.
    * @param string $ callback O nome da definição da função no $ componente.
    * @param int $ priority Opcional. A prioridade na qual a função deve ser disparada. O padrão é 10.
    * @param int $ accept_args Opcional. O número de argumentos que devem ser passados ​​para o retorno de chamada $. O padrão é 1
    */
    public function addFilter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
    }
    /**
    * Uma função de utilidade que é usada para registrar as ações e ganchos em um único
    * coleção.
    *
    * @since 1.0.0
    * @access private
    * @param array $ hooks A coleção de ganchos que está sendo registrada (ou seja, ações ou filtros).
    * @param string $ hook O nome do filtro do WordPress que está sendo registrado.
    * @param object $ component Uma referência à instância do objeto no qual o filtro é definido.
    * @param string $ callback O nome da definição da função no $ componente.
    * @param int $ priority A prioridade na qual a função deve ser disparada.
    * @param int $ accept_args O número de argumentos que devem ser passados ​​para $ callback.
    * @return array A coleção de ações e filtros registrados no WordPress.
    */
    private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;
    }
    
    // Registre os filtros e ações com o WordPress.
    public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}
	}
}
?>