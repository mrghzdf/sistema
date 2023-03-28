let body = $("body");

$(function () {

    $(".dataTable").dataTable({
        "bProcessing": true,
        "oLanguage": {
            "sProcessing": "Processando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "Não foram encontrados resultados",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando de 0 até 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Primeiro",
                "sPrevious": "Anterior",
                "sNext": "Seguinte",
                "sLast": "Último"
            }
        },
        "iDisplayLength": parseInt('20'),
        "aLengthMenu": [10, 50, 100],
        "aaData": null, // JSON data
        "aaSorting": [],
        "bJQueryUI": true,
        "bPaginate": true,
        "sPaginationType": "full_numbers",
    });

    // Validações
    $("#frmPerfilMenu").validate({
        // Define as regras
        rules: {
            url_menu: {
                required: true
            },
        },
        // Define as mensagens de erro para cada regra
        messages: {
            url_menu: {
                required: "Informe as urls deste perfil"
            },
        }
    });

    $('#btn-salvar').click(function () {
        let dadosForm;
        let form = $('#frmPerfilMenu');
        let formValido = form.valid();

        if (formValido) {
            let msg;
            $(':input[name=ajax]').val('salvarPerfilMenu');
            body.addClass("loading");
            dadosForm = form.serialize();
            let request = $.ajax({
                method: "POST",
                url: window.location.href,
                data: dadosForm,
                dataType: "json"
            });
            request.done(function (retornoAjax) {
                alert('Menus incluídos com sucesso!');
                window.location.href = 'index.php?acao=I';
                return;
            });
            request.fail(function (e) {
                console.log("Erro encontrado, verifique parâmetros" + e);
                body.removeClass("loading");
            });
            return false;
        }
    });

});