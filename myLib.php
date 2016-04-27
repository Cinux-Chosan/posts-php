<?php

require_once('postsConfig.php');

if(IS_DEV) {
    allowCrossDomain(LOCAL_HOST);
}

function allowCrossDomain($flag) {
        $flag = isset($flag) ? $flag : '*';
        header("Access-Control-Allow-Origin: $flag");
        header("Access-Control-Allow-Credentials: true");
}


function myDB() {
    return mysqli_connect(DB_SERVER, DB_ACCOUNT , DB_PWD, DB_NAME)
    or die('Error connect to mysql server');
}



// 以json格式输出所有参数，并退出
function test(){
    if(!IS_DEV) return;
    $args = func_get_args();
    $arr = Array();
    foreach($args as $index => $value) {
        $arr['arg'.$index] = $value;
    }
    echo json_encode($arr);
    exit();
}



