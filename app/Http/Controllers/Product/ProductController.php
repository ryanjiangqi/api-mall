<?php

namespace App\Http\Controllers\Product;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pitems;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function items(Request $request)
    {
        $list = Pitems::where(['parent_id' => 0])->get();
        foreach ($list as $key => $value) {
            $list[$key]['child'] = Pitems::where(['parent_id' => $value['id']])->get();
        }
        return success($list);
    }

    public function itemsChild()
    {
        $list = Pitems::where('parent_id','<>','0')->orderBy('sort','desc')->limit(8)->get();
        return success($list);
    }

    public function product(Request $request)
    {
        $list = Product::where(['status' => '上架'])->get();
        return success($list);
    }
    public function productIndex(Request $request)
    {
        $list = Product::where(['status' => '上架','is_index'=>1])->get();
        return success($list);
    }

    public function productDetail(Request $request)
    {
        $id = $request->input("id");
        $data = Product::detail($id);
        return success($data);
    }

    public function bannerIndex()
    {
        $data=Ad::where(['type'=>'首页banner图','status'=>'上架'])->get();
        return success($data);
    }
}
