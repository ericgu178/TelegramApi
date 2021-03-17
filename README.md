## TelegramApi

适用机器人 必须需要管理权限


```php
    $config = [
        'api_id'    =>  '', // api id
        'api_hash'  =>  '', // api hash
        'botToken'  =>  '', // @EricGU178Bot
        'chat_id'   =>  '@wechatGroupQrCode'
    ];
    $telegram = Telegram::openPlatform(self::$config);
    $res = $telegram->Message->sendMessage($text = 'Hello World');
    var_dump($res); // json 数据 去群组查看
```