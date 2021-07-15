<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Session;
use App\User;

class AuthController extends Controller
{
  public function Index(Request $request)
  {
    return view('auth/v_login');
  }

  public function login(Request $request)
  {
    $rules = [
      'email'                 => 'required|email',
      'password'              => 'required|string'
    ];

    $messages = [
      'email.required'        => 'Email wajib diisi',
      'email.email'           => 'Email tidak valid',
      'password.required'     => 'Password wajib diisi',
      'password.string'       => 'Password harus berupa string'
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput($request->all);
    }

    $data = User::where('email', $request->email)->first();

    if ($data) {
      if (Hash::check($request->password, $data->password)) {
        if ($request->remember <> null) {
          session(['remember' => [
            "email" => $request->email,
            "password" => $request->password,
            "remember" => $request->remember
          ]]);
        } else {
          $request->session()->forget('remember');
        }
        session(['logged_in' => true]);
        return redirect()->route('/');
      } else {
        Session::flash('error', 'Password salah !!');
        return redirect()->route('login');
      }
    } else {
      Session::flash('error', 'Email Tidak terdaftar !!');
      return redirect()->route('login');
    }
  }

  public function remember(Request $request)
  {
    if (!$request->ajax()) {
      return "error request";
      exit;
    }
    $data = session('remember');
    if ($data != null) {
      return response()->json($data);
    }
  }


  public function logout(Request $request)
  {
    $request->session()->forget('logged_in');
    return redirect()->route('login');
  }
}
