<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Auth;
use Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function post(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'password'  => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (FacadesAuth::attempt($credentials)) {
            return redirect()->intended('home')->with('success', 'Berhasil Masuk!');
        }

        return redirect()->route('login')->with('failed', 'Username atau Password Salah');
    }

    public function dashboard()
    {
        $role   = Auth::user()->role_id;

        if ($role != 4) {
            return view('pages.index');
        } else {
            return view('pages.user');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function email(Request $request)
    {
        $user  = Auth::user();
        $email = $request->email;

        if ($email) {
            $cekMail = User::where('email', $email)->where('id', '!=', $user->id)->first();

            if ($cekMail) {

                return redirect()->route('email')->with('failed', 'Email sudah terdaftar');
            } else {
                User::where('id', $user->id)->update([
                    'email' => $email
                ]);

                return redirect()->route('email')->with('success', 'Berhasil Menyimpan');
            }
        } else {

            return view('pages.users.profil.email', compact('user'));
        }
    }


    public function profil(Request $request, $id)
    {
        $data = User::where('id', $id)->first();

        return view('pages.users.profil.show', compact('data'));
    }

    public function profilUpdate(Request $request, $id)
    {
        $data = User::where('id', $id)->first();

        if (!$request->all()) {
            return view('pages.users.profil.edit', compact('data'));
        }

        if ($request->all()) {
            $user = User::where('username', $request->username)->where('id', '!=', $id)->count();

            if ($user) {
                return back()->with('failed', 'Username sudah terdaftar');
            }

            User::where('id', $id)->update([
                'username'      => $request->username,
                'password'      => Hash::make($request->password),
                'password_teks' => $request->password,
                'keterangan'    => $request->keterangan
            ]);

            return redirect()->route('profil', $id)->with('success', 'Berhasil Menyimpan');
        }
    }
}
