<?php
    function redirect($url, $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }

    session_start();
    session_destroy();

    redirect('/task/8');