<?php
    include './classes/user.php';

    session_start();

    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
        $user = new User($_POST);
        $authData = $user->readUser();
        setcookie('user', json_encode($authData), time() + 3600);
        $_SESSION['user'] = $authData;
        echo json_encode($authData);
    }
    exit;
    
?>