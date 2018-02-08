<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\User;

class UserController extends BaseController
{


    public function login(Request $request)
    {
        if ($code = $request->get('code')) {
            $openId = $this->getOpenIdByCode($code);
            if (!($user = $this->getUserByOpenId($openId))) {
                $userInfo = $request->get('userInfo');
                $user = User::create([
                    'wx_openid' => $openId,
                    'nickname' => $userInfo['nickName'],
                    'avatar' => $userInfo['avatarUrl'],
                    'name' => $userInfo['nickName']
                ]);
            }

            $token = \JWTAuth::fromUser($user);
            return $this->response->array(array_merge(['token' => $token], $user->toArray()));
        }

        throw new NotFoundHttpException('缺少参数code');
    }


    protected function getOpenIdByCode($code)
    {
        $appId = config('wxapp.app_id');
        $appSecret = config('wxapp.app_secret');
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code';
        $requestUrl = sprintf($url, $appId, $appSecret, $code);

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $requestUrl);

        $data = json_decode($res->getBody(), true);

        if (isset($data['openid'])) {
            return $data['openid'];
        }

        throw new NotFoundHttpException('没有获得openid');
    }

    protected function getUserByOpenId($openId)
    {
        return User::where('wx_openid', $openId)->first();
    }
}
