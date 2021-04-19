<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected $redirectTo = 'dashboard';

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
      //fungsi cek untuk mengetahui user sudah login atau belum
      if(Sentinel::check()){
        Log::notice('User '.Sentinel::getUser()->first_name.' '.Sentinel::getUser()->last_name.' Mengakses Login');
        return redirect()->route('home.dashboard');
      }else{
        Log::warning('ip '.\Request::ip().' Mengakses Login');
        return view('auth.login');
      }
    }

    protected function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        try {
            $remember = (Input::get('remember') == 'on') ? true : false;
            if ($user = Sentinel::authenticate($request->all(),$remember))
            {
               $user->remember_token = str_random(32);
               $user->update();
               Log::info('User '.Sentinel::getUser()->first_name.' '.Sentinel::getUser()->last_name.' Login Ke Aplikasi');
               return redirect('/dashboard');
            }
            Log::warning($request->login.' Gagal Login Ke Aplikasi');
            toast()->warning(__('toast.t_login.l_gagal.g_akun_tidak_ada.ata_pesan'), __('toast.t_login.l_gagal.g_akun_tidak_ada.ata_label'));
            return redirect()->back();

        }
        catch (NotActivatedException $e) {
            Log::notice($request->login.' Gagal Login, Karna Akun Belum Aktif');
            toast()->error(__('toast.t_login.l_gagal.g_akun_blm_aktif.aba_pesan'), __('toast.t_login.l_gagal.g_akun_blm_aktif.aba_label'));
            return redirect()->back();
        }
        catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            Log::alert('ip '.\Request::ip().' Kena Blockir '.$delay);
            toast()->error(__('toast.t_login.l_gagal.g_ip_block.ib_pesan'), __('toast.t_login.l_gagal.g_ip_block.ib_label'));
            toast()->error(__('toast.t_login.l_gagal.g_ip_block.ib_tunggu.a').' '.$delay.' s', __('toast.t_login.l_gagal.g_ip_block.ib_tunggu.b'));
            return redirect()->back();
            // return Redirect::back()->withErrors(['global' => 'You are temporary susspended' .' '. $delay .' seconds','activate_contact'=>1]);
        }

    }

    protected function logout()
    {
        Log::notice('User '.Sentinel::getUser()->first_name.' '.Sentinel::getUser()->last_name.' Logout Dari Aplikasi');
        Sentinel::logout();
        return redirect('/');
    }
}
