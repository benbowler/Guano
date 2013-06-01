<?php

    // clear all session data
    // session_unset();

    include("lib/codebird.php");

    $guano['appkey'] = "j9ncBrZJXCZo4q8UPoA";
    $guano['appsecret'] = "66j5R6UIqVe1hRV4PjkeXKxlboaVpluzl38uD4KWJw";

    \Codebird\Codebird::setConsumerKey($guano['appkey'], $guano['appsecret']);
    $cb = \Codebird\Codebird::getInstance();
    //$cb->setToken($guano['usertoken'], $guano['usertokensecret']);

    session_start();

    if (! isset($_GET['oauth_verifier'])) {
        // gets a request token
        $reply = $cb->oauth_requestToken(array(
            //'oauth_callback' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
        ));

        // stores it
        $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
        $_SESSION['oauth_token'] = $reply->oauth_token;
        $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;

        // gets the authorize screen URL
        $auth_url = $cb->oauth_authorize();
        header('Location: ' . $auth_url);
        die();

    } elseif (! isset($_SESSION['oauth_verified'])) {
        // gets the access token
        $cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        $reply = $cb->oauth_accessToken(array(
            'oauth_verifier' => $_GET['oauth_verifier']
        ));
        // var_dump($reply);

        // store user details too.
        $_SESSION['user_id'] = $reply->user_id;
        $_SESSION['screen_name'] = $reply->screen_name;

        // store the authenticated token, which may be different from the request token (!)
        $_SESSION['oauth_token'] = $reply->oauth_token;
        $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
        $cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        $_SESSION['oauth_verified'] = true;

    }

    // store account credentials
    var_dump($_SESSION);

    $connection_string = parse_url($_SERVER['CLEARDB_DATABASE_URL']);

    var_dump($connection_string);

    $db = new mysqli($connection_string['host'], $connection_string['user'], $connection_string['pass'], str_replace('/', '', $connection_string['path']) );

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

    $sql = "INSERT INTO oauth (user_id, screen_name, oauth_token, oauth_token_secret) 
            VALUES ('{$_SESSION['user_id']}', '{$_SESSION['screen_name']}', '{$_SESSION['oauth_token']}', '{$_SESSION['oauth_token_secret']}')
                ON DUPLICATE KEY UPDATE user_id = user_id";

    $db->query($sql);

