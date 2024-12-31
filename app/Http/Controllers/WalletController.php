<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Rekening;

class WalletController extends Controller
{
    public function index(Request $request){
        return view('user_area.wallet.topup', ['title' => 'Top Up']);
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
}
