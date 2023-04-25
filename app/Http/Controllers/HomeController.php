<?php

namespace App\Http\Controllers;

use App\UserCard;
use Illuminate\Http\Request;
use App\Upload;
use DB;
use FFMpeg;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard; 
//test commit
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function services()
    {
        return view('services');
    }

    public function terms()
    {
        return view('terms');
    }
    public function privacy()
    {
        return view('privacy');
    }

}
