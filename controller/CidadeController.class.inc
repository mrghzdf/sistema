<?php
require_once APPRAIZ . "/model/CidadeModel.class.inc";

class CidadeController
{
    function listAll()
    {
        $cidadeModel = new CidadeModel();
        return $cidadeModel->listAll();
    }
}