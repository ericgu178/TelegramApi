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

    static $proxy = 'socks5h://localhost:1080';

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
    public function sendMessage(string $text,array $ext = [])
    {
        $url = $this->base_url . '/sendMessage?chat_id=' . $this->chat_id . '&';
        $must_keys = [
            'text'  =>  urlencode($text),
        ];
        $data = array_merge($must_keys,$ext);
        foreach ($data as $key => $value) {
            $url .= $key . '=' . $value . '&';
        }
        rtrim($url,'&');
        $result = Request::requestGet($url,[],true,self::$proxy);
        return $result;
    }

    /**
     * https://core.telegram.org/method/messages.sendPhoto
     * 
     * 发送图片消息
     *
     * @param string $photo 小于5M的图片链接
     * @param string $caption 介绍
     * @return void
     * @author EricGU178
     */
    public function sendPhoto(string $photo,string $caption ,array $ext = [])
    {
        $url = $this->base_url . '/sendPhoto?chat_id=' . $this->chat_id . '&';
        $must_keys = [
            'photo'  =>  urlencode($photo),
            'caption'   =>  urlencode($caption)
        ];
        $data = array_merge($must_keys,$ext);
        foreach ($data as $key => $value) {
            $url .= $key . '=' . $value . '&';
        }
        rtrim($url,'&');
        $result = Request::requestGet($url,[],true,self::$proxy);
        return $result;
    }
}