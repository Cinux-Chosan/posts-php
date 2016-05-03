<?php

require_once('postsConfig.php');
require_once('myLib.php');
if(IS_DEV) {
    allowCrossDomain(LOCAL_HOST);
}

$art_id = isset($_GET['art_id']) ? $_GET['art_id'] : 0;

$dbc = mysqli_connect(DB_SERVER, DB_ACCOUNT, DB_PWD, DB_NAME)
or die('Error connect to mysql server');

$query = "SELECT * FROM article_list WHERE article_id = $art_id LIMIT 1";

$result = mysqli_query($dbc, $query);

mysqli_close($dbc);

if($ret = mysqli_fetch_array($result)) {
    echo json_encode(Array(
        'msg' => '查询成功',
        'status' => true,
        'data' => $ret
    ));
} else {
    echo json_encode(Array(
        'msg' => '查询失败',
        'status' => false,
        'data' => null
    ));
}




