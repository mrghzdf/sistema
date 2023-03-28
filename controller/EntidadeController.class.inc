<?php
require_once APPRAIZ . "/model/EntidadeModel.class.inc";

class EntidadeController
{
    function listEntidade()
    {
        $entidadeModel = new EntidadeModel();
        return $entidadeModel->listEntidade();
    }

    function getCisternas($id)
    {
        $entidadeModel = new EntidadeModel();
        return $entidadeModel->getCisternas($id);
    }

    function get($id)
    {
        $entidadeModel = new EntidadeModel();
        return $entidadeModel->get($id);
    }

    function inativarAtivar($id)
    {
        $entidadeModel = new EntidadeModel();
        echo $entidadeModel->inativarAtivar($id);
    }

    function salvar($arrPost = [], $arrFiles = [])
    {
        $entidadeModel = new EntidadeModel();
        return $entidadeModel->salvar($arrPost, $arrFiles);
    }
}