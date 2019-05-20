<?php

namespace app\admin\validate;
use think\Validate;
class Link extends Validate
{
    protected $rule = [
        'title'  =>  'require|unique:link',
        'url' =>  'require|url',
    ];
    
    protected $message = [
        'title.require'  =>  '链接标题必须填写',
        'title.unique'  =>  '链接标题重复',
        'url.require'  =>  '链接必须填写',
        'url.url'  =>  '链接格式错误',
    ];
    
    protected $scene = [
        'add'   =>  ['title','url'],
        'edit'  =>  ['title','url'],
    ];    
}