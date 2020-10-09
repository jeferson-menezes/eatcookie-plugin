<?php

class EatcookieHelper {


    public static function getIpCliente() {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        }
        else {
            $ip = $remote;
        }
        return $ip;
    }

    public static function getDataExpiracao(){
        $time = get_option( 'ec_tempo' );
        $hora = new DateTime();
        switch ($time) {
            case "day":
                return $hora->add(new DateInterval('P1D'));
            case "week":
                return $hora->add(new DateInterval('P1W'));
            case "month":
                return $hora->add(new DateInterval('P1M'));
            case "3months":
                return $hora->add(new DateInterval('P3M'));
            case "6months":
                return $hora->add(new DateInterval('P6M'));
            case "year":
                return $hora->add(new DateInterval('P1Y'));
            case "infinity":
                return $hora->add(new DateInterval('P10Y'));
            default:
                return $hora->add(new DateInterval('P1D'));
        }
    }
}
?>