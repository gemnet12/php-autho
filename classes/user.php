<?php

    class User {

        const pathDB = 'database.json';

        private $sault = 'sault';

        public function __construct($userData)
        {
            $this->userData = $userData;
            $this->handleDB = fopen(self::pathDB, 'r+'); 
            $this->instance = $this->createDbInstance();
        }
        //Create
        public function createUser() {
            if (isset($this->validated)) {
                $this->userData['password'] = md5($this->userData['password'] . $this->sault);
                unset($this->userData['confirm-password']);
                $this->insertInstanceToDb();
            }   
        }

        public function readUser() {
            $userByLogin = $this->checkValueInUser('login', $this->userData['login']);
            $userErrors = ['validation' => false];
            if($userByLogin) {
                if ($userByLogin['password'] === md5($this->userData['password'] . $this->sault)) {
                    $userByLogin['validation'] = true;
                    return $userByLogin;
                }      
                $userErrors['password'] = 'Wrong password';
                return $userErrors;
                
            } else {
                $userErrors['login'] = 'Login does not exist';
                return $userErrors;
            }

        }
        
        public function updateUser($userLogin, $userField, $userNewValue) {
            foreach($this->instance as $user){
                if(isset($user['login']) && $user['login'] === $userLogin) {
                    $user[$userField] = $userNewValue;
                }
            }
        }

        public function deleteUser($userLogin) {
            foreach($this->instance as $user){
                if(isset($user['login']) && $user['login'] === $userLogin) {
                    $key = array_search($user, $this->instance);
                    unset($this->instance[$key]);
                }
            }
        }

        public function validateUser() {
            $userErrors = [];
            //login
            if (!$this->validateLogin()) {
                $userErrors['login'] = 'Login invalid or already exist';
            }
            //password
            if (!$this->validatePassword()) {
                $userErrors['password'] = 'Invalid password';
            }
            //confrim password
            if (!$this->confirmPassword()) {
                $userErrors['confirm-password'] = 'Passwords are not the same';
            }

            if (!$this->validateEmail()) {
                $userErrors['email'] = 'Email is invalid';
            }
            if (!$this->validateName()) {
                $userErrors['name'] = 'Name is invalid';
            }

            if (empty($userErrors)) {
                    $this->validated = true;
                    echo json_encode(['validation' => true]);
                    return true;
                } else {
                    $userErrors['validation'] = false;
                    $this->userErrors = $userErrors;
                    return false;
                }
        }
        //Private
        private function insertInstanceToDb() {
            $this->insert('users', $this->userData);
        }

        private function validateLogin() {
            $login = $this->userData['login'];
            if (!preg_match('/[^a-zA-Z0-9]/', $login) && strlen($login) >= 6 && !$this->checkValueInUser('login', $login)) {
                return true;
            }
            return false;
        }

        private function validatePassword() {
            $password = $this->userData['password'];
            if ($password != '') {
                return 
                strlen($password) > 6 && 
                preg_match('/[a-zA-Z]/', $password) &&
                preg_match('/[0-9]/', $password) &&
                !preg_match('/[^a-zA-Z0-9]/', $password);
            }
            return false;
        }

        private function confirmPassword() {
            return $this->userData['password'] === $this->userData['confirm-password'];
        }

        private function validateEmail() {
            $email = $this->userData['email'];
            if(!$this->checkValueInUser('email', $email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            return false;
        }

        private function validateName() {
            $name = $this->userData['name'];
            return strlen($name) >= 2 && !preg_match('/[^a-zA-Z]/', $name);
            
        }

        private function checkValueInUser($keyName ,$uniqueValue) {
            foreach($this->instance['users'] as $user ) {
                if(isset($user[$keyName]) && $user[$keyName] === $uniqueValue) {
                    return $user;
                }
            }
            return false;
        }

        private function createDbInstance() {
            $json = fread($this->handleDB, filesize(self::pathDB));
            $instance = json_decode($json, true);
            if (!array_key_exists('users', $instance)) {
                $instance['users'] = [];
            }
            return $instance;
        }

        private function insert($tableName, $data) {
            array_push($this->instance[$tableName], $data);
            ftruncate($this->handleDB, 4);
            rewind($this->handleDB);
            fwrite($this->handleDB, json_encode($this->instance));
        }
    }
?>