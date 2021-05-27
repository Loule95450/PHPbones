<?php
    class Users extends Controller
    {
        private $userModel;

        public function __construct()
        {
            $this->userModel = $this->loadModel('User');
        }

        public function login()
        {
            $data = [
                'title' => 'Login page',
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];

            // Vérifie si méthode POST est utilisé
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'usernameError' => '',
                    'passwordError' => ''
                ];

                if(empty($data['username'])){
                    $data['usernameError'] = 'Veuillez entrer un username';
                }

                if(empty($data['password'])){
                    $data['passwordError'] = 'Veuillez entrer un password';
                }

                if(empty($data['usernameError']) && empty($data['passwordError'])){
                    $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                    if($loggedInUser){
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['passwordError'] = 'Username ou password incorrect. Ressayez !!!';
                        $this->render('/users/login', $data);
                    }
                }
            } else {
                $data = [
                    'username' => '',
                    'password' => '',
                    'usernameError' => '',
                    'passwordError' => ''
                ];
            }
            $this->render('users/login', $data);
        }

        public function register()
        {
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPassword' => '',
                'confirmPasswordError' => ''
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirmPassword' => trim($_POST['confirmPassword']),
                    'usernameError' => '',
                    'emailError' => '',
                    'passwordError' => '',
                    'confirmPasswordError' => ''
                ];

                // Validation username & email
                $nameValidation = "/^[a-zA-Z0-9]*$/";
                $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

                if(empty($data['email'])){
                    $data['emailError'] = 'Veuillez entrer un email';
                } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $data['emailError'] = 'Veuillez entrer un email au bon format !!';
                } else {
                    if($this->userModel->findUserbyEmail($data['email'])){
                        $data['emailError'] = 'Email déjà utilisé !!';
                    }
                }

                if(empty($data['password'])){
                    $data['passwordError'] = 'Veuillez entrer un password';
                } elseif(strlen($data['password']) < 6) {
                    $data['passwordError'] = 'Le mot de passe doit contenir au moins 8 caractères';
                } elseif(preg_match($passwordValidation, $data['password'])){
                    $data['passwordError'] = 'Le mot de passes doit contenir au moins 1 chiffre';
                }

                if(empty($data['confirmPassword'])){
                    $data['confirmPasswordError'] = 'Veuillez entrer la confirmation de mot de passe';
                } else {
                    if($data['password'] != $data['confirmPassword']){
                        $data['confirmPasswordError'] = 'Les mot de passe ne correspondent pas !';
                    }
                }

                if(empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])){
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    if($this->userModel->register($data)){
                        header("Location: ".URL_ROOT."/users/login");
                    } else {
                        die('Une erreur est survenue !!');
                    }
                }
            }
            $this->render('/users/register', $data);
        }

        public function createUserSession($loggedInUser)
        {
            $_SESSION['user_id'] = $loggedInUser->user_id;
            $_SESSION['username'] = $loggedInUser->username;
            $_SESSION['email'] = $loggedInUser->email;
            header('Location: '.URL_ROOT.'/index');
        }

        public function logout()
        {
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            header('Location: '.URL_ROOT.'/users/login');
        }
    }