<?php


require_once('postsConfig.php');
require_once('myLib.php');

if(IS_DEV) {
    allowCrossDomain(LOCAL_HOST);
}

$art_id = isset($_GET['art_id']) ? $_GET['art_id'] : 0;

if($art_id) {
    $dbc = mysqli_connect(DB_SERVER, DB_ACCOUNT, DB_PWD, DB_NAME)
    or die('Error connect to mysql server');


    $query = "INSERT INTO article_list(article_praise_num) VALUES ('')"; //article_praise_num 加1


    $result = mysqli_query($dbc,$query);

    mysqli_close($dbc);
}

