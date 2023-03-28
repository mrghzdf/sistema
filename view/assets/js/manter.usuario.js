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
        "iDisplayLength": parseInt('50'),
        "aLengthMenu": [10, 50, 100],
        "aaData": null, // JSON data
        "aaSorting": [],
        "bJQueryUI": true,
        "bPaginate": true,
        "sPaginationType": "full_numbers",
    });


    // Máscaras
    $('#nro_cpf').mask('000.000.000-00');

    // Validações
    $("#form-usuario").validate({
        // Define as regras
        rules: {
            nm_login: {
                required: true
            },
            id_perfil: {
                required: true
            },
            nm_senha: {
                required: true
            }
        },
        // Define as mensagens de erro para cada regra
        messages: {
            nm_login: {
                required: "Informe a matrícula"
            },
            id_perfil: {
                required: "Informe o perfil do usuário"
            },
            nm_senha: {
                required: 'Informe a senha de acesso ao sistema'
            }
        }
    });

    $('.btn-novo').click(function () {

        // Redefine valores
        $(':input[name=id_usuario]').val('');
        $(':input[name=nme_senha]').val('');
        $('#divNome').hide();
        $('#divSenha').show();
        $('#nm_senha').val('');
        $(':input[name=acao]').val('I');
        $(':input[name=btn-salvar]').val('Incluir');
        $("input[name=st_usuario][value='1']").attr('checked', 'checked');

        // Limpa campos
        $('#form-usuario').find("input[type=text], textarea, select").val("");
        $('.resetarSenha').hide();
        $('.cadastro').show();
    });

    $('#btn-salvar').click(function () {
        let dadosForm;
        let form = $('#form-usuario');
        let formValido = form.valid();

        if (formValido) {
            let msg;
            if ($(':input[name=id_usuario]').val() !== '') {
                $(':input[name=ajax]').val('atualizarUsuario');
                msg = 'Atualização';
            } else {
                $(':input[name=ajax]').val('salvarUsuario');
                msg = 'Inclusão';
            }

            body.addClass("loading");
            dadosForm = form.serialize();
            let request = $.ajax({
                method: "POST",
                url: window.location.href,
                data: dadosForm,
                dataType: "json"
            });
            request.done(function (r) {

                console.log(r);
                if (r == '2') {
                    alert('O registro já existe no sistema.');
                    window.location.href = 'index.php?acao=I';
                    return;

                } else if (r == '0') {
                    alert('Alteração não pode ser realizada. Contate o administrador do sistema.');
                    window.location.href = 'index.php?acao=I';
                    return;

                } else {
                    alert(msg + ' realizada com sucesso');
                    window.location.href = 'index.php?acao=I';
                    return;
                }
            });
            request.fail(function (e) {
                console.log("Erro encontrado, verifique parâmetros" + e);
                $body.removeClass("loading");
            });
            return false;
        }
    });

    $('#nro_cpf').blur(function () {
        $this = $(this);

        if ($this.val() !== '' && $('.cadastro').is(":visible")) {
            // Elimina possivel mascara
            let cpf = replaceAll(replaceAll($this.val(), '-', ''), '.', '');

            if (validaCpf(cpf)) {

                // Verifica se o cpf já existe na base
                let request = $.ajax({
                    method: "POST",
                    url: window.location.href,
                    data: {nro_cpf: cpf, ajax: 'existeCpfBase'},
                    dataType: "json"
                });
                request.done(function (e) {
                    if (e == 1) {
                        alert('Atenção! Cpf já existe na base. Por favor utilize outro cpf.');
                        $this.val('');
                        window.location.href = 'index.php?acao=I';
                        return;

                    } else {
                        return true;
                    }
                });
                request.fail(function (e) {
                    console.log("Erro encontrado, verifique parâmetros" + e);
                });
                return false;

            } else {
                alert('CPF inválido');
                $this.val('');
                return false;
            }
        }
    });

    $('#dt_nasc').blur(function () {
        if ($(this).val() !== '') {
            if (!validarData($(this).val())) {
                alert('Informe uma data válida');
                $this.val('');
                window.location.href = 'index.php?acao=I';
                return;
            }
        }
    });

});

function inativarUsuario(id_usuario) {
    if (confirm('Deseja inativar o usuário selecionado?')) {
        body.addClass("loading");
        let request = $.ajax({
            method: "POST",
            url: window.location.href,
            data: {id_usuario: id_usuario, ajax: 'inativarUsuario'},
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