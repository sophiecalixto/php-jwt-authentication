<?php

namespace SophieCalixto\JWTAuthAPI\Controller;

class TaskController
{
    public static function index()
    {
        echo 'index TESTE';
    }

    public static function store()
    {
        echo 'store';
    }

    public static function update(int $id)
    {
        echo 'update' . $id;
    }

    public static function destroy(int $id)
    {
        echo 'destroy' . $id;
    }
}