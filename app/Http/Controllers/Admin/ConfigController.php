<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ConfigController extends CommonController
{
    public function index() {
        $data=Config::orderBy('config_order','asc')
            ->paginate(10);

        foreach ($data as $k=>$v) {
            switch ($v->field_type) {
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name='.$v->config_id.'config_content[] value="'.$v->config_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name='.$v->config_id.'config_content[] >'.$v->config_content.'</textarea>';
                    break;
                case 'radio':
                    $confs=explode(',',$v->field_value);
                    $str=$chk='';
                    foreach ($confs as $vv) {
                        $c=explode('|',$vv);
                        $chk=$c[1]==$v->config_content?'checked':'';
                        $str.= '<input type="radio"  value="'.$c[1].'" id="'.$c[1].$v->config_id.'" '.$chk.'  name='.$v->config_id.'config_content[]><label for="'.$c[1].$v->config_id.'">'.$c[0].'</label>';
                    }
                    $data[$k]->_html=$str;
                    break;
            }
        }
        return view('admin.config.index',compact('data'));

    }

    public function changeorder() {
        if ($input = Input::all()) {

            $config = Config::find($input['config_id']);
            $config->config_order =$input['config_order'];
            $rs=$config->update();
            if ($rs) {
                $data=[
                    'status'=>0,
                    'msg'=>'链接排序更新成功！',
                ];
            } else {
                $data=[
                    'status'=>0,
                    'msg'=>'链接排序更新失败！',
                ];
            }
        }
        return $data;
    }

    public function changeContent() {
        $input=Input::all();

        foreach ($input['config_id'] as $k => $v) {

            $arr[$k]['config_id']=$v;

            $arr[$k]['config_content']=$input[$v.'config_content'][0];
        }

        $rs = $this->updateBatch('blog_config',$arr);
        if ($rs) {
            $this->putFile();
            return back()->with('errors', '更新成功！');
        } else {
            return back()->with('errors', '写入失败！');
        }

    }

    public function putFile() {

//        \Illuminate\Support\Facades\Config::get('web.web_title');  读取配置的方法
        $path=base_path().'/config/web.php';
        $conf = Config::pluck('config_content','config_name')->all();
        $str='<?php return '.var_export($conf,true).';';

        file_put_contents($path, $str);



    }
    //同时更新多个记录，参数，表名，数组（别忘了在一开始use DB;）
    public function updateBatch($tableName = "", $multipleData = array()){

        if( $tableName && !empty($multipleData) ) {

            // column or fields to update
            $updateColumn = array_keys($multipleData[0]);
            $referenceColumn = $updateColumn[0]; //e.g id
            unset($updateColumn[0]);
            $whereIn = "";

            $q = "UPDATE ".$tableName." SET ";
            foreach ( $updateColumn as $uColumn ) {
                $q .=  $uColumn." = CASE ";

                foreach( $multipleData as $data ) {
                    $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";
                }
                $q .= "ELSE ".$uColumn." END, ";
            }
            foreach( $multipleData as $data ) {
                $whereIn .= "'".$data[$referenceColumn]."', ";
            }
            $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";

            // Update
            return DB::update(DB::raw($q));

        } else {
            return false;
        }

    }
    public function create() {
        return view('admin.config.add');
    }

    public function store() {
        $input = Input::except('_token');
        $rules=[
            'config_name'=>'required',
            'config_title'=>'required',
        ];
        $msg=[
            'config_name.required'=>'配置名称不能为空！',
            'config_title.required'=>'配置标题不能为空！',
        ];
        $validator=\Validator::make($input,$rules,$msg);
        if ($validator->passes()) {
            $rs=Config::create($input);
            if ($rs) {
                return redirect('admin/config');
            } else {
                return back()->with('errors', '写入失败');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    //get config.edit 编辑链接
    public function edit($config_id) {
        $config=Config::find($config_id);
        return view('admin/config/edit',compact('config'));
    }
    //put config.update 更新链接
    public function update($config_id) {
        $input=Input::except('_token','_method');
        $rules=[
            'config_name'=>'required',
            'config_title'=>'required',
        ];
        $msg=[
            'config_name.required'=>'配置名称不能为空！',
            'config_title.required'=>'配置标题不能为空！'
        ];
        $validator=\Validator::make($input,$rules,$msg);

        if ($validator->passes()) {
            $rs=Config::where('config_id',$config_id)->update($input);
            if ($rs) {
                $this->putFile();//更新配置文件
                return redirect('admin/config');
            }else{

                return back()->with('errors','添加失败！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }
    /*
     * 删除单个
     * @param $cate_id
     * @return array
     */
    public function destroy($config_id) {
        $rs=Config::where('config_id',$config_id)->delete();
        if ($rs) {
            $this->putFile();//更新配置文件
            $data=[
                'status'=>0,
                'msg'=>'链接删除成功！'
            ];
        }else{
            $data=[
                'status'=>0,
                'msg'=>'链接删除失败！'
            ];

        }
        return $data;
    }

}
