<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use App\Product;
use App\ProductType;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\Cart;
use App\User;
use Hash;
use Auth;

use Session;

class PagesController extends Controller
{
    public function getIndex(){
    	$slides = Slide::all();
    	// var_dump($slides); die;
    	// return view('pages.home', ['slides' => $slides]);
    	$new_products = Product::where('new', 1)->get();
    	// var_dump($new_products); die;
    	return view('pages.home', compact('slides', 'new_products'));
    }

    public function getAbout(){
    	return view('pages.about');
    }

    public function getContact(){
    	return view('pages.contact');
    }

    public function getCategories($id_type){
        // echo $id_type; die;
        $products = Product::where('id_type', $id_type)->get();
        $per_page = 3;
        $products_top = Product::where('id_type', '<>', $id_type)->paginate($per_page);

        $categories = ProductType::all();
        $category_current = ProductType::where('id', $id_type)->first();
        // var_dump($products); die;
    	return view('pages.categories', compact('products', 'products_top', 'categories', 'category_current'));
    }

    public function getProducts(){
        // $products = Product::all();
        $per_page = 9;
        $products = Product::paginate($per_page);

        // $categories = ProductType::all();
        // $category_current = ProductType::where('id', $id_type)->first();
        // var_dump($products); die;
        return view('pages.products', compact('products'));
    }

    public function getSearch(Request $req){
        $per_page = 9;
        $key = $req->s;
        // echo $key; die;
        $products = Product::where('name', 'LIKE', "%$key%")
                            ->orWhere('unit_price', $key)
                            ->paginate($per_page);
        return view('pages.search', compact('products'));
    }

    public function getProduct(Request $req){
        // echo $req->id; die;
        $product = Product::where('id', $req->id)->first();
        $per_page = 3;
        /*$products_related = Product::whereColumn([
            ['id_type', '=', $product->id_type],
            ['id', '<>', $product->id]
        ])->paginate($per_page);*/
        $products_related = Product::where('id_type', '=', $product->id_type)->where('id', '<>', $product->id)->paginate($per_page);
        $products_related->withPath(route('product') . '?id=' . $product->id);
    	return view('pages.product', compact('product', 'products_related'));
    }

    public function getCart(){
    	return view('pages.cart');
    }

    public function getCheckout(){
        if(!Session::has('cart')){
            return redirect()->intended('/index');
        }
    	return view('pages.checkout');
    }

    public function getLogin(){
        if(Auth::check()){
            return redirect()->route('home');
        }
    	return view('pages.login');
    }

    public function getSignup(){
        if(Auth::check()){
            return redirect()->route('home');
        }
    	return view('pages.signup');
    }

    public function getAddToCart(Request $req, $id){
        $product = Product::find($id);
        $old_cart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($old_cart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);
        return redirect()->back();
    }

    public function getDelItemCart(Request $req, $id){
        $product = Product::find($id);
        $old_cart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($old_cart);
        $cart->removeItem($id);
        if(count($cart->items) > 0){
            $req->session()->put('cart', $cart);
        }else{
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function postCheckout(Request $req){
        // var_dump($req->all()); die;
        $customer = new Customer();
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->note;
        $customer->save();

        $cart = Session::get('cart');

        $bill = new Bill();
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->note;
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail();
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = ($value['price']/$value['qty']);
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao','Đặt hàng thành công');
    }

    public function postSignin(Request $req){
        if(Auth::check()){
            return redirect()->route('home');
        }
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6|max:20',
                'fullname'=>'required',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                're_password.same'=>'Mật khẩu không giống nhau',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự'
            ]);
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Tạo tài khoản thành công');
    }

    public function postLogin(Request $req){
        if(Auth::check()){
            return redirect()->route('home');
        }
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Email không đúng định dạng',
                'password.required'=>'Vui lòng nhập mật khẩu',
                'password.min'=>'Mật khẩu ít nhất 6 kí tự',
                'password.max'=>'Mật khẩu không quá 20 kí tự'
            ]
        );
        $credentials = array('email'=>$req->email,'password'=>$req->password);
        $user = User::where([
            ['email','=',$req->email],
            ['status','=','1']
        ])->first();

        if($user){
            if(Auth::attempt($credentials)){
                // return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
                // return redirect()->route('home');
                return redirect()->intended('defaultpage');
            }else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
            }
        }else{
           return redirect()->back()->with(['flag'=>'danger','message'=>'Tài khoản chưa kích hoạt']); 
        }
        
    }

    public function postLogout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
