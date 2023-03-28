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
    $("#frmPerfil").validate({
        // Define as regras
        rules: {
            nm_perfil: {
                required: true
            },
            dsc_perfil: {
                required: true
            },
        },
        // Define as mensagens de erro para cada regra
        messages: {
            nm_perfil: {
                required: "Informe o perfil"
            },
            dsc_perfil: {
                required: "Informe a descrição do perfil"
            },
        }
    });

    $('.btn-novo').click(function () {

        // Redefine valores
        $(':input[name=id_perfil]').val('');
        $(':input[name=nm_perfil]').val('');
        $(':input[name=dsc_perfil]').val('');
        $(':input[name=st_perfil]').val('0');
        $(':input[name=acao]').val('I');
        $(':input[name=btn-salvar]').val('Incluir');

        // Limpa campos
        $('#frmPerfil').find("input[type=text], textarea, select").val("");
        $('.cadastro').show();
    });

    $('#btn-salvar').click(function () {
        let dadosForm;
        let form = $('#frmPerfil');
        let formValido = form.valid();

        if (formValido) {
            let msg;
            if ($(':input[name=id_perfil]').val() !== '') {
                $(':input[name=ajax]').val('atualizarPerfil');
                let msg = 'atualizado';
            } else {
                $(':input[name=ajax]').val('salvarPerfil');
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
                    alert('Registro '+msg+' com sucesso!');
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

function inativarPerfil(id_perfil) {

    if (confirm('Deseja inativar o perfil selecionado?')) {
        body.addClass("loading");
        let request = $.ajax({
            method: "POST",
            url: window.location.href,
            data: {id_perfil: id_perfil, ajax: 'inativarPerfil'},
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