<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Mail\MailSend;
use App\Models\User;

class RegisterController extends Controller
{
    public function register()
    {
        return view('contentCustomer.register');
    }

    public function actionRegister(Request $request)
    {
        // Validate the input
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            Session::flash('error', 'Email sudah terdaftar, mohon memakai email yang belum terdaftar !');
            return redirect('register');
        }

        // Create the user
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'role' => 'Customer',
            'remember_token' => null,
            'saldo' => '0',
        ]);

        return redirect('login'); // Correct redirect route
    }
}
