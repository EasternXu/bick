<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class Article extends Model
{
    protected static function init()
    {
        Article::event('before_insert', function ($articledate) {
        
            $file = request()->file('thumb');
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    // 成功上传后 获取上传信息
                    // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                    $path =  'http://www.lxdbick.com/'.'uploads'.'/'.$info->getSaveName();
                    $articledate['thumb'] = $path;
                    // dump($articledate);die;
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();die;
                }
            }
        });
    }
}

?>