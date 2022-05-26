<?php
// +----------------------------------------------------------------------
// | 文件: WordrootController.php
// +----------------------------------------------------------------------
// | 功能: 提供 api接口
// +----------------------------------------------------------------------
// | 时间: 2021-11-15 16:20
// +----------------------------------------------------------------------
// | 作者: rangangwei<gangweiran@tencent.com>
// +----------------------------------------------------------------------

namespace app\controller;

use Error;
use Exception;
use app\model\Wordroot;
use think\response\Html;
use think\response\Json;
use think\facade\Log;
use think\Request;
use think\facade\Db;

class WordrootController
{
    /**
     * 获取 list-分页
     * @return Json
     */
    public function getList(Request $request): Json
    {
        try {
            // 获取参数
            $params = $request->param();
            $page = $params['page'] - 1;
            $size = $params['size'];
            $filters = isset($params['filters']) ? $params['filters'] : "";
            $keyword = isset($params['keyword']) ? $params['keyword'] : "";

            // 数据库操作
            // 过滤-暂支持1个多虑
            $whereFilters = array();
            if($filters) {
                $filters = json_decode($filters);
                // 遍历对象
                foreach($filters as $k => $v) {
                    array_push($whereFilters, $k);
                    array_push($whereFilters, 'in');
                    array_push($whereFilters, $v);
                }
            }
            // 关键字
            $whereLike = array();
            if($keyword) {
                $whereLike = array('wordroot|mean|translation', 'like', '%'.$keyword.'%');
            }

            $data = Db::table('wordroot')
                ->when($whereFilters, function ($query, $whereFilters) {
                    $query->where(array($whereFilters));
                })
                ->when($whereLike, function ($query, $whereLike) {
                    $query->where(array($whereLike));
                })
                ->order('wordroot', 'asc')
                ->page($page)->paginate($size);
            $list = $data->items();
            $total = $data->total();

            // 返回结果
            $result = '{ "list" : '.json_encode($list).', "total": '.$total.'  }';
            $result = json_decode($result);
            $res = make_succ_response($result);
            Log::write('getList rsp: '.json_encode($res));
            return json($res);
        } catch (Error $e) {
            $res = make_err_response("操作异常 " . $e->getMessage());
            Log::write('getList rsp: '.json_encode($res));
            return json($res);
        }
    }

    /**
     * 新增
     * @return Json
     */
    public function add(Request $request): Json
    {
        try {
            // 获取参数
            $params = $request->param();

            // 数据库操作
            $data = [
                'wordroot' => $params['wordroot'], 
                'mean' => isset($params['mean']) ? $params['mean'] : "", 
                'translation' => isset($params['translation']) ? $params['translation'] : "", 
                'example' => isset($params['example']) ? $params['example'] : "", 
                'category' => isset($params['category']) ? $params['category'] : "",
                'note' => isset($params['note']) ? $params['note'] : ""
            ];
            $result = Db::table('wordroot')->insert($data);

            // 返回结果
            $res = make_succ_response($result);
            Log::write('add rsp: '.json_encode($res));
            return json($res);
        } catch (Error $e) {
            $res = make_err_response("操作异常 " . $e->getMessage());
            Log::write('add rsp: '.json_encode($res));
            return json($res);
        }
    }

    /**
     * 修改
     * @return Json
     */
    public function edit(Request $request): Json
    {
        try {
            // 获取参数
            $params = $request->param();

            // 数据库操作
            $data = [
                'id' => $params['id'],
                'wordroot' => $params['wordroot'], 
                'mean' => isset($params['mean']) ? $params['mean'] : "", 
                'translation' => isset($params['translation']) ? $params['translation'] : "", 
                'example' => isset($params['example']) ? $params['example'] : "", 
                'category' => isset($params['category']) ? $params['category'] : "",
                'note' => isset($params['note']) ? $params['note'] : ""
            ];
            $result = Db::table('wordroot')->save($data);

            // 返回结果
            $res = make_succ_response($result);
            Log::write('edit rsp: '.json_encode($res));
            return json($res);
        } catch (Error $e) {
            $res = make_err_response("操作异常 " . $e->getMessage());
            Log::write('edit rsp: '.json_encode($res));
            return json($res);
        }
    }

    /**
     * 删除
     * @return Json
     */
    public function delete(Request $request): Json
    {
        try {
            // 获取参数
            $params = $request->param();

            // 数据库操作
            $result = Db::table('wordroot')->delete($params['id']);

            // 返回结果
            $res = make_succ_response($result);
            Log::write('edit rsp: '.json_encode($res));
            return json($res);
        } catch (Error $e) {
            $res = make_err_response("操作异常 " . $e->getMessage());
            Log::write('edit rsp: '.json_encode($res));
            return json($res);
        }
    }

}
