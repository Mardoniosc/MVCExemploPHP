<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {
    public function index() {
        $this->render('Home/index');
    }

    private function render($view, $data = []) {
        extract($data);
        require_once "../app/Views/$view.php";
    }
}
