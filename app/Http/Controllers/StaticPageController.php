<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\bkashTransactionCheck;
use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{
    
    public function home()
    {
        
        return view('public.pages.home');
        
    }
    
    
    public function contact()
    {
        
        return view('public.pages.contact-us');
        
    }
    
    
    public function postContact(Request $request)
    {
        
        $data = [
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'phone'     => $request->input('phone'),
            'message'   => $request->input('message'),
        ];
        
        $mails = new \App\Http\Controllers\Mails;
        
        $mails->contactToAdmin($data);
        
        return back()->withErrors(['success'=> 'Message has been received successfully.']);
        
    }
    
    
    public function showCategory($id)
    {
        
        return view('public.pages.category', ['category' => \App\Category::find($id), 'products' => \App\Category::find($id)->products, 'images' => \App\Category::find($id)->images ]);
        
    }
    
    
    public function showTag($id)
    {
        
        return \App\Tag::find($id);
        
    }
    
    
    public function showProduct($id)
    {
        
        return view('public.pages.product', ['product' => \App\Product::find($id), 'images' => \App\Product::find($id)->images, 'related_products' => \App\Product::find($id)->related_products ]);
        
    }
    
    
    /**
     * 
     * @table : products
     * 
     * @join : 'category_product' table if search includes categories
     * 
     * @join : 'product_tag' table if search includes tags
     * 
     * @search through : categories, tags, min price and max price
     * 
     */
    public function searchProducts(Request $request)
    {
        
        $products   = \DB::table('products');
        
        ($request->has('categories'))   ? $products = $products->join('category_product','category_product.product_id','=','products.id')->whereIn('category_product.category_id', $request->input('categories')) : false;
        ($request->has('tags'))         ? $products = $products->whereIn('product_tag.tag_id', $request->input('tags')) : false;
        ($request->has('min'))          ? $products = $products->join('product_tag','product_tag.product_id','=','products.id')->where('products.price', '>=', $request->input('min')) : false;
        ($request->has('max'))          ? $products = $products->where('products.price', '<=', $request->input('max')) : false;
        
        $products   =   $products->select('products.*')->groupBy('products.id')->paginate(2);
        
        return view('public.pages.product-search', compact('products'));
        
    }
    
    
    public function orderPreview()
    {
        
        return view('public.pages.order-preview');
        
    }
    
    
    public function orderCheckout()
    {
        
        if(! auth()->user())
        {
            
            session(['redirect_to_checkout' => '1']);
            
            return redirect()->route('login')->withErrors('Please login to Checkout.');
            
        }
        
        session(['redirect_to_checkout' => '0']);
        
        return view('public.pages.order-checkout');
        
    }
    
    
    public function page($name, \App\Page $pages)
    {
        
        $page = $pages->where('name', $name)->first();
        
        $page = ($page) ? $page : $pages->find($name);
        
        return view('public.pages.page', compact('page') );
        
    }
    
    
    public function bkash(bkashTransactionCheck $request)
    {
        
        if($request->has('trxid'))
        {
            
            $transaction = file_get_contents('http://www.bkashcluster.com:9080/dreamwave/merchant/trxcheck/sendmsg?user=MEGAMART24&pass=meeM@t0437ie&msisdn=01787661401&trxid=4203151990');
            
            $transaction = (array) json_decode($transaction, true);
            
            $transaction = $transaction['transaction'];
            
            $status      = $transaction['trxStatus'];
            
            if($status == '0000')
            {
                
                if(session()->has('order_id'))
                {
                    
                    $order = \App\Order::find(session('order_id'));
                    
                    $order->order_status_id = 3;
                    
                    $order->save();
                    
                    session()->forget('order_id');
                    
                }
                
                return redirect()->action('Orders@status')->withErrors('Success! We will contact you shortly.');
                
            } else{
                
                return redirect()->action('Orders@status')->withErrors('Opppps! Something went wrong. Please try again later.');
                
            }
            
            
        } else{
            
            return back()->withErrors('Unexpected data was received. Please check your input and try again.');
            
        }
        
        
    }
    
    
    public function pricing()
    {
        
        return view('public.pages.pricing');
        
    }
    
    
    
    public function about()
    {
        
        return view('public.pages.about');
        
    }
    
    
}

        