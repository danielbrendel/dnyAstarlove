<?php

/*
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstallerModel;
use App\Models\AppModel;

/**
 * Class InstallerController
 * 
 * Installer specific controller
 */
class InstallerController extends Controller
{
    /**
     * Construct object
     * 
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * View installer wizard
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewInstall()
    {
        if (!file_exists(base_path() . '/do_install')) {
            exit('Indicator file not found');
        }

        return view('home.install');
    }

    /**
     * Perform installation
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function install()
    {
        try {
            $attr = request()->validate([
                'email' => 'required|email',
                'dbhost' => 'required',
                'dbuser' => 'required',
                'dbport' => 'required|numeric',
                'database' => 'required',
                'dbpassword' => 'nullable',
                'smtphost' => 'required',
                'smtpuser' => 'required',
                'smtppassword' => 'required',
                'smtpfromaddress' => 'required|email'
            ]);

            if (!isset($attr['dbpassword'])) {
                $attr['dbpassword'] = '';
            }

            if (!isset($attr['ga'])) {
                $attr['ga'] = '';
            }

            $attr['password'] = AppModel::getRandomPassword(10);

            InstallerModel::install($attr);

            \Auth::attempt([
               'email' => $attr['email'],
               'password' => $attr['password']
            ]);

            return redirect('/admin')->with('success', __('app.product_installed', ['password' => $attr['password']]));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
