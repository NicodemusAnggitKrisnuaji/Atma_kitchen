<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function page()
    {
        return view('contentCustomer.login');
    }
    // public function login()
    // {
    //     if (Auth::check()) {
    //         $userType = Auth::user()->type;

    //         $userId = Auth::user()->id;
    //         $transaksi = Transaksi::where('id_user', $userId)->get();

    //         if ($userType === 'admin') {
    //             return redirect('admin');
    //         } elseif ($userType ==='regular') {
    //             return redirect('contentCustomer.profile', compact('transaksi'));
    //         }
    //     } else {
    //         return view('Login');
    //     }
    // }

    public function actionLogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();

            if ($user->email === $request->input('email')) {

                $role = Auth::user()->role;
                if ($role === 'Customer') {
                    return redirect('profile');
                } elseif ($role === 'MO') {
                    return redirect('karyawan');
                } elseif ($role === 'Owner') {
                    return redirect('gaji');
                } elseif ($role === 'admin') {
                    return redirect('produk');
                } else {
                    Auth::logout();
                    Session::flash('error', 'Role tidak ditemukan');
                    return redirect('login');
                }
            }else{
                Auth::logout();
                Session::flash('error', 'Email atau Password salah');
                return redirect('login');
            }
        }else{
            Session::flash('error', 'Email atau Password salah');
            return redirect('login');
        }
    }

    public function actionLogout()
    {
        Auth::logout();
        Session::forget('key');
        return redirect('/');
    }
}
