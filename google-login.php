<?php

    if (!isset($_SESSION)) {
        session_start();
    }

    require_once realpath(__DIR__ . '/vendor/autoload.php');
    require_once "DataProvider.php";
    /**
     * SET CONNECT 
     */

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

    $dotenv->load();
    

    /**
     * CALL GOOGLE API
     */
    require_once 'vendor/autoload.php';

    $client = new Google_Client();
    $client->setClientId($_ENV["GOOGLE_ID_APP"]);
    $client->setClientSecret($_ENV["GOOGLE_SECRET_KEY"]);
    $client->setRedirectUri($_ENV["GOOGLE_APP_CALLBACK_URL"]);
    $client->addScope("email");
    $client->addScope("profile");
   
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
       // print_r($token);
        $client->setAccessToken($token['access_token']);

        // get profile info
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email =  $google_account_info->email;
        $name =  $google_account_info->name;
        $id = $google_account_info->id;
        $picture = $google_account_info->picture;
       // print_r($google_account_info);
       /**
        * CHECK EMAIL AND NAME IN DATABASE
        */
        $sqlFind = "select * from user_account where uid = '$id' and email = '$email'";
        $listFind = DataProvider::execQuery($sqlFind);
        $numRow = mysqli_num_rows($listFind);
        if($numRow>0){
            $_SESSION['nameUser'] = $name;
            $_SESSION['emailUser'] = $email;
            $_SESSION['idUser'] = $id;
            $_SESSION['avtUser'] = $picture;
            $_SESSION['loggedWith'] = 'Google';


            header('Location: /');
        }
        else{

            $_SESSION['nameUser'] = $name;
            $_SESSION['emailUser'] = $email;
            $_SESSION['idUser'] = $id;
            $_SESSION['avtUser'] = $picture;
            $_SESSION['loggedWith'] = 'Google';

            $sql = "insert into user_account values ('','$id','$email','','$name','',NULL,NOW(),NOW())";
            DataProvider::execQuery($sql);
            header('Location: /');
        }

       
    } else {
        /**
         * IF YOU DON'T LOGIN GOOGLE
         * YOU CAN SEEN AGAIN GOOGLE_APP_ID, GOOGLE_APP_SECRET, GOOGLE_APP_CALLBACK_URL
         */
        $redirect = $client->createAuthUrl();
        header("Location: $redirect");
    }