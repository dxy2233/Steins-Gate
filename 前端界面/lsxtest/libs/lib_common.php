<?php

/**
 */

use yii\base\Model;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Cookie;
use common\AppParams;

define('FRONTEND_APP_ID', 'app-frontend');
define('BACKEND_APP_ID', 'app-backend');
// 根目录
define('ROOT_PATH', dirname(__DIR__));
// 如果域名带端口号则去掉端口号
$port = parse_url($_SERVER["HTTP_HOST"], PHP_URL_PORT);


/**
 * 判断是否为前台移动端商城系统
 */
function is_frontend_app ()
{
    return \Yii::$app->id == FRONTEND_APP_ID;
}

function is_backend_app ()
{
    return \Yii::$app->id == BACKEND_APP_ID;
}

/**
 * 网站URL
 *
 * @param string $path
 * @return string
 */
function homeurl ($path = null, $site_enable = true)
{
    $key = '__HOME_DOMAIN__';
    $result = AppParams::get($key);
    if(empty($result))
    {
        if(is_frontend_app())
        {
            $domain = $_SERVER['HTTP_HOST'];
        }
        if(is_backend_app())
        {
            $domain = 'backend.lsx.com';
        }
        // 临时保存
        AppParams::set($key, $domain);
    }
    else
    {
        $domain = AppParams::get($key);
    }

    if(empty($path))
    {
        return Url::to('http://' . $domain);
    }

    $url = Url::to('http://' . $domain . '/' . $path);
    $url = str_replace('//', '/', $url);
    $url = str_replace(':/', '://', $url);

    return $url;
}

function gmtime ($time = null)
{
    if(empty($time))
    {
        return time();
    }
    return time();
}

/**
 * 图片URL
 *
 * @param string $path
 * @return string
 */
function imageurl ($path = null, $site_enable = true)
{
    $key = '__HOME_DOMAIN__';

    $domain = 'pic.lsx.earthwa.com';
    $domain='pic.liushuixi.com';

    if(empty($path))
    {
        return Url::to('http://' . $domain);
    }

    $url = Url::to('http://' . $domain . '/' . $path);
    $url = str_replace('//', '/', $url);
    $url = str_replace(':/', '://', $url);

    return $url;
}




function setFlashMessage ($key, $value = true, $removeAfterAccess = true)
{
    \Yii::$app->getSession()->setFlash($key, $value, $removeAfterAccess);
}


/**
 * 格式化消息
 *
 * It uses the PHP intl extension's [MessageFormatter](http://www.php.net/manual/en/class.messageformatter.php)
 * and works around some issues.
 * If PHP intl is not installed a fallback will be used that supports a subset of the ICU message format.
 *
 * @param string $pattern
 *        	The pattern string to insert parameters into.
 * @param array|mix $params
 *        	如果不为数组，则将自动从第二个参数开始以后的所有参数自动认为是格式化消息的数组
 *        	<p>例如：</p>
 *        	<p>format("我的名字叫{0},今年{1}岁", ['Neo',28])</p>
 *        	<p>同</p>
 *        	<p>format("我的名字叫{0},今年{1}岁", 'Neo',28)</p>
 *        	The array of name value pairs to insert into the format string.
 * @return string|boolean The formatted pattern string or `FALSE` if an error occurred
 */
function format ($message, $params)
{
    $language = \Yii::$app->language;

    $i18n = \Yii::$app->i18n;

    if(isset($i18n))
    {
        if(is_array($params) == false)
        {
            $params = array_slice(func_get_args(), 1);
        }

        return \Yii::$app->getI18n()->format($message, $params, $language);
    }

    return $message;
}
/**
 * 从get提交方式中获取参数
 *
 * @param string $name
 * @param unknown $default
 */
 function gets ($name = null, $default = null)
{
    return Yii::$app->request->get($name, $default);
}

/**
 * 从post提交方式中获取参数
 *
 * @param string $name
 * @param unknown $default
 */
 function posts ($name = null, $default = null)
{
    return Yii::$app->request->post($name, $default);
}
/*
 * 分页第一版
 */
