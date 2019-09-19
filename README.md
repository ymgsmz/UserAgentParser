UserAgentParser
=
[![Build Status](https://travis-ci.org/ymgsmz/UserAgentParser.svg)](https://travis-ci.org/ymgsmz/UserAgentParser/)

User agent parser for Laravel.

Installation
-
Install via composer: 
```bash
$ composer require zarei/user-agent-parser
```

Initialize in Laravel
-
+ Add the service provider to **provider** section in `config/app.php`:
```php
Zarei\UserAgentParser\UserAgentServiceProvider::class,
```

+ Add the alias of User-Agent to **aliases** section in `config/app.php`:
```php
'UserAgentParser' =>  \Zarei\UserAgentParser\Facades\UserAgentParser::class,
```

Usage
-
Parse any User-Agent:
```php
$parsed = UserAgentParser::parse(request()->userAgent());
```
And attend to the table below for finding out how to access parsed data:
 
| Entity  | Getter               | Properties                       | Sample Result
| ------  | ------               | ----------                       | -------------
| Device  | `$parsed->device()`  | ->vendor<br/>->model<br/>->type  | Xiaomi<br/>Mi 5X<br/>mobile
| CPU     | `$parsed->cpu()`     | ->architecture                   | arm
| OS      | `$parsed->os()`      | ->name<br/>->version<br/>->major | Android<br/>8.1.0<br/>8
| Browser | `$parsed->browser()` | ->name<br/>->version<br/>->major | Chrome<br/>74.0.3729.169<br/>74
| Engine  | `$parsed->engine()`  | ->name<br/>->version<br/>->major | Webkit<br/>604.3.5<br/>604
