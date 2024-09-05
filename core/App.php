<?php

namespace Core;

class App {
    protected $controller = 'HomeController';  // Nome do controlador padrão
    protected $method = 'index';               // Nome do método padrão
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Adiciona o namespace 'App\Controllers\' ao nome do controlador
        $controllerName = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : $this->controller;
        $controllerWithNamespace = 'App\\Controllers\\' . $controllerName;

        // Verifica se o controlador existe com o namespace correto
        if (file_exists('../app/Controllers/' . $controllerName . '.php')) {
            $this->controller = $controllerWithNamespace;
            unset($url[0]);
        }

        // Instancia o controlador
        if (class_exists($this->controller)) {
            $this->controller = new $this->controller;
        } else {
            echo 'Controlador não encontrado: ' . $this->controller;
            exit;
        }

        // Verifica se o método existe no controlador
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Pega os parâmetros restantes da URL
        $this->params = $url ? array_values($url) : [];

        // Chama o método no controlador com os parâmetros
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
