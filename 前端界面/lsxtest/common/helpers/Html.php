<?php
namespace common\helpers;

use yii;
use yii\helpers\BaseHtml;
use yii\web\Request;
use yii\web\View;
use yii\base\InvalidParamException;

/**
 * 68Shop Html工具类
 *
 *
 *
 * ============================================================================
 * 版权所有 2008-2015 秦皇岛商之翼网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.68ecshop.com
 * ----------------------------------------------------------------------------
 * 这是一个免费开源的软件；这意味着您可以在不用于商业目的的前提下对程序代码
 * 进行修改、使用和再发布。
 * ============================================================================
 *
 * @author niqingyang
 * @version 1.0
 */
class Html extends BaseHtml
{

	/**
	 * 生成csrf的文本框标签
	 *
	 * @param mix $options        	
	 */
	public static function csrfInput ($options = [])
	{
		$request = Yii::$app->getRequest();
		if($request instanceof Request && $request->enableCsrfValidation)
		{
			$options = ArrayHelper::merge($options, [
				'type' => 'hidden', 
				'name' => $request->csrfParam, 
				'value' => $request->getCsrfToken()
			]);
			
			return static::tag('input', '', $options) . "\n";
		}
		else
		{
			return '';
		}
	}

	/**
	 * 生成csrf的meta标签
	 *
	 * @param mix $options        	
	 */
	public static function csrfMeta ($options = [])
	{
		$request = Yii::$app->getRequest();
		if($request instanceof Request && $request->enableCsrfValidation)
		{
			$options = ArrayHelper::merge($options, [
				'name' => 'csrf-param', 
				'content' => $request->csrfParam
			]);
			
			$tag = static::tag('meta', '', $options) . "\n";
			
			$options = ArrayHelper::merge($options, [
				'name' => 'csrf-token', 
				'content' => $request->getCsrfToken()
			]);
			
			$tag .= static::tag('meta', '', $options) . "\n";
			
			return $tag;
		}
		else
		{
			return '';
		}
	}

	/**
	 * Generates a link tag that refers to an external CSS file.
	 *
	 * @param string $url
	 *        	array|string $url the URL of the external CSS file. This
	 *        	parameter will be processed by [[Url::to()]].
	 * @param array $options        	
	 * @return string
	 */
	public static function cssFile ($url, $options = [])
	{
		$url = static::url($url);
		
		if($options instanceof View)
		{
			$url = static::url($url);
			$options = [];
		}
		
		for($i = 0; $i < count($options); $i ++)
		{
			if($options[$i] instanceof View)
			{
				$url = static::url($url);
				unset($options[$i]);
			}
		}
		
		return BaseHtml::cssFile($url, $options);
	}

	/**
	 * Generates a link tag that refers to an external JS file.
	 *
	 * @param string $url
	 *        	array|string $url the URL of the external JS file. This
	 *        	parameter will be processed by [[Url::to()]].
	 * @param array $options        	
	 * @return string
	 */
	public static function jsFile ($url, $options = [])
	{
		$url = static::url($url);
		
		if($options instanceof View)
		{
			$url = static::url($url);
			$options = [];
		}
		
		for($i = 0; $i < count($options); $i ++)
		{
			if($options[$i] instanceof View)
			{
				$url = static::url($url);
				unset($options[$i]);
			}
		}
		
		return BaseHtml::jsFile($url, $options);
	}

	/**
	 * 将Url转换为相对于主题的Url路径
	 *
	 * @param string $url
	 *        	地址为相对于主题目录下的地址，例如：default主题下参数$url='/images/123.jpg'则返回路径'/theme/default/images/123.jpg'转义后的路径，如果文件不存在则返回此路径
	 */
	public static function url ($url = '')
	{
		$path = Yii::$app->view->theme->getPath($url);
		try
		{
			return Yii::$app->assetManager->publish($path)[1];
		}
		catch(InvalidParamException $e)
		{
			// 文件不存在则显示相对路径
			return Yii::$app->view->theme->getUrl($url);
		}
	}

	public static function getPublishedPath ()
	{
		$path = Yii::$app->assetManager->publish();
	}

	/**
	 * 获取当前主题的根目录
	 */
	public static function webroot ($url)
	{
		return Yii::$app->view->theme->getUrl();
	}

	/**
	 * Generates a number input tag for the given model attribute.
	 * This method will generate the "name" and "value" tag attributes automatically for the model attribute
	 * unless they are explicitly specified in `$options`.
	 * 
	 * @param Model $model
	 *        	the model object
	 * @param string $attribute
	 *        	the attribute name or expression. See [[getAttributeName()]] for the format
	 *        	about attribute expression.
	 * @param array $options
	 *        	the tag options in terms of name-value pairs. These will be rendered as
	 *        	the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
	 *        	See [[renderTagAttributes()]] for details on how attributes are being rendered.
	 * @return string the generated input tag
	 */
	public static function activeNumberInput ($model, $attribute, $options = [])
	{
		return static::activeInput('number', $model, $attribute, $options);
	}
}