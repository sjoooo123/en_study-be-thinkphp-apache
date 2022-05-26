<?php
// +----------------------------------------------------------------------
// | 文件: CommonController.php
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
use think\response\Html;
use think\response\Json;
use think\facade\Log;
use think\Request;
use think\facade\Db;

class CommonController
{
    /**
     * 获取 词条相关列表
     * @return Json
     */
    public function getRelatedList(Request $request): Json
    {
        try {
            // 获取参数
            $params = $request->param();

            // 类型type="suffix"为后缀，type="prefix"为前缀，type="wordroot"为词根，对应相应的数据库
            $type = $params['type'];
            // 词缀
            $affix = isset($params['affix']) ? $params['affix'] : "";
            // 词根
            $wordroot = isset($params['wordroot']) ? $params['wordroot'] : "";
            // 英文词义
            $mean = isset($params['mean']) ? $params['mean'] : "";
            // 中文词义
            $translation = isset($params['translation']) ? $params['translation'] : "";

            // 数据库操作
            // 词缀
            $whereAffix = array();
            if($affix) {
                $affixArr = explode( ",", $affix);
                foreach($affixArr as $k => $v) {
                    array_push($whereAffix, array('affix', 'like', '%'.$v.'%'));
                }
            }
            // 词根
            $whereWordroot = array();
            if($wordroot) {
                $wordrootArr = explode( ",", $wordroot);
                foreach($wordrootArr as $k => $v) {
                    array_push($whereWordroot, array('wordroot', 'like', '%'.$v.'%'));
                }
            }
            // 英文词义
            $whereMean = array();
            if($mean) {
                $meanArr = explode( ",", $mean);
                foreach($meanArr as $k => $v) {
                    array_push($whereMean, array('mean', 'like', '%'.$v.'%'));
                }
            }
            // 中文词义
            $whereTranslation = array();
            if($translation) {
                str_replace(',', '，', $translation);
                str_replace('、', '，', $translation);
                str_replace('；', '，', $translation);
                $translationArr = explode( "，", $translation);
                foreach($translationArr as $k => $v) {
                    array_push($whereTranslation, array('translation', 'like', '%'.$v.'%'));
                }
            }

            // 排序字段
            $fieldStr =  $type === 'wordroot' ? 'wordroot' : 'affix';

            $list = Db::table($type)
                ->when($whereAffix, function ($query, $whereAffix) {
                    $query->whereOr(array($whereAffix));
                })
                ->when($whereWordroot, function ($query, $whereWordroot) {
                    $query->whereOr(array($whereWordroot));
                })
                ->when($whereMean, function ($query, $whereMean) {
                    $query->whereOr(array($whereMean));
                })
                ->when($whereTranslation, function ($query, $whereTranslation) {
                    $query->whereOr(array($whereTranslation));
                })
                ->order($fieldStr, 'asc')
                ->select();

            // 返回结果
            $result = '{ "list" : '.json_encode($list).'  }';
            $result = json_decode($result);
            $res = make_succ_response($result);
            Log::write('getRelatedList rsp: '.json_encode($res));
            return json($res);
        } catch (Error $e) {
            $res = make_err_response("操作异常 " . $e->getMessage());
            Log::write('getRelatedList rsp: '.json_encode($res));
            return json($res);
        }
    }

}
