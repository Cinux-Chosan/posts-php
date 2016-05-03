<?php

require_once('postsConfig.php');
require_once('myLib.php');

if(IS_DEV) {
    allowCrossDomain(LOCAL_HOST);
}

$art_id = isset($_GET['art_id']) ? $_GET['art_id'] : 0;

if($art_id) {

    //test($art_id,$email,$name,$comments);

    $dbc = mysqli_connect(DB_SERVER, DB_ACCOUNT, DB_PWD, DB_NAME)
    or die('Error connect to mysql server');


    $query = "SELECT * FROM comment_list WHERE art_id = $art_id ORDER BY comment_create_time";


    $result = mysqli_query($dbc,$query);

    mysqli_close($dbc);


    $ret = Array(
        'list' => Array()
    );

    $count = 0;

    while($row = mysqli_fetch_object($result)) {
        $ret['list'][$count++] = $row;
    }

    if($count) {
        $ret['msg'] = '获取评论成功';
        $ret['status'] = true;
        echo json_encode($ret);
    } else {
        echo json_encode(Array(
            'msg' => '未获取到评论',
            'status' => true,
            'list' => Array()
        ));
    }
} else {
    echo json_encode(Array(
        'msg' => '文章ID非法',
        'status' => false
    ));
}
