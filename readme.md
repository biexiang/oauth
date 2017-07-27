## OAuth设计
有Paas在做这项服务，给非开发者都可以使用，相当于一个平台，接入应用和Providers，比如我有一个App需要这项服务，就可以申请一个账号，会给我回调地址，Token，我在我的应用登录页面使用它的服务，跳转到他的用户登录页面，用户可以选择注册登录或者使用第三方提供者的账号登录，登录成功后页面跳转到回调地址，我可以通过回调的参数和Token取他那儿获取用户的信息，这样子的话，用户登录和注册就都使用第三方的工具了，用户数据应该是有接口可以获取回来的。    
只适合小型的开发工具或者网站，大用户量的网站不会愿意把自己的用户数据存储到别人的平台。

#### 方便理解搭建一个OAuth Provider和应用登录授权Demo
__OAuth Provider:__     
- Provider端: 允许应用注册,应用需要注册账号,某一个接口返回该应用的APIKey和Access_token,供应用配置此Provider。应用登录请求过来时,提供接口去验证APIKEY,并且跳转到用户登录授权界面,授权通过后,调用回调链接,添加validate_code。在服务端设置此次授权的过期时效。    
- 应用端:  提供配置Provider的信息,一个Fake的应用首页,点击登录跳转到Provider的登录界面, 输入Provider的账户密码后,登录成功后,跳转到callback,配置callback,拿validate_code去调用获取token,拿token获取用户信息,存储到应用数据库,然后跳转到refer链接,显示登录成功,显示用户信息。     

__技术方面:__      
使用laravel。      
应用端使用,一个控制器做Provider的回调,一个路由页面做首页,一个路由页面做登录页面,配置文件配置相关的参数。    
Provider端使用,一个登录,注册页面,一个获取APIKEY,Access_token接口,一个展示登录处理回调页面。   








<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
# oauth
