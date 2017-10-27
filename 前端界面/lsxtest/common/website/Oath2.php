<?php
//checksum
namespace common\website;

class Oath2 extends Cls_http
{
	public $tokenURL;
	public $authorizeURL;
	public $userURL;
	public $scope = '';
	public $app_key;
	public $app_secret;
	public $display = '';
	public $graphURL = '';
	public $token = array();
	public $meth = array();
	public $post_login = array();
	public $post_token = array();
	public $post_msg = array();
	public $callblock;

	public function login($callblock)
	{
		$pare = array();
		$pare['client_id'] = $this->app_key;
		$pare['redirect_uri'] = $callblock;
		$pare['response_type'] = 'code';
		$pare['scope'] = $this->scope;
		$pare['display'] = $this->display;
		setcookie('___OATH2_CALLBLOCK__', $callblock, gmgmtime() + 3600, '/');
		$p = array_merge($pare, $this->post_login);
		$p = $this->unset_null($p);
		return $this->authorizeURL . '?' . http_build_query($p);
	}

	public function getAccessToken()
	{
		if (method_exists($this, 'gettoken')) {
			$this->token = $this->gettoken();
			return $this->token;
		}

		$pare = array();
		$pare['client_id'] = $this->app_key;
		$pare['client_secret'] = $this->app_secret;
		$pare['grant_type'] = 'authorization_code';
		$pare['code'] = \common\base\Filter::get('code');
		$pare['redirect_uri'] = $_COOKIE['___OATH2_CALLBLOCK__'];
		setcookie('___OATH2_CALLBLOCK__', '', gmgmtime() - 3600, '/');
		$p = array_merge($pare, $this->post_token);
		$p = $this->unset_null($p);
		$result = $this->http($this->tokenURL, $this->meth, $p);

		if (method_exists($this, 'getGraph')) {
			$token = $this->getGraph($result);
		}
		else {
			$token = json_decode($result, true);
		}

		$this->token = $token;
		return $token;
	}

	public function setAccessToken($token)
	{
		$this->token = $token;
		return true;
	}

	public function getMessage()
	{
		$pare = array();
		$pare['client_id'] = $this->app_key;
		$pare['client_secret'] = $this->app_secret;
		$pare['access_token'] = $this->token['access_token'];

		if (!empty($this->token['refresh_token'])) {
			$pare['refresh_token'] = $this->token['refresh_token'];
		}

		$p = array_merge($pare, $this->token, $this->post_msg);
		$p = $this->unset_null($p);

		if (method_exists($this, 'sign')) {
			$this->sign($p);
		}

		$result = $this->http($this->userURL, $this->meth, $p);

		if (method_exists($this, 'is_error')) {
			$info = $this->is_error($result);
		}
		else {
			$info = json_decode($result, true);
		}

		if (method_exists($this, 'message')) {
			$info = $this->message($info);
		}

		return $info;
	}

	public function unset_null($pare)
	{
		$arr = $pare;

		foreach ($arr as $key => $val) {
			if (empty($val)) {
				unset($arr[$key]);
			}
		}

		return $arr;
	}
}

?>
