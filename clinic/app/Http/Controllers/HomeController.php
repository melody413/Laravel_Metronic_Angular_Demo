<?php

namespace App\Http\Controllers;

use DotEnvEditor\DotenvEditor;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show dashboard
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * Show webpage
     */
    public  function welcome() {
        if(config('app.has_installed') == 1){
            return view('welcome');
        }else{
            return redirect()->to('/install');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * Show install page
     */
    public function install()
    {

        if (config('app.has_installed') == 0) {
            return view('install.install');
        } else {
            return redirect()->back();
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show account is disable
     */
    public function accountDisable()
    {
        return view('errors.account-disable');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show access denied page
     */
    public function accessDenied()
    {
        return view('errors.permission-denied');
    }
}
