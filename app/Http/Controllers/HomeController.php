<?php

namespace App\Http\Controllers;

use App\Models\Alokasi;
use App\Models\Donor;
use App\Models\JenisKegiatan;
use App\Models\Kegiatan;
use App\Models\Pencairan;
use App\Models\Proyek;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $total = new \stdClass();
        $total->proyek      = Proyek::with('alokasi')->get();
        $total->perUker     = Proyek::totalPerUnit();
        $total->perDonor    = Proyek::totalPerDonor();
        $total->kegiatan    = Kegiatan::get();
        $total->pencairan   = Pencairan::get();
        $total->perJenis    = JenisKegiatan::totalPerJenis();
        $total->donor       = Donor::get();
        $total->users       = User::get();
        $total->anggaran    = number_format(Alokasi::where('tahun', \Carbon\Carbon::now()->year)->sum('nilai_alokasi'), 0, ',', '.');
        $total->realisasi   = number_format($total->kegiatan->where('rencana_thn_pelaksana', \Carbon\Carbon::now()->year)->sum('nilai_realisasi'), 0, ',', '.');
        $total->persentase = $total->anggaran > 0
            ? number_format(($total->realisasi / $total->anggaran) * 100, 2, ',', '.') . ' %'
        : '0 %';
        $role               = Auth::user()->role_id;

        if ($role == 4) {
            return $this->user();
        }

        $ukers = UnitKerja::with('donor')->get();

        return view('pages.home', compact('total', 'ukers'));
    }

    public function user()
    {
        $id = Auth::user()->id;

        $total = new \stdClass();
        $total->proyek      = Proyek::with('alokasi')->where('user_id', $id)->get();
        $total->perDonor    = Proyek::totalPerDonor();
        $total->perJenis    = JenisKegiatan::totalPerJenis();
        $total->kegiatan    = Kegiatan::whereHas('proyek', function ($q) use ($id) {
            $q->where('user_id', $id);
        })->get();

        $total->pencairan    = Pencairan::with('kegiatan.proyek')->whereHas('kegiatan.proyek', function ($q) use ($id) {
            $q->where('user_id', $id);
        })->get();

        $total->anggaran    = number_format($total->proyek->flatMap->alokasi->sum('nilai_alokasi'), 0, ',', '.');
        $total->realisasi   = number_format($total->kegiatan->where('rencana_thn_pelaksana', \Carbon\Carbon::now()->year)->sum('nilai_realisasi'), 0, ',', '.');
        $total->persentase  = number_format(((int) str_replace('.', '', $total->realisasi) / (int) str_replace('.', '', $total->anggaran) * 100), 2, ',', '.') . ' %';

        return view('pages.user', compact('total'));
    }
}
