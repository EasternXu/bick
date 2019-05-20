<?php
namespace app\admin\controller;

use app\admin\model\Admin as Madmin;
use think\Controller;
use app\admin\validate\Admin as Vadmin;
use app\admin\model\Auth_group;

class Admin extends common
{
    public function lst()
    {   
        //获取管理员信息
        $adminData = Madmin::paginate(5);
        //获取权限信息
        $auth = new Auth;
        foreach($adminData as $k=>$v){
            // dump($v['id']);
            $grouptitle = $auth->getGroups($v['id']);
            // dump($grouptitle);die;
            if($grouptitle){
                $_grouptitle  = $grouptitle['0']['title'];
                // dump($_grouptitle);die;
                
            }else {
                $_grouptitle = '';
            }
            $v['grouptitle'] = $_grouptitle;
        }
        
        $this->assign([
            'adminuser'=>$adminData,
        ]);
        // dump($data);die;s

        return view('list');
    }
    public function add()
    {
        //获取用户组信息
        $groupdate = Auth_group::select();
        $this->assign("groupdate",$groupdate);
        if(request()->isPost())
        {   

            $data = input('post.');
            $data['password'] = md5($data['password']);
            $Madmin = new Madmin();
            $res = $Madmin->allowField(true)->save($data);
            $uid = $Madmin->id;
            $group_admin_data['uid'] = $uid;
            $group_admin_data['group_id'] =$data['group_id'] ;
            $res = db('auth_group_access')->insert($group_admin_data);
            if($res)
            {
                return $this->success('管理员添加成功',url('admin/lst'));
            }else{
                return $this->error($res);
            }
        }
       
        return view();
    }
    public function edit($id)
    {   
        //获取管理员信息
        $info = Madmin::get($id);
         //获取用户组信息
         $groupdate = Auth_group::select();
        //获取gid
         $gid = $info->auth_group_access->group_id;
         $this->assign([
             "groupdate"=>$groupdate,
             'admininfo'=>$info,
             'gid'=>$gid
        ]);
        
        if(request()->isPost())
        {
            $date = input('post.');
            if(!$date['password']){
                $info = Madmin::get($date['id']);
                $date['password'] = $info['password'];
            }else{
                $date['password'] =md5($date['password']);
            }
            $Madmin = new Madmin();
            $res = $Madmin->allowField(true)->save($date,['id'=>$date['id']]);
            $admin_group_res = db('auth_group_access')->where('uid',$date['id'])->update(['group_id'=>$date['group_id']]);
            if($res !==false  && $admin_group_res !== false)
            {
                return $this->success('管理员修改成功',url('admin/lst'));
            }else{
                return $this->error('管理员修改失败');
            }
        }
        

        return view('');
    }

    public function del($id)
    {
        $Madmin = new Madmin();
        $res = $Madmin->del($id);
        $group_admin_res =db('auth_group_access')->where('uid',$id)->delete(); 
        if($res && $group_admin_res)
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