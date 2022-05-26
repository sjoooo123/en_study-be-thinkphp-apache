<?php
// +----------------------------------------------------------------------
// | 文件: common.php
// +----------------------------------------------------------------------
// | 功能: 系统公共文件
// +----------------------------------------------------------------------

function make_succ_response($data=null){
  return [
    "code" => 1,
    "result" =>  $data,
    "msg" => "操作成功"
  ];
}

function make_err_response($err_msg='服务器异常'){
  return [
    "code" => -1,
    "msg" => $err_msg
  ];
}

