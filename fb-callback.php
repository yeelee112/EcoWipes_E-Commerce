<?php
    if(!session_id()) {
        session_start();
    }

    require_once realpath(__DIR__ . '/vendor/autoload.php');

    // $dotenv->required(['DB_SERVER', 'DB_DATABASE', 'DB_USER', 'DB_PASS']);
    require_once('Facebook/autoload.php');

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $appID = $_ENV["FACEBOOK_ID_APP"];
    $fb = new Facebook\Facebook([
        'app_id' => $appID,
        'app_secret' => $_ENV["FACEBOOK_SECRET_KEY"],
        'default_graph_version' => 'v2.9',
    ]);

    $helper = $fb->getRedirectLoginHelper();
    try {
        $accessToken = $helper->getAccessToken();
        $response = $fb->get('/me?fields=id,name,email,picture.width(48).height(48)', $accessToken);
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    if (!isset($accessToken)) {
        if ($helper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $helper->getError() . "\n";
            echo "Error Code: " . $helper->getErrorCode() . "\n";
            echo "Error Reason: " . $helper->getErrorReason() . "\n";
            echo "Error Description: " . $helper->getErrorDescription() . "\n";
        } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
        }
        header("Location: /");
        exit;
    }
    // Logged in
    $me = $response->getGraphUser();
    // echo 'Logged in as: ' . $me->getName();
    // echo 'ID:' . $me->getId();
    // echo 'Email:' . $me->getEmail();
    // echo 'Avatar:' . $me->getPicture();

    $email = $me->getEmail();
    $fullname = $me->getName();
    $id = $me->getId();

    $_SESSION['fb_access_token'] = (string) $accessToken;
    $_SESSION['nameUser'] = $fullname;
    $_SESSION['emailUser'] = $email;
    $_SESSION['idUser'] = $id;
    $_SESSION['loggedWith'] = 'Facebook';

    require_once 'DataProvider.php';

    $sqlFind = "select * from user_account where uid = '$id' and email = '$email'";
    $listFind = DataProvider::execQuery($sqlFind);

    $numRow = mysqli_num_rows($listFind);

    if($numRow < 1){
        $sql = "insert into user_account values ('','$id','$email','','$fullname','',NULL,NOW(),NOW())";
        DataProvider::execQuery($sql);
    }
   

    header("Location: /");
?>