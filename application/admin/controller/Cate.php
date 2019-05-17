<?php
namespace app\admin\controller;
use app\admin\model\Cate as Mcate;

class Cate extends common
{
    protected $beforeActionList= [
        'delchildren'=>['only'=>'del'],
    ];
    public function lst()
    {
        $Mcate = new Mcate();
        $date = $Mcate->lst();
        $this->assign('date',$date);
        return view('list');
    }

    public function add()
    {
        $Mcate = new Mcate();
        $data = db('cate')->select();
        $data = $Mcate->lst();
        $this->assign('catedata',$data);


        if(request()->isPost()){
            $data = input('post.');
            // dump($data);die;
            $res = db('cate')->insert($data);
            if($res)
            {
                return $this->success('栏目添加成功',url('cate/lst'));
            }else{
                return $this->error('栏目添加失败');
            }
        }

        return view();
    }

    public function del()
    {
        $id = input('id');
        $res = db('cate')->destory($id);

        if($res ){
            return $this->success('栏目删除成功',url('cate/lst'));
        }else{
            return $this->error('栏目删除失败');
        }
        
    }
    public function delchildren()
    {

        $id = input('id');
        $Mcate = new Mcate();

        $data = $Mcate->del($id);
        return view();
    }
    public function update()
    {
        
        return view();
    }
}

?>