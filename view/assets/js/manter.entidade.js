let body = $("body");

$(function () {

    $("#nr_cnpj").mask(("99.999.999/9999-99"));
    $("#nr_cep").mask(("99999-999"));

    fetch_data();

    function fetch_data(
        id_entidade = '',
        nm_fantasia = '',
        nr_cep = '',
        dt_cadastro = ''
    ) {
        $("#listaDataTable").dataTable({
            'processing': true,
            'serverSide': true,
            "autoWidth": false,
            fixedHeader: {
                header: true,
                footer: true,
                headerOffset: 50
            },
            'ajax': {
                'url': 'json.php',
                type: "POST",
                data: {
                    id_entidade: id_entidade,
                    nm_fantasia: nm_fantasia,
                    nr_cep: nr_cep,
                    dt_cadastro: dt_cadastro
                }
            },
            'serverMethod': 'post',
            "order": [[1, 'desc']],
            "iDisplayLength": parseInt('20'),
            "aLengthMenu": [10, 50, 100, 200],
            "bJQueryUI": true,
            "bPaginate": true,
            "sPaginationType": "full_numbers",
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
            'columns': [
                {data: 'id_entidade'},
                {data: 'nm_fantasia'},
                {data: 'nr_telefone'},
                {data: 'nr_cnpj'},
                {data: 'pais'},
                {data: 'estado'},
                {data: 'cidade'},
                {data: 'nm_bairro'},
                {data: 'nm_endereco'},
                {data: 'nr_cep'},
                {data: 'st_entidade'},
                {data: 'dt_cadastro'},
                {data: 'Editar', searchable: false, sortable: false},
                {data: 'InativarAtivar', searchable: false, sortable: false},
            ],
        });
    }

    $('.btn-novo').click(function () {
        limpaDados();
    });

    // Inserir / Atualizar
    $('#frmEntidade').submit(function (e) {
        e.preventDefault();

        let serializeDados = $('#frmEntidade').serialize();

        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: serializeDados + '&ajax=salvar',
            dataType: "json",
            cache: false,
            success: function (result) {
                if (result) {
                    alert('Cadastro salvo com sucesso!.');
                    limpaDados();
                    $("#listaDataTable").DataTable().ajax.reload(); // Atualiza o DataTable
                    return;

                } else {
                    alert('Erro encontrado, contate o desenvolvedor do sistema.');
                    limpaDados();
                    $("#listaDataTable").DataTable().ajax.reload(); // Atualiza o DataTable
                    return;
                }
            },
            error: function () {
                alert("ERRO! Ocorreu um erro durante o processamento");
            },
        });
    });
});

let limpaDados = function () {
    $('#id_entidade').val('');
    $('#nm_fantasia').val('');
    $('#nr_cnpj').val('');
    $('#fk_id_pais').val('').trigger("chosen:updated");
    $('#fk_id_estado').val('').trigger("chosen:updated");
    $('#fk_id_cidade').val('').trigger("chosen:updated");
    $('#nr_cep').val('');
    $('#nm_bairro').val('');
    $('#nm_endereco').val('');
    $('#nr_ddd').val('');
    $('#nr_telefone').val('');
    $('#nm_observacao').val('');
    $('#ids_cisterna').val('').trigger("chosen:updated");
    $('.list-group').empty();
};

function editarRegistro(id) {
    $('html, body').animate({
        scrollTop: $("#layout-wrapper").offset().top
    }, 2000);
    get(id);
    $('#nm_fantasia').focus();
}

function get(id) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: {
            id_entidade: id,
            ajax: 'get'
        },
        dataType: "json",
        success: function (json) {
            $('#id_entidade').val(json.id_entidade);
            $('#nm_fantasia').val(json.nm_fantasia);
            $('#nr_cnpj').val(json.nr_cnpj);
            $('#fk_id_pais').val(json.fk_id_pais).trigger("chosen:updated");
            $('#fk_id_estado').val(json.fk_id_estado).trigger("chosen:updated");
            $('#fk_id_cidade').val(json.fk_id_cidade).trigger("chosen:updated");
            $('#nr_cep').val(json.nr_cep);
            $('#nm_bairro').val(json.nm_bairro);
            $('#nm_endereco').val(json.nm_endereco);
            $('#nr_ddd').val(json.nr_ddd);
            $('#nr_telefone').val(json.nr_telefone);
            $('#nm_observacao').val(json.nm_observacao);

            $.each(json.ids_cisterna, function (key, value) {
                $('.list-group')
                    .append($("<li class='p-3 mb-1 bg-light text-dark'>"+value.cisterna+"</li>"));
            });
        }
    });
}

function reloadPage() {
    window.location.reload();
    return;
}

// Inativar
function inativarAtivarRegistro(id) {

    if (confirm('Deseja ativar / inativar o registro selecionado?')) {
        let request = $.ajax({
            method: "POST",
            url: 'ajax.php',
            data: {id_entidade: id, ajax: 'inativar'},
            dataType: "json"
        });
        request.done(function (e) {
            if (e == 1) {
                alert('Registro atualizado com sucesso!');
                reloadPage();
                return;
            } else {
                alert('Erro encontrado, verifique parâmetros!');
                return;
            }
        });
        request.fail(function (e) {
            console.log("Erro encontrado, verifique parâmetros" + e);
        });
        return false;
    }
}