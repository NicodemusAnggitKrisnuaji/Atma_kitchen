<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HistorySaldo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KonfirmasiSaldoController extends Controller
{

    public function PenarikanSaldo()
    {
        $history = HistorySaldo::where('status', 'menunggu')->with('user')->paginate(10);
        return view('viewAdmin.historySaldo.index', compact('history'));
    }

    // Konfirmasi transfer saldo
    public function ConfirmTransfer(Request $request, $id)
{
    $withdrawal = HistorySaldo::findOrFail($id);
    $user = User::findOrFail($withdrawal->id_user);

    $user->saldo -= $withdrawal->saldo_ditarik;
    $user->save();
    
    $withdrawal->status = 'diterima';
    $withdrawal->tanggal_ditarik = Carbon::now();
    $withdrawal->save();

    return redirect()->route('PenarikanSaldo')->with('success', 'berhasil');
}
}
