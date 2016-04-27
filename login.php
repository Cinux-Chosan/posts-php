<?php

require_once('postsConfig.php');
require_once('myLib.php');

if(IS_DEV) {
    allowCrossDomain(LOCAL_HOST);
}

$userName = isset($_POST['userName']) ? $_POST['userName'] : null;
$userPwd = isset($_POST['userPwd']) ? $_POST['userPwd'] : null;

function login($userName, $userPwd) {
    if($userName && $userPwd) {
        $dbc = mysqli_connect(DB_SERVER, DB_ACCOUNT , DB_PWD, DB_NAME)
        or die('Error connect to mysql server');

        $userName = mysqli_real_escape_string($dbc, trim($userName));
        $userPwd = mysqli_real_escape_string($dbc, trim($userPwd));

        $query = "SELECT * FROM ".TABLE_USER_LIST." WHERE user_name = '$userName' AND user_pwd = SHA('$userPwd') LIMIT 1";
        $result = mysqli_query($dbc, $query)
        or die('Error querying database!');
        mysqli_close($dbc);
        return mysqli_fetch_array($result);
    }
    else {
        return false;
    }
}

if($ret = login($userName, $userPwd)) {
    session_start();
    $_SESSION['userName'] = $userName;
    $_SESSION['userId'] = $ret['user_id'];
    echo json_encode(Array(
        "status" => true
    ));
} else {
    echo json_encode(Array(
        "status" => false,
        "msg" => "用户名或密码错误"
    ));
}