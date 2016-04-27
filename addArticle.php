<?php

require_once('postsConfig.php');
require_once('myLib.php');

if(IS_DEV) {
    allowCrossDomain(LOCAL_HOST);
}

session_start();
$userName = isset($_SESSION['userName']) ?  $_SESSION['userName'] :  null;
$userId = isset($_SESSION['userId']) ?  $_SESSION['userId'] :  null;
$artTitle = isset($_POST['articleTitle']) ? $_POST['articleTitle'] : null;
$artText = isset($_POST['articleText']) ? $_POST['articleText'] : null;

if($userName && $userId) {

    $dbc = mysqli_connect(DB_SERVER, DB_ACCOUNT , DB_PWD, DB_NAME)
        or die('Error connect to mysql server');

    $artTitle = mysqli_real_escape_string($dbc, trim($artTitle));
    $artText = mysqli_real_escape_string($dbc, trim($artText));
    $userId = mysqli_real_escape_string($dbc, trim($userId));

    if($artTitle && $artText && $userId) {
        $query = "INSERT INTO article_list(article_title, article_text,article_create_time, article_user_id) VALUES('$artTitle', '$artText', NOW(), '$userId') ";
        $result = mysqli_query($dbc, $query);
        if ($result) {
            echo json_encode(Array(
                "status" => true,
                "msg" => "添加文章成功"
            ));
        } else {
            echo json_encode(Array(
                "status" => false,
                "msg" => "添加文章失败"
            ));
        }
    } else {
        echo json_encode(Array(
            "status" => false,
            "msg" => "标题或者文章内容不能为空"
        ));
    }
    mysqli_close($dbc);
} else {
    echo json_encode(Array(
        "status" => false,
        "msg" => "用户未登录"
    ));
}