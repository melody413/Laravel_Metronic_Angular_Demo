<?php

namespace App\Http\Controllers;

use App\Http\Requests\MySQLRequest;
use App\User;
use DotEnvEditor\DotenvEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class SettingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show profile setting page
     */
    public function profileSetting()
    {
        return view('user.doctor.setting.profile.profile-setting');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show app setting page
     */
    public function appSetting()
    {
        return view('user.doctor.setting.app-setting.app');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show prescription setting page
     */
    public function prescriptionSetting()
    {
        return view('user.doctor.setting.prescription.prescription-setting');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \DotEnvEditor\DotEnvException
     * Update .evn variable
     */
    public function postPrescriptionPrintSetting(Request $request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'GENERIC_NAME' => $request->get('generic_name') == 'on' ? 1 : 0,
            'FANCY_FONT' => $request->get('fancy_font') == 'on' ? 1 : 0
        ]);
        return response()->json(['Print prescription setting saved', 'Print Prescription setting saved successfully'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \DotEnvEditor\DotEnvException
     * Update .env variable (effect on mysql)
     */
    public function postMySQLSetting(MySQLRequest $request)
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'APP_URL' => request()->getHttpHost(),
            'DB_HOST' => "'" . $request->get('db_host') . "'",
            'DB_PORT' => "'" . $request->get('db_port') . "'",
            'DB_DATABASE' => "'" . $request->get('db_name') . "'",
            'DB_USERNAME' => "'" . $request->get('db_username') . "'",
            'DB_PASSWORD' => "'" . $request->get('db_password') . "'"
        ]);

        config([
            'database.connections.mysql.host' => $request->db_host,
            'database.connections.mysql.port' => $request->db_port,
            'database.connections.mysql.database' => $request->db_name,
            'database.connections.mysql.username' => $request->db_username,
            'database.connections.mysql.password' => $request->db_password
        ]);

        try {
            Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {
            return response()->json('Error', 500);
        }

        return response()->json('Ok', 200);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \DotEnvEditor\DotEnvException
     * Update .env variable (effect on mail)
     */
    public function postMailSetting(Request $request)
    {
        $request->validate([
            'host' => 'required',
            'port' => 'required|numeric',
            'mail_address' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'mail_form' => 'required'
        ]);

        $env = new DotenvEditor();
        $env->changeEnv([
            'MAIL_HOST' => $request->get('host'),
            'MAIL_PORT' => $request->get('port'),
            'MAIL_USERNAME' => $request->get('mail_address'),
            'MAIL_PASSWORD' => "'" . $request->get('password') . "'",
            'MAIL_FROM_NAME' => "'" . $request->get('mail_form') . "'",
            'MAIL_ENCRYPTION' => $request->get('encryption') != "" ? $request->get('encryption') : null
        ]);
        return response()->json(['Mail setting saved', 'Mail setting saved successfully'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \DotEnvEditor\DotEnvException
     * Update .env variable (effect on app)
     */
    public function appSetup(Request $request)
    {
        $request->validate([
            'app_name' => 'required|min:3',
            'timezone' => 'required|timezone'
        ]);

        $env = new DotenvEditor();
        $env->changeEnv([
            'APP_NAME' => "'" . $request->get('app_name') . "'",
            'APP_TIMEZONE' => "'" . $request->get('timezone') . "'",
        ]);
        return response()->json(['App Setting Saved', 'App setting saved successfully'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * Change auth user password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:5',
            'new_password' => 'required|min:5',
            'confirm' => 'required|same:new_password'
        ]);
        if (Hash::check($request->get('password'), auth()->user()->password)) {
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->get('new_password'));
            if ($user->save()) {
                return response()->json('Ok', 200);
            }
        } else {
            return response()->json('Ok', 500);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \DotEnvEditor\DotEnvException
     * Configure cache
     */
    public function cacheConfig()
    {
        $env = new DotenvEditor();
        $env->changeEnv([
            'APP_URL' => request()->getHttpHost()
        ]);
        Artisan::call('config:cache');
        return redirect()->to('http://' . config('app.url') . '/cache-config-success');
    }

    public function cacheConfigSuccess()
    {
        return view('cache-config-success');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * Show install success
     */
    public function installSuccess()
    {
        if (User::all()) {
            $_env = new DotenvEditor();
            $_env->changeEnv([
                'HAS_INSTALLED' => 1
            ]);
            Artisan::call('config:cache');
            return view('install.install-success');
        } else {
            return redirect()->to('/install');
        }
    }
}
