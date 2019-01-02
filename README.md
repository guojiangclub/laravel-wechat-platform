## 微信第三方平台

[![Latest Stable Version](https://poser.pugx.org/ibrand/laravel-wechat-platform/v/stable)](https://packagist.org/packages/ibrand/laravel-wechat-platform)
[![Latest Unstable Version](https://poser.pugx.org/ibrand/laravel-wechat-platform/v/unstable)](https://packagist.org/packages/ibrand/laravel-wechat-platform#dev-master)
[![License](https://poser.pugx.org/ibrand/laravel-wechat-platform/license)](https://packagist.org/packages/ibrand/laravel-wechat-platform)

1. 基于 [overtrue/wechat](https://github.com/overtrue/wechat) 进行扩展开发
2. [微信第三方平台概述](https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419318292&token=&lang=zh_CN)

## Featrue


主要实现功能：

1. 微信第三方管理后台，实现对微信公众号和微信小程序，授权的统一管理。（搭建自己的微信第三方授权平台）。

2. 提供常用微信公众号和小程序开发相关的接口。

3. 后台包括微信公众号管理和小程序管理，实现一键提交审核，发布微信小程序，自定义小程序模板等功能。


## 安装

```
composer require ibrand/laravel-wechat-platform:~1.0 -vvv
```

低于 Laravel5.5 版本

`config/app.php` 文件中 'providers' 添加

```
iBrand\Wechat\Platform\Providers\WechatPlatformServiceProvider::class,
iBrand\Wechat\Platform\Providers\RouteServiceProvider::class,

```

请按照步骤执行相关php artisan操作

```
 php artisan vendor:publish --all
```
```
 php artisan ibrand:backend-install
```
```
 php artisan ibrand-wechat-platform:install
```
```
 php artisan passport:install 
```
```
 php artisan storage:link

```

配置 .env文件

```
WECHAT_OPEN_PLATFORM_APPID=             //微信开放平台AppID
WECHAT_OPEN_PLATFORM_SECRET=	        //微信开放平台AppSecret
WECHAT_OPEN_PLATFORM_TOKEN=             //消息校验Token
WECHAT_OPEN_PLATFORM_AES_KEY=           //消息加解密Key

```
CSRF验证中排除的URI
找到App\Http\Middleware\VerifyCsrfToken中except属性数组中添加一条

```
 "/oauth/token"
```

添加routeMiddleware
找到App\Http\Kernel中routeMiddleware属性数组中添加

```
'client' => \iBrand\Wechat\Platform\Http\Middleware\ClientVerify::class,
'parameter' => \iBrand\Wechat\Platform\Http\Middleware\ParameterVerify::class,

```

修改config\auth.php文件
guards数组添加
```
 'clients' => [
            'driver' => 'passport',
            'provider' => 'clients',
],

```
providers数组添加
```
'clients' => [
            'driver' => 'eloquent',
            'model' =>iBrand\Wechat\Platform\Models\Clients::class,
],

```

后台地址

```
域名/admin 

用户名: admin 密码: admin
```

接口文档整理中。




