<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

// 获取当前计数
Route::get('/api/count', 'index/getCount');

// 更新计数，自增或者清零
Route::post('/api/count', 'index/updateCount');

// 分类
Route::get('/api/category/list', 'CategoryController/getList');

// 词根
Route::get('/api/wordroot/list', 'WordrootController/getList');
Route::post('/api/wordroot/add', 'WordrootController/add');
Route::post('/api/wordroot/edit', 'WordrootController/edit');
Route::post('/api/wordroot/delete', 'WordrootController/delete');

// 前缀
Route::get('/api/prefix/list', 'PrefixController/getList');
Route::post('/api/prefix/add', 'PrefixController/add');
Route::post('/api/prefix/edit', 'PrefixController/edit');
Route::post('/api/prefix/delete', 'PrefixController/delete');

// 后缀
Route::post('/api/suffix/add', 'SuffixController/add');
Route::get('/api/suffix/list', 'SuffixController/getList');
Route::post('/api/suffix/edit', 'SuffixController/edit');
Route::post('/api/suffix/delete', 'SuffixController/delete');

// 通用
Route::get('/api/common/relatedList', 'CommonController/getRelatedList');

