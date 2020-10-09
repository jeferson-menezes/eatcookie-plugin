jQuery(document).ready(function ($) {
    $('#ea-accept-cookie').click(function () {
        var dados = {
            'action': 'minha_acao_ajax',
            "value": jecArgsAlert.value,
            "alert_action": 'ACEITO',
        };

        $.post(jecArgsAlert.ajaxUrl, dados, function (resposta) {
        }, 'json');

        $('#eatcookie-alert').hide();

        return false;
    });

    $('#ea-refuse-cookie').click(function () {
        var dados = {
            'action': 'minha_acao_ajax',
            "value": jecArgsAlert.value,
            "alert_action": 'REJEITO',
        };

        $.post(jecArgsAlert.ajaxUrl, dados, function (resposta) {
        }, 'json');
        $('#eatcookie-alert').hide();
        return false;
    });
});
