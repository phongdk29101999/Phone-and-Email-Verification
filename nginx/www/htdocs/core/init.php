<?php
    include "config.php";

    // auto load
    spl_autoload_register(function ($class) {
        require_once "classes/{$class}.php";
    });

    // session
    session_start();
