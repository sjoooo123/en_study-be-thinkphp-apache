<?php
// +----------------------------------------------------------------------
// | 文件: index.php
// +----------------------------------------------------------------------
// | 功能: mysql数据库表model
// +----------------------------------------------------------------------
// | 时间: 2021-11-15 16:20
// +----------------------------------------------------------------------
// | 作者: rangangwei<gangweiran@tencent.com>
// +----------------------------------------------------------------------

namespace app\model;

use think\Model;

// Prefix 定义数据库model
class Prefix extends Model
{
    protected $table = 'prefix';
    public $id;
    public $affix;
    public $translation;
    public $example;
    public $category;
    public $note;
    public $createdAt;
    public $updateAt;
}