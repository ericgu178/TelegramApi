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

    /**
     * https://core.telegram.org/method/messages.sendMediaGroup
     * 
     * 发送组合图片消息
     * 数组InputMediaAudio，InputMediaDocument，InputMediaPhoto和InputMediaVideo
     * $data = ['chat_id' =>  '@wechatGroupQrCode','media' =>  json_encode([
     *      [
     *          'type'  =>  'photo', video audio
     *          'media' =>  'https://ww1.sinaimg.cn/large/6d28b716ly1goswssp7huj20s311cq87.jpg',
     *          'caption'   =>  '微博'
     *      ],
     *      [
     *          'type'  =>  'photo',
     *          'media' =>  $messaggInfo,
     *          'caption'   =>  'aaaa'
     *      ],
     *  ],256)];
     *              $postContent = [
     *          chat_id' => $GLOBALS['chatId'],
     *          media' => json_encode([
     *             ['type' => 'photo', 'media' => 'attach://file1.png' ],
     *             ['type' => 'photo', 'media' => 'attach://file2.png' ],
     *          ),
     *          file1.png' => new CURLFile(realpath($filePath1)),
     *          file2.png' => new CURLFile(realpath($filePath2)),
     *           ];
     *               post($url, $postContent);
     * @param string $photo 小于5M的图片链接
     * @param string $caption 介绍
     * @return void
     * @author EricGU178
     */
    public function sendMediaGroup(array $media)
    {
        $url = $this->base_url . '/sendMediaGroup';
        if (!\is_array($media)) {
            throw new \Exception('必须是一个数组');
        }
        $data = [
            'chat_id'   =>  $this->chat_id,
            'media'     =>  json_encode($media,256)
        ];
        $result = Request::requestPost($url,$data,[],true,self::$proxy);
        return $result;
    }
}