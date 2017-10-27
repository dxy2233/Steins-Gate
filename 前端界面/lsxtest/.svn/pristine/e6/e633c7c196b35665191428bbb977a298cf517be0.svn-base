<?php
//checksum
namespace common\website;

class MobileWeixin extends Oath2
{
	public $token;
	public $error_msg;
	public $parameter = array();

	public function __construct($app_key, $app_secret)
	{
		$this->app_key = $app_key;
		$this->app_secret = $app_secret;
		$this->website();
	}

	public function website()
	{
		$state = md5(gmtime() + rand(0, 9999));
		$_SESSION['weixin_state'] = $state;
		$this->authorizeURL = 'https://open.weixin.qq.com/connect/oauth2/authorize';
		$this->parameter = array('response_type' => 'code', 'scope' => 'snsapi_userinfo', 'state' => $state);
	}

	public function login($redirect_uri)
	{
		$url = $this->authorizeURL . '?';
		$url .= 'appid=' . $this->app_key . '&redirect_uri=' . urlencode($redirect_uri);
		$url .= '&' . http_build_query($this->parameter);
		$url .= '#wechat_redirect';
		return $url;
	}

	public function getAccessToken()
	{
		$code = (!\common\base\Filter::request('code') ? '' : \common\base\Filter::request('code'));
		$url = sprintf('https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code', $this->app_key, $this->app_secret, $code);
		$result = $this->http($url);
		$result_arr = json_decode($result, true);
		$token = $result_arr['access_token'];
		$refresh = $result_arr['refresh_token'];
		$openid = $result_arr['openid'];
		$_SESSION['openid'] = $openid;
		return $token;
	}

	public function getMessage()
	{
		$url = sprintf('https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s', $this->token, $_SESSION['openid']);
		$result = $this->http($url);
		$result_arr = json_decode($result, true);
		$ret = array();
		$ret['name'] = $result_arr['nickname'];
		$ret['sex'] = $result_arr['sex'];
		$ret['user_id'] = $result_arr['unionid'];
		$ret['img'] = $result_arr['headimgurl'];
		return $ret;
	}

	public function get_error()
	{
		return '未知错误';
	}
}

?>
