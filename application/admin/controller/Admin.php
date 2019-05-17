<?php
namespace app\admin\controller;

use app\admin\model\Admin as Madmin;
use think\Controller;

class Admin extends common
{
    public function lst()
    {
        $Madmin = new Madmin();
        $data = $Madmin->lst();
        $this->assign('adminuser',$data);
        // dump($data);die;s

        return view('list');
    }
    public function add()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $Madmin = new Madmin();
            $res = $Madmin->add($data);
            if($res)
            {
                return $this->success('管理员添加成功',url('admin/lst'));
            }else{
                return $this->error('管理员添加失败',url('admin/add'));
            }
        }
       
        return view();
    }
    public function edit($id)
    {
        $info = db('admin')->find($id);
        $this->assign('admininfo',$info);

        if(request()->isPost())
        {
            $Madmin = new Madmin();
            $res = $Madmin->edit();
            if($res)
            {
                return $this->success('管理员修改成功',url('admin/lst'));
            }else{
                return $this->error('管理员修改失败',url('admin/edit'));
            }
        }
        

        return view('');
    }

    public function del($id)
    {
        $Madmin = new Madmin();
        $res = $Madmin->del($id);
        if($res)
        {
            return $this->success('管理员删除成功',url('admin/lst'));
        }else{
            return $this->error('管理员删除失败',url('admin/lst'));
        }
    }

    public function logout()
    {
        session(null);
        return $this->error('退出成功',url('login/index'));
    }
}

?>