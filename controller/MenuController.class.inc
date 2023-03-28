<?php
require_once APPRAIZ . "/model/MenuModel.class.inc";

class MenuController
{
    function listPagina()
    {
        $menuModel = new MenuModel();
        return $menuModel->listPagina();
    }

    function get($id)
    {
        $menuModel = new MenuModel();
        return $menuModel->get($id);
    }

    function inativarAtivar($id)
    {
        $menuModel = new MenuModel();
        echo $menuModel->inativarAtivar($id);
    }

    function salvar($arrPost = [])
    {
        $menuModel = new MenuModel();
        return $menuModel->salvar($arrPost);
    }
}