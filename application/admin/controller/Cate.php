<?php
namespace app\admin\controller;
use app\admin\model\Cate as Mcate;
use app\admin\model\Article;

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

        if(request()->isPost())
        {
            $date = input('post.');
            foreach ($date as $k => $v) {
                $res = $Mcate->update(['id'=>$k,'sort'=>$v]);
            }
            if($res)
            {
                return $this->success('排序添加成功',url('cate/lst'));
            }else{
                return $this->error('排序添加失败');
            }
        }

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
        $res = db('cate')->delete($id);
        $wres = $this->delchildren();
        if($res && !$wres ){
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
       
        $res = db('cate')->delete($data);

         //删除栏目对应的文章
         $data[] = $id;
         foreach ($data as $k => $v) {
            
            $Marticle = new Article();

            $Marticle::destroy(['cateid'=>$v]);

        }
        return $res;
    }



    public function update()
    {
        $id = input('id');
        $data = db('cate')->find($id);
        // dump($data);die;
        $Mcate = new Mcate();
        $catedata = $Mcate->lst();
        $this->assign([
            'date'=>$data,
            'catedate'=>$catedata
            ]);

        if(request()->isPost()){
            $date = input('post.');
            // dump($date);die;
            $res = db('cate')->update($date,['id'=>$date['id']]);
            if($res){
                return $this->success('栏目修改成功',url('cate/lst'));
            }else{
                return $this->error('栏目修改失败');
            }

        }
        
        return view('update');
    }

    public function sortupdate()
    {
        
    }
}

?>