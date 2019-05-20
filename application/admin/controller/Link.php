<?php
namespace app\admin\controller;

use app\admin\model\Link as Mlink;
use app\admin\validate\Link as Vlink;

class Link extends common
{
    public function lst()
    {
        $linkdate = Mlink::order('sort asc')->paginate(5);
        $this->assign('linkdate',$linkdate);

        //排序
        if (request()->isPost()) {
            $date = input('post.');
            foreach ($date as $k => $v) {
                $res = Mlink::update(['id'=>$k,'sort'=>$v]);
            }

            if($res)
            {
                return $this->success('排序修改成功',url('link/lst'));
            }else{
                return $this->error('排序修改失败');
            }
        }

        return view('list');
    }   

    public function add()
    {
        if (request()->isPost()) {
            $date = input('post.');
            $Vlink = new Vlink();
            if (!$Vlink->scene('add')->check($date)) {
                return $this->error($Vlink->getError());
            }
            $res = Mlink::create($date);
            if($res)
            {
                return $this->success('链接添加成功',url('link/lst'));
            }else{
                return $this->error('链接添加失败');
            }

        }
        return view();
    }  



    public function update()
    {
        $id = input('id');
        $linkdate = Mlink::find($id);
        // dump($linkdate);die;
        $this->assign('linkdate',$linkdate);

        if (request()->isPost()) {
            $date = input('post.');
            $res = Mlink::update($date,['id'=>$date['id']]);
            if($res)
            {
                return $this->success('链接添加成功',url('link/lst'));
            }else{
                return $this->error('链接添加失败');
            }
        }

        return view();
    }
    
    
    public function del()
    {
        $id = input('id');
        $res= Mlink::destroy($id);
        if($res)
            {
                return $this->success('链接删除成功',url('link/lst'));
            }else{
                return $this->error('链接删除失败');
            }
    }  
}

?>