<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function pay(Request $request, $id)
{
    try {
        $order = Order::findOrFail($id);

        // Validasi status pesanan
        if ($order->status !== 'Pending Payment') {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak dapat diproses.']);
        }

        // Ambil data pengguna dan wallet
        $user = Auth::user();
        if (!$user->wallet) {
            return response()->json(['success' => false, 'message' => 'Wallet pengguna tidak ditemukan.']);
        }

        // Periksa saldo
        if ($user->wallet->balance < $order->total_price) {
            return response()->json(['success' => false, 'message' => 'Saldo Anda tidak mencukupi untuk pembayaran ini.']);
        }

        // Transaksi pembayaran
        DB::transaction(function () use ($user, $order) {
            $user->wallet->balance -= $order->total_price;
            $user->wallet->save();

            $order->status = 'Paid';
            $order->save();

            // Catat transaksi di wallet_transactions
            WalletTransaction::create([
                'wallet_id' => $user->wallet->id,
                'amount' => -$order->total_price, // Negatif karena saldo berkurang
                'type' => 'debit', // Atau sesuai konvensi Anda
                'description' => 'Pembayaran untuk pesanan #' . $order->id,
                'transaction_date' => now(),
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil',
            'remaining_balance' => $user->wallet->balance,
        ]);
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server.']);
    }
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