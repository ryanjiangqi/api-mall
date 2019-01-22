<?php

namespace App\Http\Controllers\Product;

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

    public function product(Request $request)
    {
        $list = Product::where(['status' => '上架'])->get();
        return success($list);
    }

    public function productDetail(Request $request)
    {
        $id = $request->input("id");
        $data = Product::detail($id);
        return success($data);
    }
}
