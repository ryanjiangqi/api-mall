<?php

namespace App\Http\Controllers\Product;

use App\Models\Ad;
use App\Models\Cart;
use App\Models\Pattribute;
use App\Models\ProductSku;
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
        $list = Pitems::where('parent_id', '<>', '0')->orderBy('sort', 'desc')->limit(8)->get();
        return success($list);
    }

    public function product(Request $request)
    {
        $list = Product::where(['status' => '上架'])->get();
        return success($list);
    }

    public function productIndex(Request $request)
    {
        $list = Product::where(['status' => '上架', 'is_index' => 1])->get();
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
        $data = Ad::where(['type' => '首页banner图', 'status' => '上架'])->get();
        return success($data);
    }

    public function cartAdd(Request $request, Cart $cart)
    {
        $productId = $request->input('product');
        $cartNum = $request->input('num');
        $skuId = $request->input('skuid');
        $skuIno = ProductSku::find($skuId);
        if ($skuIno) {
            $att = Pattribute::whereIn('id', explode(',', $skuIno['attribute_id']))->get();
            foreach ($att as $key => $val) {
                $attList[$key]['name'] = $val['attribute_value'];
                $attList[$key]['id'] = $val['id'];
            }
            $cart->user_id = 1;
            $cart->product_id = $productId ?? '';
            $cart->price = $skuIno['price'];
            $cart->num = $cartNum ?? '';
            $cart->sku_id = $skuId ?? '';
            $cart->sku_image = $skuIno['image'] ?? '';
            $cart->attribute_list = json_encode($attList);
            $cart->created_at = date('Y-m-d H:i:s');
            $cart->save();
            return success();
        }
    }

    public function cartList()
    {
        $cart = Cart::where(['user_id' => 1])->get();
        foreach ($cart as $key => $val) {
            $att = json_decode($val['attribute_list'], true);
            $string = "";
            foreach ($att as $item) {
                $string = $string . ' ' . $item['name'];
            }
            $info=Product::find($val['product_id']);
            $cart[$key]['att_name'] = $string;
            $cart[$key]['product_name'] = $info['name'];
        }
        return success($cart);
    }
}
