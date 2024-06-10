<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HistorySaldo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SaldoCustomerApiController extends Controller
{
    // Menarik Saldo
    public function tarikSaldo(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'saldo' => 'required',
            'rekening' => 'required',
            'bank' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()], 400);
        }

        // Create a new withdrawal record
        $withdrawal = HistorySaldo::create([
            'id_user' => $id,
            'saldo_ditarik' => $request->saldo,
            'rekening' => $request->rekening,
            'status' => 'menunggu',
            'bank' => $request->bank, // Default status
        ]);

        return response()->json(['status' => 200, 'message' => 'Withdrawal request created successfully', 'data' => $withdrawal], 200);
    }

    // Menampilkan History Penarikan Saldo
    public function withdrawalHistory(Request $request, $id)
    {
        $history = HistorySaldo::where('id_user', $id)->get();

        return response()->json(['status' => 200, 'data' => $history], 200);
    }
}
