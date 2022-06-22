<?php
    include "../core/init.php";

    // check if user logged in
    if (!$userObject->isLoggedIn()) {
        $userObject->redirect("index.php");
    } else {
        $userObject->logout();
    }
?>