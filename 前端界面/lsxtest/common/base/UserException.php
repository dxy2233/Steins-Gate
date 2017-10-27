<?php
namespace common\base;

use common\helpers\Html;

class UserException extends \yii\base\UserException
{

	protected $title = "出现了一点问题...";

	protected $message = "";

	protected $code = '-1';

	public function __construct ($message = null, $code = null, $previous = null)
	{
		if(is_array($message))
		{
			$config = $message;
			
			$this->message = $config['message'] ? $config['message'] : '';
			$this->title = $config['title'] ? $config['title'] : $this->title;
		}
		else
		{
			if(! is_null($message))
			{
				$this->message = $message;
			}
			
			if(! is_null($code))
			{
				$this->code = $code;
			}
		}
		
		parent::__construct($this->message, $code, $previous);
	}

	public function getTitle ()
	{
		return $this->title;
	}
}