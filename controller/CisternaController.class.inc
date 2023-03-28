<?php
require_once APPRAIZ . "/model/CisternaModel.class.inc";

class CisternaController
{
    function get($id)
    {
        $cisternaModel = new CisternaModel();
        return $cisternaModel->get($id);
    }

    function inativarAtivar($id)
    {
        $cisternaModel = new CisternaModel();
        echo $cisternaModel->inativarAtivar($id);
    }

    function salvar($arrPost = [], $arrFiles = []){
        $cisternaModel = new CisternaModel();
        return $cisternaModel->salvar($arrPost, $arrFiles);
    }
}