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
                            ent.id_entidade like '%" . $valor . "%' or 
                            ent.nm_fantasia like '%" . $valor . "%' or 
                            ent.nr_cep like '%" . $valor . "%' or 
                            ent.dt_cadastro like '%" . $valor . "%'  
                    ) ";
        }
    }

// Pesquisa um único campo
} else {
    if ($searchValue != '') {
        $searchQuery .= " AND (
                            ent.id_entidade like '%" . $searchValue . "%' or 
                            ent.nm_fantasia  like '%" . $searchValue . "%' or 
                            ent.nr_cep '%" . $searchValue . "%' or 
                            ent.dt_cadastro  like '%" . $searchValue . "%'  
                    ) ";
    }
}

## Total number of records without filtering
$totalRecords = $conexao->pegaUm("SELECT
                                    COUNT(id_entidade)
                                FROM
                                    fbb_sistema.tbl_entidade ent
                                JOIN fbb_sistema.tbl_estado e ON e.id_estado = ent.fk_id_estado
                                JOIN fbb_sistema.tbl_cidade cid ON cid.id_cidade = ent.fk_id_cidade
                                ");

## Total number of record with filtering
$totalRecordwithFilter = $conexao->pegaUm("SELECT
                                    COUNT(id_entidade)
                                FROM
                                    fbb_sistema.tbl_entidade ent
                                JOIN fbb_sistema.tbl_estado e ON e.id_estado = ent.fk_id_estado
                                JOIN fbb_sistema.tbl_cidade cid ON cid.id_cidade = ent.fk_id_cidade
                                    " . $searchQuery);

## Fetch records
$sql = "SELECT
            ent.id_entidade,
            ent.nm_fantasia,
            CONCAT( '(', ent.nr_ddd,') ', ent.nr_telefone ) as nr_telefone,
            ent.nr_cnpj,
            p.nome_pt as pais,
            e.nome as estado,
            cid.nome as cidade,
            ent.nm_bairro,
            ent.nm_endereco,
            ent.nr_cep,
            CASE WHEN ent.st_entidade = 1 THEN 'Ativa' else 'Inativa' end as st_entidade,
            date_format(( ent.dt_cadastro), '%d/%m/%Y %H:%i:%s') as dt_cadastro
        FROM
            fbb_sistema.tbl_entidade ent
        JOIN fbb_sistema.tbl_pais p ON p.id_pais = ent.fk_id_pais
        JOIN fbb_sistema.tbl_estado e ON e.id_estado = ent.fk_id_estado
        JOIN fbb_sistema.tbl_cidade cid ON cid.id_cidade = ent.fk_id_cidade
          WHERE 1=1
          " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
$arDados = $conexao->carregar($sql);

$data = array();
$btnEdit = HOME_URI . 'assets/images/icones/application_edit.png';
$btnDel = HOME_URI . 'assets/images/icones/delete.png';
$btnAtivar = HOME_URI . 'assets/images/icones/accept.png';

foreach ($arDados as $strKey => $strValue) {
    $id = $strValue['id_entidade'];
    $botao =  $strValue['st_entidade'] == 'Ativa' ? $btnDel : $btnAtivar;
    $label =  $strValue['st_entidade'] == 'Ativa' ? 'Inativar' : 'Ativar';

    $data[] = [
        'id_entidade' => $strValue['id_entidade'],
        'nm_fantasia' => $strValue['nm_fantasia'],
        'nr_telefone' => $strValue['nr_telefone'],
        'nr_cnpj' => $strValue['nr_cnpj'],
        'pais' => $strValue['pais'],
        'estado' => $strValue['estado'],
        'cidade' => $strValue['cidade'],
        'nm_bairro' => $strValue['nm_bairro'],
        'nm_endereco' => $strValue['nm_endereco'],
        'nr_cep' => $strValue['nr_cep'],
        'st_entidade' => $strValue['st_entidade'],
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