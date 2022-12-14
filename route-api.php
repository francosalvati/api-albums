<?php

require_once './api/controller/apiAlbumController.php';
require_once './api/controller/authController.php';
require_once './library/Router.php';

    $router = new Router();

    $router->addRoute('albums', 'GET', 'ApiAlbumController', 'get');
    $router->addRoute('albums/:ID', 'GET', 'ApiAlbumController', 'get');
    $router->addRoute('albums/:ID', 'DELETE', 'ApiAlbumController', 'delete');
    $router->addRoute('albums/:ID', 'PUT', 'ApiAlbumController', 'modify');
    $router->addRoute('albums', 'POST', 'ApiAlbumController', 'insert');

    $router->addRoute('auth/token', 'GET', 'AuthController', 'getToken');
    $router->addRoute('auth/:ID', 'GET', 'AuthController', 'getUsuario');

    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


