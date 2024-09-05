<?php

namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Model\User;
use App\Repository\UserRepository;

class LoginController extends Controller
{

  private $userRepository;

  public function __construct()
  {
    $this->userRepository = new UserRepository();
  }


  public function index()
  {
    $this->render('Login/index');
  }

  public function authenticate()
  {

    $user = new User();
    $user->username = $_POST['username'] ?? '';
    $user->password = $_POST['password'] ?? '';

    $errors = $this->validateForm($user);

    if (empty($errors)) {
      $username = filter_var($user->username, FILTER_SANITIZE_STRING);

      // Verifica se o usuário existe
      $userBD = $this->userRepository->listByUserName($username);

      if ($userBD && md5($user->password) === $userBD[0]->password) {
        Session::set('user_id', $userBD[0]->id);
        Session::set('username', $userBD[0]->username);
        header('Location: /home');  // Redireciona para a página principal
        exit();
      } else {
        $errors[] = 'Nome de usuário ou senha inválidos';
        $this->render('Login/index', ['errors' => $errors]);
        exit();
      }
    } else {
      $this->render('Login/index', ['errors' => $errors]);
      exit();
    }

    // Sanitizar entrada do usuário
    $username = filter_var($user->username, FILTER_SANITIZE_STRING);

    // Verifica se o usuário existe
    $userBD = $this->userRepository->listByUserName($username);

    if ($userBD && password_verify($user->password, $userBD['password'])) {
      Session::set('user_id', $userBD['id']);
      header('Location: /home');  // Redireciona para a página principal
    } else {
      $errors[] = 'Nome de usuário ou senha inválidos 2';
      $this->render('Login/index', ['errors' => $errors]);
    }
  }

  public function logout()
  {
    Session::destroy();
    header('Location: /login');
  }

  private function validateForm(User $user)
  {
    $errors = [];

    if (empty($user->username)) {
      $errors[] = 'Nome de usuário ou senha inválidos';
      return $errors;
    } elseif (strlen($user->username) < 3) {
      $errors[] = 'Nome de usuário ou senha inválidos';
      return $errors;
    }

    if (empty($user->password)) {
      $errors[] = 'Nome de usuário ou senha inválidos';
      return $errors;
    } elseif (strlen($user->password) < 5) {
      $errors[] = 'Nome de usuário ou senha inválidos';
      return $errors;
    }

    return $errors;
  }

  private function render($view, $data = [])
  {
    extract($data);
    require_once "../app/Views/$view.php";
  }
}
