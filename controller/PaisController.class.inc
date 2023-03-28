<?php
require_once APPRAIZ . "/model/PaisModel.class.inc";

class PaisController
{
    function listAll()
    {
        $paisModel = new PaisModel();
        return $paisModel->listAll();
    }
}