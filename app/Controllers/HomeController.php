<?php

namespace App\Controllers;

use Core\Controller;
use Core\Session;

class HomeController extends Controller {
    
    public function __construct() {
        // Verifica se o usuário está autenticado
        if (!Session::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
    }

    public function index() {
        $this->render('Home/index');
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/$view.php";
    }
}
