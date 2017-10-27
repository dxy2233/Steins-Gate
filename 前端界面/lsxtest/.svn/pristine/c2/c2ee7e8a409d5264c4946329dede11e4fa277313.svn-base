<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:21
 */
//$config['modules']['goods'] = sprintf('app\modules\%s\module', 'goods');
//$config['modules']['user'] = sprintf('app\controllers\%sController', 'user');
//$config['modules']['index'] = sprintf('app\controllers\%sController', 'index');

$handler = opendir(APP_PATH . '/modules/');

while(($filename = readdir($handler)) !== false)
{
    if($filename != "." && $filename != "..")
    {
        $file = APP_PATH . '/modules/' . $filename . '/module.php';
        if(file_exists($file))
        {
            $config['modules'][$filename] = sprintf('app\modules\%s\module', $filename);
        }
    }
}
// 关闭目录
closedir($handler);

return $config;