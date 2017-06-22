<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    protected $primaryKey='cate_id';
    public  $timestamps=false;
    protected $guarded=[];


    public function tree() {
        $cates= $this->orderBy('cate_order','asc')->get();
        $data=json_decode(json_encode($cates),true);
        return $this->generateTree($data,'cate_id','cate_pid',0);
    }
    public function tree2() {
        $cates= $this->orderBy('cate_order','asc')->get();
        $data=json_decode(json_encode($cates),true);
        $arr=$this->generateTree2($data,'cate_id','cate_pid',0);



      return $arr;
    }
    public function myfunc() {
        echo "33";
    }

    /**'
     * 获取关系树
     * @param $items        array 关系数组
     * @param $field_id     id 字段的名称
     * @param $field_pid    pid字段的名称
     * @param $pid          pid的起始大小
     * @return array
     */
    private function generateTree($items,$field_id,$field_pid,$pid){
        $arr = array();
        foreach ($items as $v) {
            if ($v[$field_pid] == $pid) {
                $v['children'] = self::generateTree($items,$field_id,$field_pid, $v[$field_id]);
                $arr[] = $v;
            }
        }
        return $arr;
    }

    /**'
     * 获取关系树(平行结构)
     * @param $items        array 关系数组
     * @param $field_id     id 字段的名称
     * @param $field_pid    pid字段的名称
     * @param $pid          pid的起始大小
     * @return array
     */
    private function generateTree2($items,$field_id,$field_pid,$pid){
        $tree = array();
        //第一步，将所有的分类id作为数组key,并创建children单元
        foreach ($items as $k=>$v) {
            if ($v[$field_pid]==$pid) {
                $tree[]=$v;
                foreach ($items as $kk=>$vv) {
                    if ($vv[$field_pid]==$v[$field_id]) {
                        $vv['cate_name']=' --'.$vv['cate_name'];
                        $tree[]=$vv;
                    }
                }
            }else{
//                $this->generateTree2($items,$field_id,$field_pid,$v[$field_id]);
            }
        }
        return $tree;


    }
}
