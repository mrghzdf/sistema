<?php
require_once APPRAIZ . "/model/TipoConstrucaoModel.class.inc";

class TipoConstrucaoController
{
    function listAll()
    {
        $tipoConstrucaoModel = new TipoConstrucaoModel();
        return $tipoConstrucaoModel->listAll();
    }
}