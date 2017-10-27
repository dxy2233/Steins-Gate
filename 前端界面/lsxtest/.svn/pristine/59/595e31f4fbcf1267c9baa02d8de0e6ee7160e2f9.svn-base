<?php
//checksum
namespace common\website;

class JiuShang extends Oath2
{
	public $headimgUrl;

	public function __construct()
	{
		$this->tokenURL = 'https://auth.jiushang.cn/oauth/token';
		$this->userURL = 'https://auth.jiushang.cn/me';
		$this->headimgUrl = 'https://api.jiushang.cn/avatar/{0}';
		$this->authorizeURL = 'https://offer.jiushang.cn/api/sd/auth';
	}

	public function getUserInfo($token)
	{
		$url = $this->userURL;
		$result = $this->http_get($url, $token);
		$result_arr = json_decode($result, true);
		return $result_arr;
	}

	public function getHeadimg($uid)
	{
		$url = format($this->headimgUrl, array($uid));
		$result = $this->http_get($this->headimgUrl);
		$result_arr = json_decode($result, true);
		return $result_arr;
	}

	public function getAuthMessage($token)
	{
		$result = $this->http_get($this->authorizeURL, $token);
		$result_arr = json_decode($result, true);
		return $result_arr;
	}
}

?>
