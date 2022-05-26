<?php
// +----------------------------------------------------------------------
// | 文件: CategoryController.php
// +----------------------------------------------------------------------
// | 功能: 提供todo api接口
// +----------------------------------------------------------------------
// | 时间: 2021-11-15 16:20
// +----------------------------------------------------------------------
// | 作者: rangangwei<gangweiran@tencent.com>
// +----------------------------------------------------------------------

namespace app\controller;

use Error;
use Exception;
use app\model\Category;
use think\response\Html;
use think\response\Json;
use think\facade\Log;

class CategoryController
{
    /**
     * 获取todo list
     * @return Json
     */
    public function getList(): Json
    {
        try {
            $data = (new Category)->select();

            $result = '{ "list" : '.$data.'  }';
            $result = json_decode($result);
            
            $res = make_succ_response($result);
            Log::write('getList rsp: '.json_encode($res));
            return json($res);
        } catch (Error $e) {
            $res = make_err_response("操作异常" . $e->getMessage());
            Log::write('getList rsp: '.json_encode($res));
            return json($res);
        }
    }

}
