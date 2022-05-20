<?php
    class Users extends Controller
    {
        /* It's creating a private variable. */
        private $usersModel;

        public function __construct()
        {
            /* It's loading the model. */
            $this->usersModel = $this->loadModel('UsersModel');
        }

        /**
         * It's checking if the form is submitted, if it is, it's checking if the username and password are empty, if they
         * are not, it's checking if the user is logged in, if he is, it's creating a session for him, if he is not, it's
         * displaying an error message
         */
        public function login()
        {
            /* It's creates a array communicable with the view . */
            $data = [
                'title' => 'Login page',
                'username' => '',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];

            /* It's checking if the form is submitted. */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                /* It's creating an array with the data from the form. */
                $data = [
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'usernameError' => '',
                    'passwordError' => ''
                ];

                /* It's checking if the username is empty. */
                if(empty($data['username'])){
                    $data['usernameError'] = 'Veuillez entrer un username';
                }

                /* It's checking if the password is empty. */
                if(empty($data['password'])){
                    $data['passwordError'] = 'Veuillez entrer un password';
                }

                /* It's checking if the user is logged in. */
                if(empty($data['usernameError']) && empty($data['passwordError'])){
                    /* It's checking if the user is logged in. */
                    $loggedInUser = $this->usersModel->login($data['username'], $data['password']);

                    /* It's checking if the user is logged in. */
                    if($loggedInUser){
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['passwordError'] = 'Username ou password incorrect. Ressayez !!!';
                        $this->render('/users/login', $data);
                    }
                }
            } else {
                /* It's creating an array with the data from the form. */
                $data = [
                    'username' => '',
                    'password' => '',
                    'usernameError' => '',
                    'passwordError' => ''
                ];
            }

            /* It's rendering the view. */
            $this->render('users/login', $data);
        }

        /**
         * It's checking if the user is registered, if he is, it's redirecting him to the login page, if he is not, it's
         * displaying an error message
         */
        public function register()
        {
            /* It's creating an array with the data from the form. */
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

            /* It's checking if the user is registered, if he is, it's redirecting him to the login page, if he is not,
            it's displaying an error message. */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                /* It's creating an array with the data from the form. */
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

                /* It's checking if the username and password are valid. */
                $nameValidation = "/^[a-zA-Z0-9]*$/";
                $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

                /* It's checking if the email is empty, if it is, it's displaying an error message, if it is not, it's
                checking if the email is valid, if it is not, it's displaying an error message, if it is, it's checking
                if the email is already used, if it is, it's displaying an error message. */
                if(empty($data['email'])){
                    $data['emailError'] = 'Veuillez entrer un email';
                } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $data['emailError'] = 'Veuillez entrer un email au bon format !!';
                } else {
                    /* It's checking if the email is already used. */
                    if($this->usersModel->findUserbyEmail($data['email'])){
                        $data['emailError'] = 'Email déjà utilisé !!';
                    }
                }

                /* It's checking if the password is empty, if it is, it's displaying an error message, if it is not, it's
                checking if the password is less than 6 characters, if it is, it's displaying an error message, if it is
                not, it's checking if the password is valid, if it is not, it's displaying an error message. */
                if(empty($data['password'])){
                    $data['passwordError'] = 'Veuillez entrer un password';
                } elseif(strlen($data['password']) < 6) {
                    $data['passwordError'] = 'Le mot de passe doit contenir au moins 8 caractères';
                } elseif(preg_match($passwordValidation, $data['password'])){
                    $data['passwordError'] = 'Le mot de passes doit contenir au moins 1 chiffre';
                }

                /* It's checking if the password and the confirm password are the same. */
                if(empty($data['confirmPassword'])){
                    $data['confirmPasswordError'] = 'Veuillez entrer la confirmation de mot de passe';
                } else {
                    if($data['password'] != $data['confirmPassword']){
                        $data['confirmPasswordError'] = 'Les mot de passe ne correspondent pas !';
                    }
                }

                /* It's checking if the username, email, password and confirm password are valid, if they are, it's hashing
                the password, it's checking if the user is registered, if he is, it's redirecting him to the login page,
                if he is not, it's displaying an error message. */
                if(empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])){
                    /* It's hashing the password. */
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    /* It's checking if the user is registered, if he is, it's redirecting him to the login page, if he is
                    not, it's displaying an error message. */
                    if($this->usersModel->register($data)){
                        /* It's redirecting the user to the login page. */
                        header("Location: ".URL_ROOT."/users/login");
                    } else {
                        die('Une erreur est survenue !!');
                    }
                }
            }

            /* It's rendering the view. */
            $this->render('/users/register', $data);
        }

        /**
         * It's creating a session for the user and redirecting the user to the home page
         *
         * @param loggedInUser It's the user object that we got from the database.
         */
        public function createUserSession($loggedInUser)
        {
            /* It's creating a session for the user. */
            $_SESSION['user_id'] = $loggedInUser->user_id;
            $_SESSION['username'] = $loggedInUser->username;
            $_SESSION['email'] = $loggedInUser->email;

            /* It's redirecting the user to the home page. */
            header('Location: '.URL_ROOT);
        }

        /**
         * It's destroying the session and redirecting the user to the login page
         */
        public function logout()
        {
            /* It's destroying the session. */
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);

            /* It's redirecting the user to the login page. */
            header('Location: '.URL_ROOT.'/users/login');
        }
    }