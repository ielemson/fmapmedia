<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerMagazineController extends Controller
{
    
    
public function index()
    {
        $products = Product::whereHas('orders', function ($query) {
                $query->where('user_id', auth()->id())
                      ->where('payment_status', 'paid');
            })
            ->latest()
            ->paginate(12);

        return view('customer.magazines.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->whereHas('orders', function ($query) {
                $query->where('user_id', auth()->id())
                      ->where('payment_status', 'paid');
            })
            ->firstOrFail();

        return view('customer.magazines.show', compact('product'));
    }
    public function library()
    {
         $products = Product::whereHas('orders', function ($query) {
                $query->where('user_id', auth()->id())
                      ->where('payment_status', 'paid');
            })
            ->latest()
            ->paginate(12);

        return view('customer.magazines.index', compact('products'));
    }
    
}
