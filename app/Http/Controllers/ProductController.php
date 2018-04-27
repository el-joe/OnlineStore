<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Categoryy;
use Session;
use App\Cart;
use Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        if(request()->price == 'less10')
        {
            $products = Product::where('price','<=',10*100)->take(9)->get();

        }elseif(request()->price == '10to100')
        {
            $products = Product::where('price','>=',10*100)->Where('price','<=',100*100)->take(9)->get();

        }elseif(request()->price == 'morethan100')
        {
            $products = Product::where('price','>',100*100)->take(9)->get();

        }else
        {
            $products = Product::inRandomOrder()->take(9)->get();

            if(request()->category)
            {
                $products = Product::with('categoryys')->whereHas('categoryys',function($query){
                    $query->where('slug',request()->category);
                })->get();
                $categories = Categoryy::all();
            }
        }

                $categories = Categoryy::all();


    	return view('welcome',compact('products','categories'));
    }

    public function getAddToCart(Request $request, $id)
    {
    	$product = Product::find($id);
    	$oldCart = Session::has('cart') ? Session::get('cart') :null;
    	$cart    = new Cart($oldCart);
    	$cart->add($product , $product->id);

    	$request->session()->put('cart',$cart);
        
    	return redirect()->route('index');
    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') :null;
        $cart    = new Cart($oldCart);
        $cart->reduceByOne($id);
        if(count($cart->items)>0)
        {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }
        return redirect()->route('product.shoppingCart');
    }

    public function getRemoveItems($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') :null;
        $cart    = new Cart($oldCart);
        $cart->removeItem($id);

        if(count($cart->items)>0)
        {
            Session::put('cart',$cart);
        }else{
            Session::forget('cart');
        }

        return redirect()->route('product.shoppingCart');

    }

    public function getCart()
    {
        if(!Session::has('cart'))
            {
                return view('shop.shopping-cart');
            }
            $oldCart = Session::get('cart');
            $cart    = new Cart($oldCart);
            return view('shop.shopping-cart',['products'=>$cart->items , 'totalPrice'=>$cart->totalPrice]);
    }

    public function addProducts()
    {
        return view('shop.addProducts');
    }

    public function storeProducts(Request $request)
    {

        $input = $request->all();

        if($file = $request->file('file'))
        {
            $name = $file->getClientOriginalName();

            $file->move('img' , $name);

            $input['image'] = $name;
        }

        $product = new Product();
        $product->name = $input['name'];
        $product->description = $input['desc'];
        $product->price = $input['price'];
        $product->image = $input['image'];
        $product->save($input);

        return redirect()->route('index');








        // $file = $request->file('file');

        // echo $file->getClientOriginalName();

        // echo "<br>";

        // echo $file->getClientSize();

    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $arr = explode(" ",$query);
        $newQuery = implode('%', $arr);
        $products = Product::where('name','like',"%$newQuery%")->get();
        $categories = Categoryy::all();

        return view('welcome',compact('products','categories'));
    }
}
