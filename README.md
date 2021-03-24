<h1 align="center" style="font-size:60px;color:skyblue;font-weight:700">
    TelegramApi
</h1>

## 清单
- [安装](#安装)
- [关于](#关于)
- [使用](#使用)
- [接口](#接口)
    - [Message](#Message)


## 安装
使用下面的命令安装<br>
`composer require ericgu178/telegram-api`
<br>
在 php 文件中 使用
<br>
`use TelgramApi/Telegram`

## 关于

这是目前我自用封装的电报api代码，仅仅涉及到了Message这块api的发送并没有完全适配完所有电报api，什么时间用到别的或者有bug会修改，其他的欢迎下载在基础上push代码，后续我也会完善的。

## 使用

目前适用机器人（没测试别的） 需要给予管理权限

```php
    $config = [
        'api_id'    =>  '', // api id
        'api_hash'  =>  '', // api hash
        'botToken'  =>  '', // @EricGU178Bot
        'chat_id'   =>  '@wechatGroupQrCode'
    ];
    $telegram = Telegram::openPlatform($config);
    $res = $telegram->Message->sendMessage($text = 'Hello World');
    var_dump($res); // json 数据 去群组查看
```
## 接口
目前 只有 /lib/OpenPlatform/Message/ 中三个方法 sendPhoto sendMessage sendGroupMedia
### Message

使用 sendPhoto


```php
    $res = $telegram->Message->sendPhoto(string $url,array $ext = []); // $ext 其他参数
    var_dump($res);
```

使用 sendGroupMedia


```php
    $res = $telegram->Message->sendGroupMedia([
        [
            'type'  =>  'photo',
            'media' =>  'https://ww1.sinaimg.cn/large/6d28b716ly1goswssp7huj20s311cq87.jpg',
            'caption'   =>  '微博'
        ],
        [
            'type'  =>  'photo',
            'media' =>  'https://ww1.sinaimg.cn/large/6d28b716ly1goswssp7huj20s311cq87.jpg',            
            'caption'   =>  'aaaa'
        ],
    ]); // $ext 其他参数
    var_dump($res);
```

