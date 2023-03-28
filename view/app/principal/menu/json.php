<?php
require_once '../../../config.php';
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
                            pm.nm_pg_menu like '%" . $valor . "%' or 
                            pm.nm_image like '%" . $valor . "%' or 
                            pm.nr_ordem like '%" . $valor . "%' or 
                            p.nm_pagina like '%" . $valor . "%'  
                    ) ";
        }
    }

// Pesquisa um único campo
} else {
    if ($searchValue != '') {
        $searchQuery .= " AND (
                            pm.nm_pg_menu like '%" . $searchValue . "%' or 
                            pm.nm_image like '%" . $searchValue . "%' or 
                            pm.nr_ordem like '%" . $searchValue . "%' or 
                            p.nm_pagina like '%" . $searchValue . "%'  
                    ) ";
    }
}
## Total number of records without filtering
$totalRecords = $conexao->pegaUm("SELECT
                                  COUNT(pm.id_pg_menu)
                                  FROM fbb_sistema.tbl_pagina_menu pm
                                  LEFT JOIN fbb_sistema.tbl_pagina p ON pm.id_pagina = p.id_pagina");

## Total number of record with filtering
$totalRecordwithFilter = $conexao->pegaUm("SELECT
                                  COUNT(pm.id_pg_menu)
                                  FROM fbb_sistema.tbl_pagina_menu pm
                                  LEFT JOIN fbb_sistema.tbl_pagina p ON pm.id_pagina = p.id_pagina
                    WHERE  1=1
                    " . $searchQuery);

## Fetch records
$sql = "SELECT
            pm.id_pg_menu,
            pm.nm_pg_menu,
            pm.nm_image,
            pm.nr_ordem,
            COALESCE (p.nm_pagina,'Inexistente') as nm_pagina,
            pm.st_visivel,
            pm.st_home,
            CASE WHEN st_pg_menu = 1 THEN 'Ativo' else 'Inativo' end as st_pg_menu
          FROM fbb_sistema.tbl_pagina_menu pm
          LEFT JOIN fbb_sistema.tbl_pagina p ON pm.id_pagina = p.id_pagina
          WHERE 1=1
          " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
$arDados = $conexao->carregar($sql);

$data = array();
$btnEdit = HOME_URI . 'assets/images/icones/application_edit.png';
$btnDel = HOME_URI . 'assets/images/icones/delete.png';
$btnAtivar = HOME_URI . 'assets/images/icones/accept.png';

foreach ($arDados as $strKey => $strValue) {
    $id = $strValue['id_pg_menu'];
    $botao =  $strValue['st_pg_menu'] == 'Ativo' ? $btnDel : $btnAtivar;
    $label =  $strValue['st_pg_menu'] == 'Ativo' ? 'Inativar' : 'Ativar';

    $data[] = [
        'nm_pg_menu' => $strValue['nm_pg_menu'],
        'nm_image' => $strValue['nm_image'],
        'nr_ordem' => $strValue['nr_ordem'],
        'nm_pagina' => $strValue['nm_pagina'],
        'st_visivel' => $strValue['st_visivel'],
        'st_pg_menu' => $strValue['st_pg_menu'],
        'st_home' => $strValue['st_home'],
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