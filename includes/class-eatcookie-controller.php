<?php
class EatcookieController {

    public function __construct() {
    }

    public function ajaxAcaoNotificacao() {    
        $acao = $_REQUEST['alert_action'];
        $value = $_REQUEST['value'];
      
        if (!isset($value) OR empty($value)) {
            echo json_encode(array('mensagem' => 'Erro'));
        } else {
            $agora = new DateTime();
            $expire = EatcookieHelper::getDataExpiracao();
            $data =  array(
                'date_created' => $agora->format('Y-m-d H:i:s'),
                'date_expire' => $expire->format('Y-m-d H:i:s'),
                'action' => $acao,
                'address' => EatcookieHelper::getIpCliente(),
            );
            
            $this->ec_persist($data);
        
            echo json_encode($data);
        }
        wp_die();
    }
    
    public function ec_persist($data){
        global $wpdb;
        $table_name = $wpdb->prefix.'eatcookies_log';
       
        $wpdb->insert($table_name, $data);
    }
}
?>