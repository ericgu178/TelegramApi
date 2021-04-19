<?php
namespace TelegramApi\lib\OpenPlatform\Hook;
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
        self::$proxy = empty($config['proxy']) ? 'socks5h://localhost:1080' : $config['proxy'];
    }

    /**
     * 获取轮训
     *
     * @return void
     * @author EricGU178
     */
    public function getUpdates($allowed_updates) 
    {
        $url = $this->base_url . '/getUpdates';
        if (!empty($allowed_updates)) {
            $data = [
                'allowed_updates'   =>  $allowed_updates
            ];
        }
        $result = Request::requestPost($url,$data,[],true,self::$proxy);
        return $result;
    }

    /**
     * 获取轮训
     *
     * 使用此方法将答案发送给从嵌入式键盘发送的回调查询。答案将作为通知显示在用户的聊天屏幕顶部或作为警报。成功时，返回True。
     * @return void
     * @author EricGU178
     */
    public function answerCallbackQuery($callback_query_id,$text = '',$ext = [])
    {
        $url = $this->base_url . '/answerCallbackQuery';
        $pre_data = [
            'callback_query_id'   =>  $callback_query_id,
            'text'  =>  $text
        ];
        $data = \array_merge($pre_data,$ext);
        $result = Request::requestPost($url,$data,[],true,self::$proxy);
        return $result;
    }

    /**
     * 设置Hook
     * @return void
     * @author EricGU178
     */
    public function setWebhook($url)
    {
        $url = $this->base_url . '/setWebhook';
        $data = [
            'url'   =>  $url
        ];
        $result = Request::requestPost($url,$data,[],true,self::$proxy);
        return $result;
    }
}