let body = $("body");

$(function () {
    fetch_data();
    function fetch_data(
            id_cisterna = '',
            nm_tp_construcao = '',
            nome = '',
            nr_cep = '',
            dt_cadastro = '',
    ) {
        $("#listaDataTable").dataTable({
            'processing': true,
            'serverSide': true,
            fixedHeader: {
                header: true,
                footer: true,
                headerOffset: 50
            },
            'ajax': {
                'url': 'json.php',
                type: "POST",
                data: {
                    id_cisterna: id_cisterna,
                    nm_tp_construcao: nm_tp_construcao,
                    nome: nome,
                    nr_cep: nr_cep,
                    dt_cadastro: dt_cadastro,
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
                {data: 'id_cisterna'},
                {data: 'nm_fantasia'},
                {data: 'nm_tp_construcao'},
                {data: 'dsc_materiais'},
                {data: 'pais'},
                {data: 'estado'},
                {data: 'cidade'},
                {data: 'nm_bairro'},
                {data: 'nm_endereco'},
                {data: 'dt_inauguracao'},
                {data: 'st_cisterna'},
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
    $('#frmCisterna').submit(function (e) {
        e.preventDefault();

        let serializeDados = $('#frmCisterna').serialize();

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
    $('#id_cisterna').val('');
    $('#fk_id_entidade').val('');
    $('#fk_id_tp_construcao').val('');
    $('#dsc_materiais').val('');
    $('#fk_id_pais').val('').trigger("chosen:updated");
    $('#fk_id_estado').val('').trigger("chosen:updated");
    $('#fk_id_cidade').val('').trigger("chosen:updated");
    $('#nm_bairro').val('');
    $('#nm_endereco').val('');
    $('#dt_inauguracao').val('');
    $('#nr_longitude').val('');
    $('#nr_latitude').val('');
    $('#st_cisterna').val('');
    $('#ids_cisterna').val('').trigger("chosen:updated");
    $('.geolocalizacao').hide();
};

function editarRegistro(id) {
    $('html, body').animate({
        scrollTop: $("#layout-wrapper").offset().top
    }, 2000);
    get(id);
    $('#nm_tp_construcao').focus();
}

function get(id) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: {
            id_cisterna: id,
            ajax: 'get'
        },
        dataType: "json",
        success: function (json) {
            $('#id_cisterna').val(json.id_cisterna);
            $('#fk_id_entidade').val(json.fk_id_entidade);
            $('#fk_id_tp_construcao').val(json.fk_id_tp_construcao);
            $('#dsc_materiais').val(json.dsc_materiais);
            $('#fk_id_pais').val(json.fk_id_pais).trigger("chosen:updated");
            $('#fk_id_estado').val(json.fk_id_estado).trigger("chosen:updated");
            $('#fk_id_cidade').val(json.fk_id_cidade).trigger("chosen:updated");
            $('#nm_bairro').val(json.nm_bairro);
            $('#nm_endereco').val(json.nm_endereco);
            $('#dt_inauguracao').val(json.dt_inauguracao);
            $('#nr_latitude').val(json.nr_latitude);
            $('#nr_longitude').val(json.nr_longitude);
            $('#st_cisterna').val(json.st_cisterna);

            // Mapa
            $('#infoMapa').hide();

            let iframeMapa = '';
            if(json.nr_latitude !== null && json.nr_longitude !== null){
                iframeMapa = '<iframe ' +
                'width="80%" ' +
                'height="500" ' +
                'src="https://maps.google.com/maps?q='+json.nr_latitude+',' +
                ''+ json.nr_longitude +'&output=embed"></iframe>';
                $('#mapaGoogle').html(iframeMapa);
                $('.geolocalizacao').fadeIn();

            } else { // Endereço
                let endereco = json.fk_id_estado + ',' + json.nm_bairro + ',' + json.nm_endereco;
                iframeMapa = '<iframe ' +
                    'width="80%" ' +
                    'height="500" ' +
                    'src="https://maps.google.com/maps?q='+endereco +'&output=embed"></iframe>';
                $('#mapaGoogle').html(iframeMapa);
                $('.geolocalizacao').fadeIn();
            }
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
            data: {id_cisterna: id, ajax: 'inativar'},
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