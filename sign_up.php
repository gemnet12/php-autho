<?php 
include './classes/user.php';

session_start();

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    $user = new User($_POST);
    if($user->validateUser()) {
        $user->createUser();
        setcookie('user', json_encode($user->userData), time() + 3600);
        $_SESSION['user'] = $user->userData;
    } else {
        echo json_encode($user->userErrors);
    }
    exit;
}