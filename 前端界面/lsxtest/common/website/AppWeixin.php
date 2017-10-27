<?php
//checksum
namespace common\website;

class AppWeixin extends Oath2
{
	public $openid;
	public $access_token;
	public $method = 'GET';

	public function __construct()
	{
		$this->userURL = 'https://api.weixin.qq.com/sns/userinfo';
	}

	public function getMessage()
	{
		$parameter = array();
		$parameter['openid'] = $this->openid;
		$parameter['access_token'] = $this->access_token;
		$result = $this->http($this->userURL, $this->method, $parameter);
		$info = json_decode($result, true);

		if (method_exists($this, 'message')) {
			$info = $this->message($info);
		}

		return $info;
	}

	public function message($info)
	{
		$result = array('name' => $info['nickname'], 'user_id' => $info['unionid'], 'sex' => $info['sex'], 'img' => $info['headimgurl']);
		return $result;
	}
}

?>
