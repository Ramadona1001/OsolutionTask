<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
  
class ProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        if (auth()->user()->type == 'client') {
            $products = Product::where('user_id',auth()->user()->id)->with('user')->get();
        }
        if (auth()->user()->type == 'user') {
            $users_ids = [auth()->user()->id];
            foreach (User::where('assigned_to',auth()->user()->id)->get() as $user) {
                array_push($users_ids,$user->id);
            }
            $products = Product::whereIn('user_id',$users_ids)->with('user')->get();
        }
        if (auth()->user()->type == 'admin') {
            $products = Product::all();
        }
        return Inertia::render('Products/Index', ['products' => $products]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();
  
        Product::create([
            'title'=>$request->title,
            'body' => $request->body,
            'user_id' => auth()->user()->id
        ]);
  
        return redirect()->route('products.index');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();
  
        Product::find($id)->update($request->all());
        return redirect()->route('products.index');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('products.index');
    }
}