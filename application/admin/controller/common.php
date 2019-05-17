<?php
namespace app\admin\controller;

use think\Controller;

class common extends Controller
{
    public function _initialize()
    {
        if(!session('id') || !session('username')){
            return $this->error('请先登录',url('login/index'));
        }
    }
}

?>