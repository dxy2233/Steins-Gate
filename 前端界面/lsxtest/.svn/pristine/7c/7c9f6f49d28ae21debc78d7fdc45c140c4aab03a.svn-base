<?php
namespace common\base;

use Yii;
use ReflectionClass;
use common\helpers\StringHelper;

/**
 * 68Shop 模块类的基类
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
class Module extends \yii\base\Module
{

	private $_viewPath;

	public function init ()
	{
		// 如果controllerNamespace为空
		if($this->controllerNamespace === null)
		{
			// 设置controllerNamespace
			$this->controllerNamespace = $this->getControllerNamespace();
		}
		// 设置默认路由为其模块ID

		if($this->defaultRoute == 'default')
		{
			$this->defaultRoute = $this->id;
		}
	}

	/**
	 * Returns the directory that contains the view files for this module.
	 *
	 * @return string the root directory of view files. Defaults to "[[basePath]]/views".
	 */
	public function getViewPath ()
	{
		if($this->_viewPath !== null)
		{
			return $this->_viewPath;
		}
		else
		{
			// return $this->_viewPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'views';
			// 去掉了路径中的 ‘views’
			return $this->_viewPath = $this->getBasePath() . DIRECTORY_SEPARATOR;
		}
	}

	/**
	 * Sets the directory that contains the view files.
	 *
	 * @param string $path
	 *        	the root directory of view files.
	 * @throws InvalidParamException if the directory is invalid
	 */
	public function setViewPath ($path)
	{
		$this->_viewPath = alias($path);
	}

	/**
	 * Creates a controller instance based on the given route.
	 *
	 * The route should be relative to this module. The method implements the following algorithm
	 * to resolve the given route:
	 *
	 * 1. If the route is empty, use [[defaultRoute]];
	 * 2. If the first segment of the route is a valid module ID as declared in [[modules]],
	 * call the module's `createController()` with the rest part of the route;
	 * 3. If the first segment of the route is found in [[controllerMap]], create a controller
	 * based on the corresponding configuration found in [[controllerMap]];
	 * 4. The given route is in the format of `abc/def/xyz`. Try either `abc\DefController`
	 * or `abc\def\XyzController` class within the [[controllerNamespace|controller namespace]].
	 *
	 * If any of the above steps resolves into a controller, it is returned together with the rest
	 * part of the route which will be treated as the action ID. Otherwise, false will be returned.
	 *
	 * @param string $route
	 *        	the route consisting of module, controller and action IDs.
	 * @return array|boolean If the controller is created successfully, it will be returned together
	 *         with the requested action ID. Otherwise false will be returned.
	 * @throws InvalidConfigException if the controller class and its file do not match.
	 */
	public function createController ($route, $error = 0)
	{
		if($route === '')
		{
			$route = $this->defaultRoute;
		}
		
		// double slashes or leading/ending slashes may cause substr problem
		$route = trim($route, '/');
		if(strpos($route, '//') !== false)
		{
			return false;
		}
		
		if(strpos($route, '/') !== false)
		{
			list($id, $route) = explode('/', $route, 2);
		}
		else
		{
			$id = $route;
			$route = '';
		}
		
		// module and controller map take precedence
		if(isset($this->controllerMap[$id]))
		{
			$controller = Yii::createObject($this->controllerMap[$id], [
				$id, 
				$this
			]);
			return [
				$controller, 
				$route
			];
		}
		$module = $this->getModule($id);
		if($module !== null)
		{
			return $module->createController($route);
		}
		
		if(($pos = strrpos($route, '/')) !== false)
		{
			$id .= '/' . substr($route, 0, $pos);
			$route = substr($route, $pos + 1);
		}
		
		$controller = $this->createControllerByID($id);
		if($controller === null && $route !== '')
		{
			$controller = $this->createControllerByID($id . '/' . $route);
			$route = '';
		}
		
		// niqingyang - 重写避免重复路径
// 		if($controller === null && $error == 0)
// 		{
// 			if(count(explode('/', $route)) == 1)
// 			{
// 				$route = $this->id . '/' . $route;
				
// 				return $this->createController($route, 1);
// 			}
// 		}
		
		return $controller === null ? false : [
			$controller, 
			$route
		];
	}

	/**
	 * 设置模块下的语言包
	 */
	public function registerTranslations ()
	{
		// 获取当前类的路径
		$classArray = explode('\\', get_called_class());
		// 获取类的名称
		$className = $classArray[2];
		// 设置语言
		$i18n = Yii::$app->i18n;
		$i18n->translations[$className . "*"] = [
			'class' => 'yii\i18n\PhpMessageSource', 
			// 'sourceLanguage' => 'zh-CN',
			'basePath' => '@' . $classArray[0] . '/' . $classArray[1] . '/' . $classArray[2] . '/language', 
			'fileMap' => [
				$className => 'app.php'
			]
		];
	}

	/**
	 * 获取controllerNamespace，默认是放在module类的同级目录下的controllers目录下
	 */
	public function getControllerNamespace ()
	{
		$clazz = new ReflectionClass($this->className());
		$namespace = $clazz->getNamespaceName();
		return StringHelper::format("%s\controllers", $namespace);
//        return sprintf("%s\controllers", $namespace);
	}
}