function page($query=null)
{
    $pagelist=[];
    $fileter=[];
    if(empty($query))
    {
        return false;
    }
    //分页
    $page=gets('page')?gets('page'):posts('page');
    $count=$query->count();
    if(empty($page))
    {
        $page=1;
    }
    $pagesize=ceil($count/10);
    $page=$page<1?1:$page;
    $page=$page<=$pagesize?$page:$pagesize;
    $pagecount=$page*10;
    $pagestart=($page-1)*10+1;
    if($pagecount>$count)
    {
        $pageend=$count;
    }
    else
    {
        $pageend=$page*10;
    }
    $query->offset(($page-1)*10);
    $query->limit(10);

    $data=$query->all();
    //总数
    $pagelist['count']=$count;
    //起始条数
    $pagelist['pagestart']=$pagestart;
    //结束条数
    $pagelist['pageend']=$pageend;
    //页数
    $pagelist['pagesize']=$pagesize;
    //当前页数
    $pagelist['page']=$page;
    $fileter['page']=$pagelist;
    $fileter['data']=$data;
    return $fileter;
}
/*
 * 分页第二版
 */
function fenye($data=null,$page=null,$pagenumber=10)
{
    $pagelist=[];
    $fileter=[];
    $count=count($data);
    //分页
    $page=gets('page')?gets('page'):posts('page');
    /*
     * 判断页数是否正确
     */
    if($count==0)
    {
        //总数
        $pagelist['count']=0;
        //起始条数
        $pagelist['pagestart']='';
        //结束条数
        $pagelist['pageend']='';
        //页数
        $pagelist['pagesize']='';
        //当前页数
        $pagelist['page']='';
        $fileter['page']=$pagelist;
        $fileter['data']='';
    return $fileter;

    }
    $page=(empty($page))?'1':$page;
    /*
     * 判断数组应该有多少页
     */
    $pagesize=ceil($count/$pagenumber);
    /*
     * 如果页数大于数组最大的页数，则限制页数最大页
     */
    if($page>$pagesize)
    {
        $page=$pagesize;
    }

    $pagecount=$page*$pagenumber;
    $pagestart=($page-1)*$pagenumber+1;
    if($pagecount>$count)
    {
        $pagelimit=$count-(($page-1)*$pagenumber);
        $pageend=$count;
        $rows=array_slice($data,($page-1)*$pagenumber,$pagelimit);
    }
    else{
        $pageend=$page*$pagenumber;
        $rows=array_slice($data,($page-1)*$pagenumber,$pagenumber);
    }
    //总数
    $pagelist['count']=$count;
    //起始条数
    $pagelist['pagestart']=$pagestart;
    //结束条数
    $pagelist['pageend']=$pageend;
    //页数
    $pagelist['pagesize']=$pagesize;
    //当前页数
    $pagelist['page']=$page;
    $fileter['page']=$pagelist;
    $fileter['data']=$rows;
    return $fileter;
}
/*
 * 加密密码方法
 */
function setpassword($password)
{
    $password=Yii::$app->security->generatePasswordHash($password);
    return $password;
}
//判断密码是否正确$password待验证密码  $hash数据库密码
function getpassword($password,$hash)
{
    $res=Yii::$app->security->validatePassword($password, $hash);
    return $res;

}

/*
 * 通常存储cookie,名字内容时间
 */
//function setcookie($name,$value,$time)
//{
//    $cookies= \YII::$app->response->cookies;
//    $data=[
//        'name'=>$name,
//        'value'=>$value,
//        'expire'=>$time
//    ];
//    $cookies->add(new Cookie($data));
//}
/**
 * 格式化显示价格
 *
 * @param mixed $price
 * @param boolean $is_number
 *        	是否仅格式化数字
 */
function format_price ($price = false, $is_number = true)
{
    if(is_numeric($price))
    {
        // 商品价格显示规则
//        $price_show_rule = SystemConfig::get('price_show_rule', 0);
        $price_show_rule = 1;
        // 保留两位小数
        if($price_show_rule == 1)
        {
            $price = substr(number_format($price, 3, '.', ''), 0, - 1);
        }
        // 不保留小数部分为0的尾数
        elseif($price_show_rule == 2)
        {
            $price = preg_replace('/(.*)(\\.)([0-9]*?)0+$/', '\1\2\3', number_format($price, 2, '.', ''));

            if(substr($price, - 1) == '.')
            {
                $price = substr($price, 0, - 1);
            }
        }

//        $format = SystemConfig::get('goods_price_format', null);

        if(! empty($format))
        {
            $price = format($format, $price);
        }
    }
    else if($is_number == false)
    {
//        $format = SystemConfig::get('goods_price_format', null);

        if(! empty($format))
        {
            $price = format($format, $price);
        }
    }

    return $price;
}



