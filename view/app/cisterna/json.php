<?php
require_once '../../config.php';
$conexao = new Conexao();

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name

## Search
$searchValue = $_POST['search']['value']; // Search value
$arSearch = explode(',', $searchValue); // Colocou um vírgula para pesquisar mais campos.
$searchQuery = " ";

// Pesquisa vários campos do DataTable
if (is_array($arSearch) && sizeof($arSearch) >= 1) {
    foreach ($arSearch as $valor) {
        if ($valor != '') {
            $searchQuery .= " AND (
                            c.id_cisterna like '%" . $valor . "%' or 
                            tc.nm_tp_construcao like '%" . $valor . "%' or 
                            e.nome like '%" . $valor . "%' or 
                            cid.nome like '%" . $valor . "%' or 
                            c.dt_cadastro like '%" . $valor . "%'  
                    ) ";
        }
    }

// Pesquisa um único campo
} else {
    if ($searchValue != '') {
        $searchQuery .= " AND (
                            c.id_cisterna like '%" . $searchValue . "%' or 
                            tc.nm_tp_construcao  like '%" . $searchValue . "%' or 
                            e.nome like '%" . $searchValue . "%' or 
                            cid.nome like '%" . $searchValue . "%' or 
                            c.dt_cadastro  like '%" . $searchValue . "%'  
                    ) ";
    }
}

## Total number of records without filtering
$totalRecords = $conexao->pegaUm("SELECT
                                    COUNT(id_cisterna)
                                FROM
                                    fbb_sistema.tbl_cisterna c
                                JOIN fbb_sistema.tbl_tipo_construcao tc ON c.fk_id_tp_construcao = tc.id_tp_construcao
                                JOIN fbb_sistema.tbl_estado e ON e.id_estado = c.fk_id_estado
                                JOIN fbb_sistema.tbl_cidade cid ON cid.id_cidade = c.fk_id_cidade
                                ");

## Total number of record with filtering
$totalRecordwithFilter = $conexao->pegaUm("SELECT
                                        COUNT(id_cisterna)
                                    FROM
                                        fbb_sistema.tbl_cisterna c
                                    JOIN fbb_sistema.tbl_tipo_construcao tc ON c.fk_id_tp_construcao = tc.id_tp_construcao
                                    JOIN fbb_sistema.tbl_estado e ON e.id_estado = c.fk_id_estado
                                    JOIN fbb_sistema.tbl_cidade cid ON cid.id_cidade = c.fk_id_cidade
                                    " . $searchQuery);

## Fetch records
$sql = "SELECT
            c.id_cisterna,
            entidade.nm_fantasia,
            tc.nm_tp_construcao,
            c.dsc_materiais,
            p.nome_pt as pais,
            e.nome as estado,
            cid.nome as cidade,
            c.nm_bairro,
            c.nm_endereco,
            date_format(( c.dt_inauguracao), '%d/%m/%Y %H:%i:%s') as dt_inauguracao,
            c.st_cisterna,
            date_format(( c.dt_cadastro), '%d/%m/%Y %H:%i:%s') as dt_cadastro,
            CASE WHEN st_cisterna = 1 THEN 'Ativa' else 'Inativa' end as st_cisterna
        FROM
            fbb_sistema.tbl_cisterna c
        JOIN fbb_sistema.tbl_entidade entidade ON entidade.id_entidade = c.fk_id_entidade
        JOIN fbb_sistema.tbl_tipo_construcao tc ON c.fk_id_tp_construcao = tc.id_tp_construcao
        JOIN fbb_sistema.tbl_pais p ON p.id_pais = c.fk_id_pais
        JOIN fbb_sistema.tbl_estado e ON e.id_estado = c.fk_id_estado
        JOIN fbb_sistema.tbl_cidade cid ON cid.id_cidade = c.fk_id_cidade
          WHERE 1=1
          " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
$arDados = $conexao->carregar($sql);

$data = array();
$btnEdit = HOME_URI . 'assets/images/icones/application_edit.png';
$btnDel = HOME_URI . 'assets/images/icones/delete.png';
$btnAtivar = HOME_URI . 'assets/images/icones/accept.png';

foreach ($arDados as $strKey => $strValue) {
    $id = $strValue['id_cisterna'];
    $botao =  $strValue['st_cisterna'] == 'Ativa' ? $btnDel : $btnAtivar;
    $label =  $strValue['st_cisterna'] == 'Ativa' ? 'Inativar' : 'Ativar';

    $data[] = [
        'id_cisterna' => $strValue['id_cisterna'],
        'nm_fantasia' => $strValue['nm_fantasia'],
        'nm_tp_construcao' => $strValue['nm_tp_construcao'],
        'dsc_materiais' => $strValue['dsc_materiais'],
        'pais' => $strValue['pais'],
        'estado' => $strValue['estado'],
        'cidade' => $strValue['cidade'],
        'nm_bairro' => $strValue['nm_bairro'],
        'nm_endereco' => $strValue['nm_endereco'],
        'dt_inauguracao' => $strValue['dt_inauguracao'],
        'st_cisterna' => $strValue['st_cisterna'],
        'dt_cadastro' => $strValue['dt_cadastro'],
        'Editar' =>  "<img title='Editar' src='{$btnEdit}' onclick='editarRegistro(\"$id\")'>",
        'InativarAtivar' => "<a href='#' onclick='inativarAtivarRegistro(\"$id\")'>{$label} <img title='InativarAtivar' src='{$botao}'></a>",
    ];
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecordwithFilter,
    "iTotalDisplayRecords" => $totalRecords,
    "aaData" => $data
);

echo json_encode($response);