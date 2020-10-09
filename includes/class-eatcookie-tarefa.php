<?php

class EatcookieTarefa {


    public function excluirLogsExpirados() {
        global $wpdb;
        $table_name = $wpdb->prefix.TABLE_NAME_EATCOOKIE_LOG;
      
        $agora = new DateTime();
        $agora = $agora->format('Y-m-d H:i:s');
      
        $sql = "DELETE FROM $table_name WHERE ID > 0 AND date_expire < '$agora'";
      
        $retorno = $wpdb->query($sql);
    }
}
?>