/**
 * 根据$model获取表单名称
 *
 * @param \common\base\Model $model
 * @return string 表单名称
 */
function formName (Model $model)
{
    return $model->formName();
}

/**
 * 产生csrf
 *
 * @return string
 */
function csrf ()
{
    return \Yii::$app->request->getCsrfToken();
}




/**
 * 发送curl
 *
 * @param unknown $mobile
 */
function send_curl ($content)
{
    try
    {

        // 初始化
        $curl = curl_init();
        // 设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $content);
        // 设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, false);
        // 设置获取的信息以文件流的形式返回，而不是直接输出。
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // 执行命令
        $data = curl_exec($curl);
        // 关闭
        curl_close($curl);
    }
    catch(Exception $e)
    {
        $data = "";
    }

    return $data;
}


/**
 * 获得用户的真实IP地址
 *
 * @access public
 * @return string
 */
function real_ip ()
{
    static $realip = NULL;

    if($realip !== NULL)
    {
        return $realip;
    }

    if(isset($_SERVER))
    {
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            // 取X-Forwarded-For中第一个非unknown的有效IP字符串
            foreach($arr as $ip)
            {
                $ip = trim($ip);

                if($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif(isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if(isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if(getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif(getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = ! empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}

/**
 * 高德地图根据经纬度获取地理信息
 *
 * @param number $lng
 * @param number $lat
 */
function amapLocation ($lng, $lat)
{
    $url = 'http://restapi.amap.com/v3/geocode/regeo?key={0}&location={1},{2}&radius=1000&extensions=all';

//    $key = SystemConfig::get('amap_web_key', null);
    $key = '47aca0ef9366003d7b151de133a962a9';

    $url = format($url, $key, $lng, $lat);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    if(! empty($timeoutMs))
    {
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $timeoutMs);
    }

    $result = curl_exec($ch);

    curl_close($ch);

    $result = json_decode($result, JSON_OBJECT_AS_ARRAY);

    if($result['status'] == 1)
    {
    }

    var_dump($result);
}

/**
 * @desc 根据两点间的经纬度计算距离
 * @param float $lat 纬度值
 * @param float $lng 经度值
 */
function getDistance($lat1, $lng1, $lat2, $lng2)
{
    $earthRadius = 6367000; //approximate radius of earth in meters

    /*
    Convert these degrees to radians
    to work with the formula
    */

    $lat1 = ($lat1 * pi() ) / 180;
    $lng1 = ($lng1 * pi() ) / 180;

    $lat2 = ($lat2 * pi() ) / 180;
    $lng2 = ($lng2 * pi() ) / 180;

    /*
    Using the
    Haversine formula

    http://en.wikipedia.org/wiki/Haversine_formula

    calculate the distance
    */

    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;

    return round($calculatedDistance);
}

/**
 * @param string $beginTime1 开始时间1
 * @param string $endTime1 结束时间1
 * @param string $beginTime2 开始时间2
 * @param string $endTime2 结束时间2
 * @return bool
 */
function is_time_cross($beginTime1 = '', $endTime1 = '', $beginTime2 = '', $endTime2 = '') {
    $status = $beginTime2 - $beginTime1;
    if ($status > 0) {
        $status2 = $beginTime2 - $endTime1;
        if ($status2 >= 0) {
            return false;
        } else {
            return true;
        }
    } else {
        $status2 = $endTime2 - $beginTime1;
        if ($status2 > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * 根据时间戳获取时间y-m-d h
 *
 */
function getTimeBytimestamp($str)
{
    return date('Y-m-d H:i:s',$str);
}

/**
 * @param $str
 * @return false|string
 * 时间戳转Y-m-d
 */
function getTime($str)
{
    return date('Y-m-d',$str);
}
/**
 * @param $args
 * @param $key
 * @return string
 * 生成签名
 */
function makeSignature($args, $key)
{
    if(isset($args['sign'])) {
        $oldSign = $args['sign'];
        unset($args['sign']);
    } else {
        $oldSign = '';
    }

    ksort($args);
    $requestString = '';
    foreach($args as $k => $v) {
        $requestString .= $k . '=' . urlencode($v);
    }
    $newSign = hash_hmac("md5",strtolower($requestString) , $key);
    return $newSign;
}

function getregionnameBycode ($code) {
    $result = \common\models\Region::find()->select('region_name')->where(['region_code'=>$code])->one();
    if ($result !==false) {
        return $result->region_name;
    }
    return '';
}
