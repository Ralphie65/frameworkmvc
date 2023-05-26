<?php

/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index.php';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();
        $controllerName = count($url) > 0 ? ucwords(array_shift($url)) : 'Index';
        if (file_exists("../app/controllers/{$controllerName}.php")) {
            $this->currentController = $controllerName;
        }
        require_once '../app/controllers/' . $this->currentController . '.php';
        $controllerInstance = new $this->currentController;

        $this->currentMethod = count($url) > 0 ? array_shift($url) : 'index';
        if (!method_exists($controllerInstance, $this->currentMethod)) {
            throw new \Exception("Method {$this->currentMethod} not found on controller {$this->currentController}!");
        }
        $this->params = is_array($url) ? array_values($url) : [];
        call_user_func_array([$controllerInstance, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}