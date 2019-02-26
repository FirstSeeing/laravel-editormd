# Editor.md For Laravel5

## 介绍
基于Editor.md实现的laravel的扩展, 参考LaravelChen/laravel-editormd项目，去除七牛云扩展特地版本依赖，如有需要自己在项目中单独扩展(更灵活)
> Editor.md官网:https://pandao.github.io/editor.md/examples/index.html

## 效果
### 默认样式
[![效果](http://image.luzucheng.com/5c751d6cdfc18_16.png "效果")](http://image.luzucheng.com/5c751d6cdfc18_16.png "效果")

## 安装
### 使用composer安装扩展
```
composer require luzucheng59/laravel-editormd
```
### config/app.php 添加provider
```
'providers' => [
    Zu\Editormd\EditorMdProvider::class,
];
```
### 最后生成配置文件
```
php artisan vendor:publish
```

## 用法
### 配置(config/editormd.php)
```
<?php
return [
    'upload_path'        => '/upload/images/',//上传文件的地址 需要设置为可写
    'upload_type'        => '',//上传的方式qiniu或者本地, 本地:'',七牛:'qiniu'
    'upload_http'        => '',//https或者为空
    'width'              => 'auto',//宽度建议100%
    'height'             => '500',//高度
    'theme'              => 'default',//顶部的主题分为default和dark
    'editorTheme'        => 'default',//显示区域的主题分为default和pastel-on-dark 注:如果想要配置其他主题，请参考vendor/editormd/lib/theme目录下的css文件
    'previewTheme'       => 'default',//编辑区域的主题分为default,dark,
    'flowChart'          => 'true',  //流程图
    'tex'                => 'true',  //开启科学公式TeX语言支持
    'searchReplace'      => 'true',//搜索替换
    'saveHTMLToTextarea' => 'true',  //保存 HTML 到 Textarea
    'codeFold'           => 'true',  //代码折叠
    'emoji'              => 'true',  //emoji表情
    'toc'                => 'true',  //目录
    'tocm'               => 'true',  //目录下拉菜单
    'taskList'           => 'true',  //任务列表
    'imageUpload'        => 'true',  //图片本地上传支持
    'sequenceDiagram'    => 'true',  //开启时序/序列图支持
];
```

### 七牛云
使用七牛云存储请先安装扩展: zgldh/qiniu-laravel-storage
> 参考：https://github.com/zgldh/qiniu-laravel-storage

### 例子(请在editor_js()之前引用jquery)
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {!! editor_css() !!}
</head>
<body>
<div class="container">
    <div class="col-md-12" style="margin-top: 50px">
        <div id="editormd_id">
            <textarea name="content" style="display:none;"></textarea>
        </div>
    </div>
</div>
<script src="//cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
{!! editor_js() !!}
</body>
</html>
```

>OK！尽请使用吧!


