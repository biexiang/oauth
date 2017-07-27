<?php
/**
 * Created by PhpStorm.
 * User: poly
 * Date: 2017/7/25
 * Time: 下午10:48
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class EvilOauth extends Model
{
    protected $table = 'oauth2_of_evil';

    public static function getApiKey(String $str): string
    {
        $rand   =   'mamaipi';
        return substr(md5($str .  rand(1,10000) . $rand),7,18);
    }

    public static function getSecrets(String $str): string
    {
        $rand   =   'freestyle';
        return md5($str .  rand(1,10000) . $rand);
    }

}
