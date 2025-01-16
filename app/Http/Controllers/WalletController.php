<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Rekening;
use App\Models\Topup;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletController extends Controller
{
    public function index(Request $request){

        return view('user_area.wallet.topup', [
            'title' => 'Top Up',
            'topups' => Topup::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get()
        ]);
    }
    public function add_rekening(Request $request){
        $user = Auth::user();
        $path = public_path('data/bankindonesia.json'); // Sesuaikan lokasi file
        $banks = json_decode(File::get($path), true);

        return view('user_area.profile.rekening', [
            'title' => 'Edit Rekening',
            'user' => $user,
            'banks' => $banks
        ]);
    }

    public function update_rekening(Request $request, $id){
        $request->validate([
            'rekening_no' => 'required|numeric|min:10',
            'rekening_bank' => 'required|string|max:50',
        ]);
    
        $rekening = Rekening::findOrFail($id);
        $rekening->update([
            'rekening_no' => $request->rekening_no,
            'rekening_bank' => $request->rekening_bank,
        ]);
    
        return redirect('user_area/profile')->with('success', 'Rekening berhasil diperbarui!');
    }

    public function edit_rekening(){
        $user = Auth::user();
        $path = public_path('data/bankindonesia.json'); // Sesuaikan lokasi file
        $banks = json_decode(File::get($path), true);

        return view('user_area.profile.rekening', [
            'title' => 'Edit Rekening',
            'user' => $user,
            'banks' => $banks
        ]);
    }
    public function store_rekening(Request $request){
        $request->validate([
            'rekening_no' => 'required|numeric|min:10',
            'rekening_bank' => 'required|string|max:50',
        ]);
    
        // Simpan rekening baru
        $request->user()->rekenings()->create([
            'rekening_no' => $request->rekening_no,
            'rekening_bank' => $request->rekening_bank,
        ]);
    
        return redirect('user_area/profile')->with('success', 'Rekening berhasil ditambahkan!');
    }
    public function uploadProof(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file ke folder 'proofs'
        $proofPath = $request->file('proof_image')->store('proofs', 'public');
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk melakukan top-up.');
        }
        // Simpan data ke database (contoh)
        Topup::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'proof_image' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Bukti transfer berhasil dikirim. Menunggu konfirmasi.');
    }

    public function list(Request $request){
            return view('admin_area.user.topup', [
                'title' => 'Data Users Topup',
                'topups' => Topup::all()
            ]);
    }
    public function confirm($id){
        $topup = Topup::findOrFail($id);
        $topup->status = 'confirmed';
        $topup->save();
         // Cari atau buat Wallet pengguna
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $topup->user_id],
            ['balance' => 0]
        );
        // Tambahkan saldo ke Wallet
        $wallet->balance += $topup->amount;
        $wallet->save();

        // Catat transaksi di WalletTransaction
        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $topup->amount,
            'type' => 'credit',
            'description' => 'Topup confirmed',
        ]);
        return redirect()->back()->with('success', 'Topup berhasil dikonfirmasi.');
    }
    public function reject($id){
        $topup = Topup::findOrFail($id);
        $topup->status = 'rejected';
        $topup->save();
        return redirect()->back()->with('error', 'Topup Di Tolak.');
    }

}
