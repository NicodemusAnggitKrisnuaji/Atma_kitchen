<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PoinController extends Controller
{
    public function show($id)
    {
    $pemesanan = Pemesanan::findOrFail($id);
    $pointsEarned = $this->pointsEarned($pemesanan); // Menghitung jumlah poin yang didapat
    return view('pemesanan.show', compact('pemesanan', 'pointsEarned'));
    }

    public function calculatePoints($id)
    {
        $Pemesanan = Pemesanan::findOrFail($id);
        $customer = User::findOrFail($Pemesanan->id_user);
        $PemesananTotal = $Pemesanan->total;
        $points = 0;

        if ($PemesananTotal >= 1000000) {
            $points += 200;
        } elseif ($PemesananTotal >= 500000) {
            $points += 75;
        } elseif ($PemesananTotal >= 100000) {
            $points += 15;
        } elseif ($PemesananTotal >= 10000) {
            $points += 1;
        }

        $today = Carbon::today();
        $birthday = Carbon::parse($customer->tanggal_lahir)->setYear($today->year);
        $birthdayStart = $birthday->copy()->subDays(3);
        $birthdayEnd = $birthday->copy()->addDays(3);

        if ($today->between($birthdayStart, $birthdayEnd)) {
            $points *= 2;
        }

        $customer->poin += $points;
        $customer->save();

        return redirect()->back()->with('success', 'Poin pelanggan berhasil diupdate');
    }
}
