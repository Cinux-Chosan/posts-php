<?php

require_once('postsConfig.php');
require_once('myLib.php');

if(IS_DEV) {
    allowCrossDomain(LOCAL_HOST);
}

$art_id = isset($_POST['art_id']) ? $_POST['art_id'] : 0;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$name = isset($_POST['name']) ? $_POST['name'] : null;
$comments = isset($_POST['comments']) ? $_POST['comments'] : null;

if($art_id && $comments) {

    //test($art_id,$email,$name,$comments);

    $dbc = mysqli_connect(DB_SERVER, DB_ACCOUNT, DB_PWD, DB_NAME)
    or die('Error connect to mysql server');


    $query = "INSERT INTO comment_list(art_id,comment_text,comment_create_time,email,name) ".
        "values('$art_id','$comments',NOW(),'$email','$name')";


    $result = mysqli_query($dbc,$query);

    mysqli_close($dbc);

    if($result) {
        echo json_encode(Array(
            'msg' => '添加评论成功',
            'status' => true
        ));
    } else {
        echo json_encode(Array(
            'msg' => '添加评论失败',
            'status' => false
        ));
    }
} else {
    echo json_encode(Array(
        'msg' => '评论为空或者文章ID非法',
        'status' => false
    ));
}
