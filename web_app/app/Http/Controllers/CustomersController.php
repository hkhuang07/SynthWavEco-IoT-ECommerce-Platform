<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\PlaceOrderSuccessEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;



use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getHome()
    {
        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            return view('user.home', compact('user'));
        } else
            return redirect()->route('user.login');
    }

    public function getPlaceOrder()
    {
        if (Auth::check())
            return view('user.placeorder');
        else
            return redirect()->route('user.login');
    }

    /*public function postPlaceOrder(Request $request)
    {
        // Kiểm tra
        $this->validate($request, [
            'shipping_address' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:255'],
        ]);
        // Lưu vào đơn hàng
        $order = new Order();
        $order->user_id = Auth::user()->id;     
        $order->order_status_id = 1; // Đơn hàng mới
        $order->shipping_address = $request->shipping_address;
        $order->contact_phone = $request->contact_phone;
        $order->payment_method = $request->payment_method;
        $order->save();
        // Lưu vào đơn hàng chi tiết
        foreach (Cart::content() as $value) {
            $detail = new OrderItem();
            $detail->order_id = $order->id;
            $detail->product_id = $value->id;
            $detail->quantity = $value->qty;
            $detail->price_at_order = $value->price;
            $detail->save();
        }

        // Gởi email
        Mail::to(Auth::user()->email)->send(new PlaceOrderSuccessEmail($order));
        return redirect()->route('user.place-order-success');
    }*/

    public function postPlaceOrder(Request $request)
    {
        // 1. Validation (Giữ nguyên)
        $this->validate($request, [
            'shipping_address' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'string', 'max:50'],
            'accept-terms' => ['accepted'],
        ]);

        if (Cart::count() == 0) {
            return redirect()->route('frontend.shoppingcard')->with('error', 'Your cart is empty. Please add items before placing an order.');
        }

        $initialStatusId = OrderStatus::where('name', 'pending')->first()?->id ?? 1;

        DB::beginTransaction();
        try {
            $subtotal = (float) str_replace(',', '', Cart::priceTotal(2, '.', ''));
            $taxAmount = (float) str_replace(',', '', Cart::tax(2, '.', ''));

            // 2. Tính phí vận chuyển dựa trên lựa chọn
            $shippingRate = 0;
            if ($request->shipping_type === 'fast') {
                $shippingRate = 0.10;
            } elseif ($request->shipping_type === 'express') {
                $shippingRate = 0.25;
            }

            $shippingFee = $subtotal * $shippingRate;
            $totalAmount = $subtotal + $taxAmount + $shippingFee;
            //$totalAmount = Cart::total(2, '.', '');

            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->order_status_id = $initialStatusId;
            $order->shipping_address = $request->shipping_address;
            $order->contact_phone = $request->contact_phone;
            $order->payment_method = $request->payment_method;
            $order->subtotal = $subtotal;
            $order->tax_amount = $taxAmount;
            $order->shipping_fee = $shippingFee;
            $order->total_amount = $totalAmount;
            $order->notes = $request->notes ?? null;

            $order->save();

            foreach (Cart::content() as $value) {
                $productExists = Product::where('id', $value->id)->exists();
                if (!$productExists) {
                    throw new \Exception("Product ID {$value->id} not found.");
                }

                $detail = new OrderItem();
                $detail->order_id = $order->id;
                $detail->product_id = $value->id;
                $detail->quantity = $value->qty;
                $detail->price_at_order = $value->price;
                $detail->save();
            }
            try {
                Mail::to(Auth::user()->email)->send(new PlaceOrderSuccessEmail($order));
            } catch (\Exception $emailException) {
                Log::warning('Failed to send order confirmation email for order ID ' . $order->id . ': ' . $emailException->getMessage());
            }
            
            DB::commit();
            return redirect()->route('user.place-order-success')->with('success', 'Your order has been successfully placed.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Order placement failed: ' . $e->getMessage(), ['user_id' => Auth::id(), 'cart_data' => Cart::content()->toArray()]);

            return redirect()->back()
                ->with('error', 'Order failed. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function getPlaceOrderSuccess()
    {
        Cart::destroy();
        return view('user.placeordersusccess');
    }

    public function getOrder($id = '')
    {
        // Bổ sung code tại đây
        return view('user.order');
    }

    public function postOrder(Request $request, $id)
    {
        // Bổ sung code tại đây
    }

    public function getProfile()
    {
        if (!Auth::check()) {
            return redirect()->route('user.login');
        }
        $user = Auth::user()->loadCount('orders');

        $orderCount = $user->orders_count;

        return view('user.profile', compact('user'));
    }

    public function postProfile(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
        ]);
        $orm = User::find($id);
        $orm->name = $request->name;
        $orm->username = Str::before($request->email, '@');
        $orm->email = $request->email;
        $orm->save();
        return redirect()->route('user.home')->with('success', 'Information updated successfully.');
    }


    public function postChangePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string', 'max:255'],
            'new_password' => ['required', 'string', 'min:8'],
        ]);
        $user = User::findOrFail(Auth::user()->id ?? 0);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('user.home')->with('success', 'Password changed successfully.');
        } else
            return redirect()->route('user.home')->with('warning', 'The old password is incorrect.');
    }

    public function postLogout(Request $request)
    {
        // Bổ sung code tại đây
        return redirect()->route('frontend.home');
    }
}
