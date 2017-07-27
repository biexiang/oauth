<?php
/**
 * Created by PhpStorm.
 * User: poly
 * Date: 2017/7/25
 * Time: 上午10:49
 */
namespace App\Http\Controllers\Taobao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TaoUser;

class Pages extends Controller
{
    //Providers app key
    protected $config   =   [
        'evil'  =>  [
            'name'      =>  'Evil Corp',
            'url'       =>  'http://oauth.net/e/o/login',
            'api_key'   =>  '78ccf72d3909c042e9'
        ],
    ];
    protected $callback =   'http://oauth.net/callback/evil';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function  index()
    {
        return view('taobao/index')->with([
            'config'    =>  $this->config,
            'callback'  =>  $this->callback
        ]);
    }

    public function user(Request $r)
    {
        $uni    =   $r->session()->get('is_login');
        if(!$uni)
        {
            return redirect('/index');
        }

        $user_info   =   TaoUser::whereUniId($uni)->first();

        return view('taobao/user')->with([
            'username'  =>  $user_info->username
        ]);
    }

}