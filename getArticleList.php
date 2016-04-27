<?php

require_once('postsConfig.php');
require_once('myLib.php');

$queryStart = isset($_GET['queryStart']) ?  $_GET['queryStart'] :  null;
$querySkip = isset($_GET['querySkip']) ?  $_GET['querySkip'] :  null;

if($queryStart >= 0 && $querySkip > 0) {

    $dbc = mysqli_connect(DB_SERVER, DB_ACCOUNT, DB_PWD, DB_NAME)
    or die('Error connect to mysql server');

    $queryEnd = $queryStart + $querySkip;



    $query = "SELECT * FROM article_list ORDER BY article_create_time LIMIT $queryStart,$querySkip";
    $queryAll = "SELECT COUNT(*) FROM article_list";
    $result = mysqli_query($dbc, $query);
    $resultAll = mysqli_query($dbc, $queryAll);

    list($total) = mysqli_fetch_row($resultAll);
    mysqli_close($dbc);
    $i = 0;
    $ret = Array(
        'list' => Array()
    );
    while($row = mysqli_fetch_array($result)) {
        $ret['list'][$i++] = $row;
    }

    if($i) {
        $ret['status'] = true;
        $ret['msg'] = '查询成功';
        $ret['pagebar'] = Array(
            "page" => floor($queryStart/$querySkip),
            "total" => $total,
            "limit" => $querySkip
        );
        echo json_encode($ret);
    } else {
        echo json_encode(Array(
            "status" => false,
            "msg" => "查询到0条数据",
            "pagebar" => Array(
                "page" => 0,
                "total" => 0,
                "limit" => $querySkip
            )
        ));
    }
} else {
    echo json_encode(Array(
        "status" => false,
        "msg" => "查询参数错误"
    ));
}