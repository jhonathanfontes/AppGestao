<?php

function getUsuarioLogado()
{
    $autenticacao = service('autenticacao');
    return $autenticacao->usuarioLogado();
}

function getPermissaoUsuario(){
    $autenticacao = service('autenticacao');
    return $autenticacao->isAdmin();
}

function getUsuarioLogadoSession()
{
    $autenticacao = service('autenticacao');
    return $autenticacao->usuarioLogadoSession();
}