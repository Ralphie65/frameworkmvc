<?php
class Controller
{
    public function model($model)
    {
        require_once "../app/models/{$model}.php";
        return new $model();
    }
    public function view($view, $data = [])
    {
        $filePath = "../app/views/{$view}.php";
        if (file_exists($filePath))
        {
            require_once $filePath;
        }
        else
        {
                die('View does not exist');
            }
        }
}