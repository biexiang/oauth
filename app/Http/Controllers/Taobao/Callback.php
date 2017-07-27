<?php
/**
 * Created by PhpStorm.
 * User: poly
 * Date: 2017/7/25
 * Time: 上午11:01
 */
namespace App\Http\Controllers\Taobao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TaoUser;
class Callback extends Controller
{
    protected $config   =   [
        'evil'  =>  [
            'name'          =>  'Evil Corp',
            'access_token'  =>  'e88df3856eb0007c0c6923f5a50b91fd',
            'req_url'       =>  'http://oauth.net/e/o/get/token/',
            'req_user_url'  =>  'http://oauth.net/e/o/get/user/'
        ],
    ];

    public function evil(Request $r)
    {
        $code   =   $r->input('code')   ??  'fucked';
        if($code == 'fucked')
        {
            return redirect('/index');
        }
        //发送请求获取token
        //存储到session中
        $config     =   $this->config[__FUNCTION__];

        $params     =   [
            'access_token'  =>  $config['access_token'],
            'code'          =>  $code
        ];
        $context    =   stream_context_create([
            'http'  =>  [
                'method'    =>  'POST',
                'header'    =>  'Content-type:application/x-www-form-urlencoded',
                'content'   =>  http_build_query($params),
                'timeout'   =>  20
            ]
        ]);

        $response   =   file_get_contents($config['req_url'],false,$context);
        $response   =   json_decode($response,true);
        //Todo 验证返回数据

        $token      =   $response['data']['token'];
        //存储到session
        $r->session()->put('token',$token);
        $r->session()->put('refresh_token',$response['data']['refresh_token']);
        //拿取token 请求用户信息
        $new_params =   [
            'token' =>  $token
        ];
        $new_context    =   stream_context_create([
            'http'  =>  [
                'method'    =>  'POST',
                'header'    =>  'Content-type:application/x-www-form-urlencoded',
                'content'   =>  http_build_query($new_params),
                'timeout'   =>  20
            ]
        ]);
        $resp  =   file_get_contents($config['req_user_url'],false,$new_context);
        $resp  =   json_decode($resp,true);
        if($resp['ret'] != 1)
        {
            //Todo 验证返回数据
        }

        $user_info  =   $resp['data'];

        $exists     =   TaoUser::where('uni_id',$user_info['uni_id'])->first();
        if(!empty($exists))
        {
            return redirect('/user');
        }


        $user   =   new TaoUser();
        $user->uni_id   =   $user_info['uni_id'];
        $user->username =   $user_info['nickname'];
        $user->email    =   $user_info['email'];
        $user->mobile   =   $user_info['mobile'];
        $user->avatar   =   $user_info['avatar'];
        $user->sex      =   $user_info['sex'];

        if($user->save())
        {
            $r->session()->put('is_login',$user_info['uni_id']);
            return redirect('/user');
        }

    }

}
