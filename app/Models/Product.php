<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-01-17
 * Time: 20:32
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'product';

    public static function detail($id)
    {
        $info = self::find($id);
        $skuTotal = ProductSku::where(['product_id' => $info['id']])->sum('num');
        $product['kdt_id'] = $info['id'];
        $product['user_id'] = 0;
        $product['offline_id'] = 0;
        $product['activity_alias'] = '';
        $product['goods_id'] = $info['id'];
        $product['alias'] = $info['plu'];
        $product['quota'] = 10;
        $product['is_virtual'] = 0;
        $product['quota_used'] = 0;
        $product['goods_info']['title'] = $info['name'];
        $product['goods_info']['picture'] = config('view.imageUrl') . '/100x100/' . $info['cover_image'];
        $product['goods_info']['price'] = $info['price'];
        $product['goods_info']['origin'] = 0;
        $product['goods_info']['keyword'] = $info['keyword'];
        $product['goods_info']['description'] = $info['description'];

        $product['sku']['price'] = $info['price'];
        $product['sku']['stock_num'] = $skuTotal ?? 0;
        $product['sku']['collection_id'] = 9999;
        $product['sku']['collection_price'] = 0;
        $product['sku']['none_sku'] = false;
        $product['sku']['sold_num'] = 0;
        $product['sku']['min_price'] = $info['price'];
        $product['sku']['max_price'] = $info['price'];
        $product['sku']['hide_stock'] = false;
        $product['sku']['messages'] = [];
        $sku = ProductSku::where(['product_id' => $info['id']])->get();
        if ($sku) {
            foreach ($sku as $ks => $vs) {
                $product['sku']['list'][$ks]['id'] = $vs['id'];
                $product['sku']['list'][$ks]['price'] = $vs['price'];
                $product['sku']['list'][$ks]['discount'] = $vs['price'];
                $product['sku']['list'][$ks]['code'] = '';
                $product['sku']['list'][$ks]['extend'] = '';
                $product['sku']['list'][$ks]['kdt_id'] = $info['id'];
                $product['sku']['list'][$ks]['discount_price'] = 0;
                $product['sku']['list'][$ks]['stock_num'] = $vs['num'];
                $product['sku']['list'][$ks]['stock_mode'] = 0;
                $product['sku']['list'][$ks]['is_sell'] = '';
                $product['sku']['list'][$ks]['combin_sku'] = false;
                $product['sku']['list'][$ks]['goods_id'] = $info['id'];
                $skuAttr = explode(',', $vs['attribute_id']);
                foreach ($skuAttr as $keys => $items) {
                    $skuAttrParent = Pattribute::find($items);
                    $product['sku']['list'][$ks]['s' . ($keys + 1)] = $items;
                }
                $skuImage[$ks]['string'] = explode(',', $vs['attribute_id']);
                $skuImage[$ks]['image'] = config('view.imageUrl') . '/100x100/' . $vs['image'];
            }
        }
        $itemsInfo = Pitems::find($info['items_id']);
        if ($itemsInfo['attribute_id']) {
            $attrList = explode(',', $itemsInfo['attribute_id']);
            foreach ($attrList as $key => $value) {
                $attrParent = Pattribute::find($value);
                $attrChild = Pattribute::where(['attribute_id' => $value])->get();
                $product['sku']['tree'][$key]['k'] = $attrParent['attribute_value'];
                $product['sku']['tree'][$key]['k_id'] = $attrParent['id'];
                $product['sku']['tree'][$key]['k_s'] = 's' . ($key + 1);
                $product['sku']['tree'][$key]['count'] = 10000;
                foreach ($attrChild as $k => $v) {
                    $product['sku']['tree'][$key]['v'][$k]['id'] = $v['id'];
                    $product['sku']['tree'][$key]['v'][$k]['name'] = $v['attribute_value'];
                    $product['sku']['tree'][$key]['v'][$k]['imgUrl'] = '';
                    foreach ($skuImage ?? [] as $valImg) {
                        if (in_array($v['id'], $valImg['string'])) {
                            $product['sku']['tree'][$key]['v'][$k]['imgUrl'] = config('view.imageUrl') . '/100x100/' . $valImg['image'];
                        }
                    }
                }
            }
        }
        return $product;
    }
}