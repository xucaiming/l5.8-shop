<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        // 创建一个查询构造器
        $builder = Product::query()->where('on_sale', true);

        // 判断是否有提交参数
        if($search = $request->input('search', '')){
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function($query) use ($like){
                $query->where('title', 'like', $like)
                      ->orWhere('description', 'like', $like)
                      ->whereHas('skus', function($query) use ($like){
                          $query->where('title', 'like', $like)
                                ->orWhere('description', 'like', $like);
                      });
            });
        }

        // 判断是否有提交order参数，如果有就赋值给$order变量 $order参数用来控制商品的排序规则
        if($order = $request->input('order', '')){
            // 是否以_asc或_desc结尾
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if (in_array($m[1], ['price', 'sold_count', 'rating'])) {
                    // 根据传入的排序值来构造排序参数
                    $builder->orderBy($m[1], $m[2]);
                }
            }
        }

        $products = $builder->paginate(16);

        return view('products.index', [

            'products' => $products,
            'filters' => [
                'search' => $search,
                'order' => $order
            ]
        ]);
    }

    public function show(Product $product, Request $request)
    {
        // 判断商品是否已经上架，如果没上架则抛出异常
        if(!$product->on_sale){
            throw new InvalidRequestException('商品未上架！');
        }

        $favored = false;

        // 用户未登录时返回的是null，已登录时返回的是对应的用户对象
        if ($user = $request->user()) {
            // 从当前用户已收藏的商品中搜索ID为当前商品ID的商品
            // boolval()函数用于把值转为布尔值
            $favored = boolval($user->favoriteProducts()->find($product->id));
        }

        $reviews = OrderItem::query()
                    ->with(['order.user', 'productSku']) // 预先加载关联关系
                    ->where('product_id', $product->id)
                    ->whereNotNull('reviewed_at') // 筛选出已评价的
                    ->orderBy('reviewed_at', 'desc')
                    ->limit(10) //取出10条
                    ->get();

        return view('products.show', compact('product', 'favored', 'reviews'));
    }

    //收藏商品
    public function favor(Product $product, Request $request)
    {
        $user = $request->user();

        // 判断是否已经收藏了此商品
        if($user->favoriteProducts()->find($product->id)){
            return [];
        }

        $user->favoriteProducts()->attach($product);
        return [];
    }
    
    //取消收藏
    public function disfavor(Product $product, Request $request)
    {
        $user = $request->user();
        $user->favoriteProducts()->detach($product);
        return [];
    }
    
    //收藏列表
    public function favorites(Request $request)
    {
        $products = $request->user()->favoriteProducts()->paginate(16);

        return view('products.favorites', compact('products'));
    }
}
