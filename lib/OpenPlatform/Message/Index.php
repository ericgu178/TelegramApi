<?php
namespace TelegramApi\lib\OpenPlatform\Message;
use TelegramApi\tools\Request;
/**
 * telegram 发送消息系列api
 *
 * @author EricGU178
 */
class Index
{
    /**
     * bot api地址
     *
     * @var string
     */
    private $base_url = 'https://api.telegram.org/bot';

    /**
     * 频道id 或者群组id
     *
     * @var string
     */
    private $chat_id;

    static $proxy = 'socks5h://127.0.0.1:1080';

    public function __construct($config)
    {
        $this->base_url = $this->base_url . $config['botToken'];
        $this->chat_id = $config['chat_id'];
    }

    /**
     * https://core.telegram.org/method/messages.sendMessage
     * 
     * 发送文本消息
     *
     * @return void
     * @author EricGU178
     */
    public function sendMessage(string $text)
    {
        $data = [
            'text'  =>  $text,
        ];
        $str = '?chat_id' . $this->chat_id . '&';
        foreach ($data as $key => $value) {
            $str .= $key . '=' . $value . '&';
        }
        rtrim($str,'&');
        $this->base_url = $this->base_url . $str;
        $result = Request::requestGet($this->base_url,[],true,self::$proxy);
        return $result;
    }
}