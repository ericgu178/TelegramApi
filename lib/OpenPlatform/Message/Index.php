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
        self::$proxy = empty($config['proxy']) ? 'socks5h://localhost:1080' : $config['proxy'];
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
    public function sendMediaGroup(array $media,array $ext = [])
    {
        $url = $this->base_url . '/sendMediaGroup';
        if (!\is_array($media)) {
            throw new \Exception('必须是一个数组');
        }
        $pre_data = [
            'chat_id'   =>  $this->chat_id,
            'media'     =>  json_encode($media,256)
        ];
        $data = array_merge($pre_data,$ext);
        $result = Request::requestPost($url,$data,[],true,self::$proxy);
        return $result;
    }

    /**
     * 如果希望Telegram客户端在音乐播放器中显示它们，请使用此方法发送音频文件。
     * 您的音频必须为.MP3或.M4A格式。
     * 成功后，将返回发送的消息。
     * 机器人目前最多可以发送50 MB的音频文件，以后可能会更改此限制。
     *
     * https://core.telegram.org/bots/api#sendaudio
     * 
     * @param $file_url string
     * @return void
     * @author EricGU178
     */
    public function sendAudio(string $file_url,array $ext = [])
    {
        if (empty($file_url)) {
            throw new \Exception('文件网络地址没有传入');
        }
        $url = $this->base_url . '/sendAudio';
        $data = [
            'chat_id'   =>  $this->chat_id,
            'audio'     =>  $file_url
        ];
        $request_data = array_merge($data,$ext);
        $result = Request::requestPost($url,$request_data,[],true,self::$proxy);
        return $result;
    }

    /**
     * 使用此方法发送视频文件，Telegram客户端支持mp4视频（其他格式也可以作为Document发送）。
     * 成功后，将返回发送的消息。
     * 机器人目前最多可以发送50 MB的视频文件，以后可能会更改此限制。
     *
     * @param string $video_url
     * @param array $ext
     * @return void
     * @author EricGU178
     */
    public function sendVideo(string $video_url,array $ext = [])
    {
        if (empty($video_url)) {
            throw new \Exception('文件网络地址没有传入');
        }
        $url = $this->base_url . '/sendVideo';
        $data = [
            'chat_id'   =>  $this->chat_id,
            'video'     =>  $video_url
        ];
        $request_data = array_merge($data,$ext);
        $result = Request::requestPost($url,$request_data,[],true,self::$proxy);
        return $result;
    }

    /**
     * 使用此方法仅编辑邮件的答复标记。成功后，如果编辑后的消息不是嵌入式消息，则返回编辑后的消息，否则返回True。
     *
     * @param string $video_url
     * @param array $ext
     * @return void
     * @author EricGU178
     */
    public function editMessageReplyMarkup($ids,$reply_markup)
    {
        if (!empty($ids['chat_id']) && !empty($ids['message_id'])) {
            $data = [
                'chat_id'   =>  $ids['chat_id'],
                'message_id'    =>  $ids['message_id'],
            ];
        } else if (!empty($ids['inline_message_id'])) {
            $data = [
                'inline_message_id'   =>  $ids['inline_message_id'],
            ];
        }

        if (!\is_string($reply_markup)) {
            $reply_markup = json_encode($reply_markup,256);
        }
        $data['reply_markup'] = $reply_markup;
        $url = $this->base_url . '/editMessageReplyMarkup';
        $result = Request::requestPost($url,$data,[],true,self::$proxy);
        return $result;
    }
}