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
        "iDisplayLength": parseInt('40'),
        "aLengthMenu": [10, 50, 100],
        "aaData": null, // JSON data
        "aaSorting": [],
        "bJQueryUI": true,
        "bPaginate": true,
        "sPaginationType": "full_numbers",
    });

    // Validações
    $("#frmMenu").validate({
        // Define as regras
        rules: {
            id_menu_pai: {
                required: true
            },
            nm_menu: {
                required: true
            },
            nro_ordem: {
                required: true
            },
            url_menu: {
                required: true
            },
        },
        // Define as mensagens de erro para cada regra
        messages: {
            id_menu_pai: {
                required: "Informe o id do menu pai"
            },
            nm_menu: {
                required: "Informe o rótulo"
            },
            nro_ordem: {
                required: "Informe a ordem"
            },
            url_menu: {
                required: "Informe a URL"
            }
        }
    });

    $('.btn-novo').click(function () {

        // Redefine valores
        $(':input[name=id_menu]').val('');
        $(':input[name=id_menu_pai]').val('0');
        $(':input[name=nm_menu]').val('');
        $(':input[name=dsc_menu]').val('');
        $(':input[name=nro_ordem]').val('1');
        $(':input[name=url_menu]').val('');
        $(':input[name=acao]').val('I');
        $(':input[name=btn-salvar]').val('Incluir');

        // Limpa campos
        $('#frmMenu').find("input[type=text], textarea, select").val("");
        $('.cadastro').show();
    });

    $('#btn-salvar').click(function () {
        let dadosForm;
        let form = $('#frmMenu');
        let formValido = form.valid();

        if (formValido) {
            let msg;
            if ($(':input[name=id_menu]').val() !== '') {
                $(':input[name=ajax]').val('atualizarMenu');
                let msg = 'atualizado';
            } else {
                $(':input[name=ajax]').val('salvarMenu');
                let msg = 'incluído';
            }
            body.addClass("loading");
            dadosForm = form.serialize();
            let request = $.ajax({
                method: "POST",
                url: window.location.href,
                data: dadosForm,
                dataType: "json"
            });
            request.done(function (retornoAjax) {
                if (retornoAjax == 0) {
                    alert('Atenção! O registro já existe na base.');
                    return;

                } else {
                    alert('Registro ' + msg + ' com sucesso!');
                    window.location.href = 'index.php?acao=I';
                    return;
                }
            });
            request.fail(function (e) {
                console.log("Erro encontrado, verifique parâmetros" + e);
                body.removeClass("loading");
            });
            return false;
        }
    });

});

function inativarMenu(id_menu) {

    if (confirm('Deseja inativar o menu selecionado?')) {
        body.addClass("loading");
        let request = $.ajax({
            method: "POST",
            url: window.location.href,
            data: {id_menu: id_menu, ajax: 'inativarMenu'},
            dataType: "json"
        });
        request.done(function (e) {
            if (e == '1') {
                alert('Registro inativado com sucesso!');
                window.location.href = 'index.php?acao=I';
                return;

            } else {
                alert('Erro encontrado, verifique parâmetros!');
                body.removeClass('loading');
                return;
            }
        });
        request.fail(function (e) {
            console.log("Erro encontrado, verifique parâmetros" + e);
        });
        return false;
    }
}