<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Investor;

class InvestorLegalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $investor = Investor::where('email', $user->email)->first();

        if (!$investor) {
            return redirect()->route('investor.dashboard')->with('error', 'Profil investor tidak ditemukan.');
        }

        return view('investors.legal.index', compact('investor'));
    }

    public function agree(Request $request)
    {
        $user = Auth::user();
        $investor = Investor::where('email', $user->email)->first();

        if (!$investor) {
            return redirect()->route('investor.dashboard')->with('error', 'Profil investor tidak ditemukan.');
        }

        if (!$investor->pks_agreed_at) {
            $investor->update([
                'pks_agreed_at' => now(),
                'pks_agreed_ip' => $request->ip(),
            ]);
        }

        return redirect()->back()->with('success', 'Anda telah menyetujui Perjanjian Kerja Sama (PKS).');
    }

    public function exportPdf()
    {
        $user = Auth::user();
        $investor = Investor::where('email', $user->email)->first();

        if (!$investor || !$investor->pks_agreed_at) {
            return redirect()->route('investor.legal.index')->with('error', 'Anda harus menyetujui PKS terlebih dahulu.');
        }

        // Kalau ada library PDF (misal: dompdf), kita bisa generate PDF. 
        // Sementara kita tampilkan tampilan HTML khusus print
        return view('investors.legal.print', compact('investor'));
    }
}
