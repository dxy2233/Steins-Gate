<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class'=>yii\web\UrlManager::className(),
//            'enablePrettyUrl' => true,//url美化变正斜杠了
//            'showScriptName' => false,//是否在生成的Url里面隐藏入口文件
            'enablePrettyUrl' => true,
            // 隐藏index.php，在URL路径中是否显示脚本入口文件
            'showScriptName' => true,
            // 是否执行严格的url解析
//            'enableStrictParsing' => false,
            // 后缀，如果设置了此项，那么浏览器地址栏就必须带上.html后缀，否则会报404
//            'suffix' => '.html',
            //'suffix'=>'.html',//伪后缀
            'rules' => [
            ],
        ],
    ],
];
