<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Commission;
use App\Models\User;
use App\Models\Product;
use App\Models\ReferralBonus;
use App\Models\WalletTransaction;


class OrderController extends Controller
{
    public function create(Request $request)
    {
        // Validasi input request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil data pengguna yang membuat order
        $user = auth()->user();
        $product = Product::find($request->product_id);

        // Periksa apakah stok mencukupi
        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock for the product.',
            ], 400);
        }
        
        // Total harga pesanan
        $total_price = $product->price * $request->quantity;

        // Simpan order baru
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $total_price,
            'status' => 'Pending Payment',
        ]);
        $order_items = OrderItem::create([
            'order_id' => $order->id,
            'product_id' =>  $request->product_id,
            'quantity' => $request->quantity,
            'price' => $product->price
        ]);
        $product->stock -= $request->quantity;
        $product->save();
        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order,
        ]);
        // $self_commission = $total_price * 0.02;
        // Commission::create([
        //     'user_id' => $user->id,
        //     'order_id' => $order->id,
        //     'amount' => $self_commission,
        //     'description' => 'Self Commission',
        // ]);
        // $this->updateWalletBalance($user, $self_commission);

        // // Cek apakah pengguna memiliki upline (referer)
        // if ($user->upline_id) {
        //     // Dapatkan data upline (referrer)
        //     $upline = User::find($user->upline_id);

        //     // Tentukan persentase komisi, misalnya 10%
        //     $commission_amount = $total_price * 0.01;

        //     // Simpan komisi untuk upline
        //     Commission::create([
        //         'user_id' => $upline->id,
        //         'order_id' => $order->id,
        //         'amount' => $commission_amount,
        //         'description' => 'Commission for referral',
        //     ]);
            
        //     // Update saldo wallet upline
        //     $this->updateWalletBalance($upline, $commission_amount);

        //     // Cek apakah bonus referral untuk upline perlu diberikan
        //     if (!$upline->referralBonuses()->where('referred_user_id', $user->id)->exists()) {
        //         // Berikan bonus referral 50% dari komisi yang diberikan
        //         $bonus_amount = $commission_amount * 0.2;

        //         // Simpan bonus referral untuk upline
        //         ReferralBonus::create([
        //             'user_id' => $upline->id,
        //             'referred_user_id' => $user->id,
        //             'bonus_amount' => $bonus_amount,
        //         ]);

        //         // Update saldo wallet upline
        //         $this->updateWalletBalance($upline, $bonus_amount);
        //     }
        // }

        // return response()->json([
        //     'message' => 'Order created successfully!',
        //     'order' => $order,
        // ]);
    }

    private function updateWalletBalance(User $user, $amount)
    {
        // Ambil wallet pengguna
        $wallet = $user->wallet ?? $user->wallet()->create(['balance' => 0]);

        // Update saldo wallet
        $wallet->balance += $amount;
        $wallet->save();

        // Simpan transaksi wallet
        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'type' => 'credit', // 'credit' untuk penambahan saldo
            'amount' => $amount,
            'description' => 'Referral commission', // Deskripsi transaksi
        ]);
    }
    public function list(){
        $orders = Order::with(['orderItems.product'])->get();
        $title = 'Order List';
        return view('admin_area.order.index', compact('orders', 'title'));
    }

}