<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WeChatController extends Controller
{
    public function weChat(){
        return Socialite::with('weixin')->redirect();
    }

    public function callback(){
        $user = Socialite::driver('weixin')->user();

        $check = User::where('openid', $user->id)->first();
        if (!$check) {
            $customer = User::create([
                'openid' => $user->id,
                'name' => $user->nickname,
                'email' => 'qq_connect+' . $user->id . '@example.com',
                'password' => bcrypt(Str::random(60)),
                'avatar' => $user->avatar
            ]);
        } else {
            $customer = $check;
        }

        Auth::login($customer, true);
        return redirect('/');
    }
    public function getJSSDKConfig(Request $request){
        $arr = explode(',',$request->input('apis',''));
        $debug = $request->input('debug','') ==='true' ? true : false;
        $json = $request->input('json','') ==='true' ? true : false;
        $url = $request->get('url');
        if(!$url){
            return $this->response->message('参数不足')
                ->status("success")
                ->code(400)
                ->url(url('/'))
                ->redirect();
        }
        $app = app('wechat.official_account');
        $app->jssdk->setUrl($url);
        $config = $app->jssdk->buildConfig($arr,$debug,$json,$url);

        return $this->response->message('获取成功')
            ->data([
				'config' => $config
			])
            ->status("success")
            ->code(200)
            ->url(url('/'))
            ->redirect();

    }
}
