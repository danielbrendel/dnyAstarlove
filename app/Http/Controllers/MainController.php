<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppModel;
use App\Models\FeatureItemModel;

class MainController extends Controller
{
    /**
     * Construct object
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show index page according to auth status
     * 
     * @return mixed
     */
    public function index()
    {
        if (\Auth::guest()) {
            return view('guest.home', [
                'settings' => AppModel::getAppSettings(),
                'features' => FeatureItemModel::getAll()
            ]);
        } else {
            return view('member.home');
        }
    }
}
