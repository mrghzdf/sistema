<?php
require_once APPRAIZ . "/model/EstadoModel.class.inc";

class EstadoController
{
    function listAll()
    {
        $estadoModel = new EstadoModel();
        return $estadoModel->listAll();
    }
}