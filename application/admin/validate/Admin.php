<?php

namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
    protected $rule = [
        'name'  =>  'require|max:5|unique:admin',
        'password' =>  'require',
    ];
    
    protected $message = [
        'name.require'  =>  '用户名必须填写',
        'name.max'  =>  '用户名长度不能大于5',
        'name.unique'  =>  '用户名重复',
        'password.require'  =>  '密码名必须填写',
    ];
    
    protected $scene = [
        'add'   =>  ['name','password'],
        'edit'  =>  ['name',],
    ];    
}