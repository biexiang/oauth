<?php
/**
 * Created by PhpStorm.
 * User: poly
 * Date: 2017/7/25
 * Time: 上午11:05
 */
namespace App\Http\Controllers\Providers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EvilUser;
use App\EvilOauth;
use App\RelationOauth;

class Evil extends Controller
{

    public function index(Request $r)
    {
        if(!$r->session()->has('username'))
        {
            return redirect('/e/login');
        }
        $username =  $r->session()->get('username');
        return view('providers/evil/index')->with('username',$username);
    }

    public function register()
    {
        return view('providers/evil/register');
    }

    public function register_handler(Request $r)
    {
        $input  =   $r->all();
        //Todo 过滤
        $user   =   new EvilUser();
        $user->nickname =   $input['nickname'];
        $user->email    =   $input['email'];
        $user->uni_id   =   'uni' . substr(md5(time() . $input['nickname']),1,12);
        //验证时使用password_verify
        //以$2y$开头 + 一个两位cost参数 + $ + 22位随机字符("./0-9A-Za-z")
        //$hash(CRYPT_BLOWFISH是固定60位) = 盐值 + 31位单向加密后的值
        $user->password =   password_hash($input['pass'],PASSWORD_BCRYPT,['cost'    =>  10]);
        $user->save();
        return redirect('/e/login');
    }

    public function login()
    {
        return view('providers/evil/login');
    }

    public function login_handler(Request $r)
    {
        $input  =   $r->all();
        //Todo 验证
        if(empty($input['email']) || empty($input['pass']))
        {
            return redirect('/e/login');
        }
        $user   =   EvilUser::whereEmail($input['email'])->first();
        if(empty($user)) {
            return redirect('/e/login');
        }
        if(!password_verify($input['pass'],$user->password))
        {
            return redirect('/e/login');
        }

        $r->session()->put('username',$user->nickname);
        return redirect('/e/index');
    }

    public function get_info(Request $r)
    {
        if(!$r->session()->has('username'))
        {
            return redirect('/e/login');
        }
        $username   =   $r->session()->get('username');
        $user       =   EvilUser::whereNickname($username)->first();
        $user->is_dev   =   1;
        $user->update();

        $evil_tmp   =   EvilOauth::whereUserId($user->id)->first();
        if($evil_tmp)
        {
            return view('/providers/evil/dev_info')->with([
                'err'       =>  0,
                'nickname'  =>  $username,
                'key'       =>  $evil_tmp->api_key,
                'secret'    =>  $evil_tmp->access_token
            ]);
        }

        $key            =   EvilOauth::getApiKey($user->nickname);
        $secret         =   EvilOauth::getSecrets($user->email);
        $oauth          =   new EvilOauth();
        $oauth->user_id =   $user->id;
        $oauth->api_key =   $key;
        $oauth->access_token    =   $secret;
        if($oauth->save())
        {
            return view('/providers/evil/dev_info')->with([
                'err'       =>  0,
                'nickname'  =>  $username,
                'key'       =>  $key,
                'secret'    =>  $secret
            ]);
        }

        return view('/providers/evil/dev_info')->with([
            'err'   =>  1
        ]);

    }

    public function auth_login(Request $r)
    {
        //app_key
        $api_key    =   $r->input('api_key') ?? null;
        $redirect_url   =   $r->input('redirect_url') ?? '/e/index';
        if(empty($api_key)) {
            return redirect($redirect_url);
        }
        $app        =   EvilOauth::whereApiKey($api_key)->first();
        if(empty($app))
        {
            return redirect($redirect_url);
        }

        $r->session()->put('redirect_url',$redirect_url);
        $r->session()->put('app_id',$app->id);

        return view('/providers/evil/auth_login')->with([
            'app_name'      =>  $app->app_name
        ]);
    }

    public function auth_login_handler(Request $r)
    {
        $pass   =   $r->input('pass') ?? null;
        $email   =   $r->input('email') ?? null;

        if(empty($pass) || empty($email))
        {
            return redirect('/e/o/login');
        }

        $user   =   EvilUser::whereEmail($email)->first();
        if(empty($user)) {
            return redirect('/e/o/login');
        }
        if(!password_verify($pass,$user->password))
        {
            return redirect('/e/o/login');
        }

        $has    =   RelationOauth::where('user_id' , $user->id)
                                ->where('expire','>',time())
                                ->first();
        //Todo 验证
        $redirect_url   =   $r->session()->get('redirect_url');
        $app_id         =   $r->session()->get('app_id');

        if($has)
        {
            return redirect($redirect_url . "?code=" . $has->code);
        }

        $relation   =   new RelationOauth();
        $relation->user_id  =   $user->id;
        $relation->app_id   =   $app_id;
        $relation->code     =   $code     =   substr(md5(time()),0,5);
        $relation->expire   =   time() + 86400*30;
        $relation->save();

        $r->session()->put('auth_username',$user->nickname);
        return view('/providers/evil/agreement')->with([
            'nickname'  =>  $user->nickname,
            'redirect_url'  =>  $redirect_url,
            'code'      =>  $code
        ]);

    }

    public function push_token(Request $r)
    {
        //获取请求体生成 token 返回
        $access_token   =   $r->input('access_token')   ?? null;
        $code           =   $r->input('code')   ??  null;

        if(empty($code) || empty($access_token))
        {
            return json_encode([
                'ret'  =>  -110,
                'msg'   =>  '参数不全'
            ]);
        }

        $access     =   EvilOauth::whereAccessToken($access_token)->first();
        if(empty($access))
        {
            return json_encode([
                'ret'  =>  -111,
                'msg'   =>  'Not Validate Access'
            ]);
        }

        $code       =   RelationOauth::whereCode($code)->first();
        if(empty($code))
        {
            return json_encode([
                'ret'  =>  -112,
                'msg'   =>  'Not Been Allowed By User'
            ]);
        }

        if($code->token != 'empty')
        {
            return json_encode([
                'ret'  =>  1,
                'msg'   =>  'Pull Token',
                'data'  =>  [
                    'token' =>  $code->token,
                    'refresh_token' =>  $code->refresh_token
                ]
            ]);
        }


        $token      =   md5(time() . $access_token);
        $refresh_token  =   md5($token . 'e88df3856eb0007c0c6923f5a50b91fd');

        $code->token    =   $token;
        $code->refresh_token    =   $refresh_token;
        if(!$code->update())
        {
            return json_encode([
                'ret'  =>  -113,
                'msg'   =>  'Data Error'
            ]);
        }

        return json_encode([
            'ret'  =>  1,
            'msg'   =>  'Pull Token',
            'data'  =>  [
                'token' =>  $token,
                'refresh_token' =>  $refresh_token
            ]
        ]);

    }

    public function get_user_by_token(Request $r)
    {
        $token  =   $r->input('token') ?? null;
        if(empty($token))
        {
            return json_encode([
                'ret'  =>  -110,
                'msg'   =>  '参数不全'
            ]);
        }

        $relation   =   RelationOauth::where('token',$token)
                        ->where('expire','>',time())
                        ->first();
        if(empty($relation))
        {
            return json_encode([
                'ret'  =>  -115,
                'msg'   =>  'token不存在或者已经过期'
            ]);
        }

        $user   =   EvilUser::select(['uni_id','nickname','email','mobile','sex','avatar','country','province','city'])
                                ->where('id',$relation->user_id)
                                ->first()->toArray();

        return json_encode([
            'ret'  =>  1,
            'msg'   =>  'Pull User',
            'data'  =>  $user
        ]);

    }

}