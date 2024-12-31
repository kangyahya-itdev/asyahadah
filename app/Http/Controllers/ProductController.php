<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\CommissionProduct;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    public function index(Request $request){
        $data = Product::all();
        return view('user_area.product.index', [
            'title' => 'Produk',
            'products' => $data
        ]);
    }
    public function history(){
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil riwayat pesanan dari user
        $orders = Order::with(['orderItems.product', 'commissions'])
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

        // Return view dengan data riwayat pesanan
        return view('user_area.product.history', [
            'title' => 'Riwayat Pesanan',
            'orders' => $orders
        ]);
    }

    public function list(){
        return view(
            'admin_area.product',
            [
                'title' => 'Product',
                'product' => Product::all()
            ]
        );
    }
    public function add($id = null){
        $product = $id ? Product::with('commissionProducts')->find($id) : null;
        return view(
            'admin_area.product.add',
            [
                'title' => 'Product',
                'product' => $product
            ]
        );
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'productName' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'personalCommission' => 'required|numeric|min:0|max:100',
            'referralCommission' => 'required|numeric|min:0|max:100',
        ]);
        // Insert atau Update data
        $product = Product::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $validated['productName'],
                'description' => $validated['desc'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
            ]
        );
        // Update atau Buat data komisi
        CommissionProduct::updateOrCreate(
            ['product_id' => $product->id],
            [
                'personal_commission' => $validated['personalCommission'],
                'referral_commission' => $validated['referralCommission'],
            ]
        );

        return redirect()->route('admin.product')->with('success', 'Product saved successfully!');
    }

    public function delete_product($id){
        $product = Product::findOrFail($id);
        try {
            $product->delete();
            return response()->json(['success'=> 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error'=> 'Gagal mengapus data'], 500);
        }
    }



    public function commission_product(){
        return view('admin_area.commission', [
            'title' => 'Commission',
            'commissions' => CommissionProduct::all()
        ]);
    }
    public function insert_commission_product($id = null){
        $commission_product = $id ? CommissionProduct::find($id) : null;
        return view(
            'admin_area.commission.insert',
            [
                'title' => 'Commission Product',
                'commission_product' => $commission_product,
                'product' => Product::all()
            ]
        );
    }
    public function store_commission_product(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'productID' => 'required|string|max:255',
            'personalCommission' => 'required|numeric|min:0|max:100',
            'referralCommission' => 'required|numeric|min:0|max:100',
        ]);
        // Update atau Buat data komisi
        CommissionProduct::updateOrCreate(
            ['id' => $request->id],
            [
                'product_id' => $validated['productID'],
                'personal_commission' => $validated['personalCommission'],
                'referral_commission' => $validated['referralCommission'],
            ]
        );

        return redirect()->route('admin.commissions')->with('success', 'Commission Product saved successfully!');
    }
    public function delete_commission_product($id){
        $commission_product = CommissionProduct::findOrFail($id);
        try {
            $commission_product->delete();
            return response()->json(['success'=> 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error'=> 'Gagal mengapus data'], 500);
        }
    }
}
