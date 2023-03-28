<?php
require_once APPRAIZ . "/model/PerfilModel.class.inc";

class PerfilController
{
    function getMenuByPerfil( $id_perfil ){
        $perfil = new PerfilModel();
        return $perfil->getMenuByPerfil($id_perfil);
    }

    function listarPerfil(){
        $perfil = new PerfilModel();
        return $perfil->listarPerfil();
    }


}