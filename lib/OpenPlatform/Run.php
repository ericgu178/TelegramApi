<?php
namespace TelegramApi\lib\OpenPlatform;

class Run
{
    /**
     * 配置
     *
     * @var string
     */
    private $config;

    public function __construct($config=[])
    {
        if(empty($config)){
            throw new \Exception("Telegram config file don't exists");
        }
        $this->config = $config;
    }

    /**
     * 不存在获取
     *
     * @param string $name
     * @return void
     * @author EricGU178
     */
    public function __get($name) 
    {
        $classname = self::title($name);
        $class = "\\TelegramApi\\lib\\OpenPlatform\\{$classname}\\Index";
        if (class_exists($class)) {
            return new $class($this->config);
        } else {
            // 没有这个类 请检查书写问题
            throw new \Exception('No such class，Please check for writing issues');
        }
    }
    
    static private function title($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        $name = str_replace(" ",'', $value);
        return $name;
    }
}