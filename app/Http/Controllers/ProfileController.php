<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = Auth::user()->role;
            if ($role === 'Customer') {
                return view('contentCustomer.profile', compact('user'));
            } elseif ($role === 'MO') {
                return view('viewAdmin.profileMO', compact('user'));
            } elseif ($role === 'Owner') {
                return view('viewAdmin.profileOwner', compact('user'));
            } elseif ($role === 'admin') {
                return view('viewAdmin.profileAdmin', compact('user'));
            } else {
                Auth::logout();
                return redirect('login');
            }
        }
        return view('home');
    }


    public function history(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $query = History::where('id_user', $user->id);

            $keyword = $request->input('keyword');

            if (!empty($keyword)) {
                $query->where('nama_produk', 'LIKE', "%$keyword%");
            }

            $history = $query->get();

            return view('contentCustomer.history', compact('history'));
        }
        return view('home');
    }



    public function editProfile($id)
    {
        $user = User::findOrFail($id);
        return view('contentCustomer.editProfile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);

        // Validasi input
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required',
            'password',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        // Memperbarui data pengguna
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->tanggal_lahir = $request->tanggal_lahir;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


        $user->save();

        return redirect()->route('profile');
    }

    public function editProfileAdmin($id)
    {
        if (Auth::check()) {
            $user = User::findOrFail($id);
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return view('viewAdmin.editAdmin', compact('user'));
            } else {
                Auth::logout();
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
    }

    public function editProfileMO($id)
    {
        if (Auth::check()) {
            $user = User::findOrFail($id);
            $role = Auth::user()->role;

            if ($role === 'MO') {
                return view('viewAdmin.editMO', compact('user'));
            } else {
                Auth::logout();
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
    }

    public function editProfileOwner($id)
    {
        if (Auth::check()) {
            $user = User::findOrFail($id);
            $role = Auth::user()->role;

            if ($role === 'Owner') {
                return view('viewAdmin.editOwner', compact('user'));
            } else {
                Auth::logout();
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
    }



    public function updateProfileAdmin(Request $request, $id)
    {
        // Mengambil pengguna yang akan diperbarui
        $user = User::find($id);

        // Validasi input
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required',
            'password',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        // Memperbarui data pengguna
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->tanggal_lahir = $request->tanggal_lahir;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


        $user->save();


        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('profileAdmin')->with('success', 'Profile updated successfully.');
            } else {
                Auth::logout();
                return redirect('login')->with('error', 'Unauthorized access.');
            }
        } else {
            return redirect('login')->with('error', 'Please login again.');
        }
    }

    public function updateProfileMO(Request $request, $id)
    {
        // Mengambil pengguna yang akan diperbarui
        $user = User::find($id);

        // Validasi input
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required',
            'password',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        // Memperbarui data pengguna
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->tanggal_lahir = $request->tanggal_lahir;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


        $user->save();


        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'MO') {
                return redirect()->route('profileMO')->with('success', 'Profile updated successfully.');
            } else {
                Auth::logout();
                return redirect('login')->with('error', 'Unauthorized access.');
            }
        } else {
            return redirect('login')->with('error', 'Please login again.');
        }
    }

    public function updateProfileOwner(Request $request, $id)
    {
        // Mengambil pengguna yang akan diperbarui
        $user = User::find($id);

        // Validasi input
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required',
            'password',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'tanggal_lahir' => 'required|date',
        ]);

        // Memperbarui data pengguna
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->tanggal_lahir = $request->tanggal_lahir;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }


        $user->save();


        if (Auth::check()) {
            $role = Auth::user()->role;

            if ($role === 'Owner') {
                return redirect()->route('profileOwner')->with('success', 'Profile updated successfully.');
            } else {
                Auth::logout();
                return redirect('login')->with('error', 'Unauthorized access.');
            }
        } else {
            return redirect('login')->with('error', 'Please login again.');
        }
    }
}
