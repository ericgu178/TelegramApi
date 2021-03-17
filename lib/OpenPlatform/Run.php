<?php
namespace TelegramApi\lib\OpenPlatform;

class Run
{
    /**
     * 工具类api
     *
     * @var string
     * @author EricGU178
     */
    private $tool;

    /**
     * 配置
     *
     * @var string
     */
    private $config;

    public function __construct($config=[])
    {
        if(empty($config)){
            throw new \Exception("Telegram配置文件不存在");
        }
        $this->config = $config;
    }

    /**
     * 不存在获取
     *
     * @param [type] $name
     * @return void
     * @author EricGU178
     */
    public function __get($name) 
    {
        $classname = self::title($name);
        $class = "\\TelegramApi\\lib\\OpenPlatform\\{$classname}\\Index";
        if(class_exists($class)){
            return new $class($this->config);
        }else{
            throw new \Exception("暂时没有这个类");
        }
    }
    
    static private function title($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        $name = str_replace(" ",'', $value);
        return $name;
    }
}