<?php
namespace TelegramApi;

class Telegram
{
    /**
     * 初始化
     *
     * @param string $name
     * @param array $config
     * @return class
     * @author EricGU178
     */
    static public function init($name,array $config)
    {
        $namespace = self::title($name);
        $class = "\\TelegramApi\\lib\\{$namespace}\\Run";
        if (class_exists($class)) {
            return new $class($config);
        } else {
            trigger_error("Error: Telegram::{$name}，please check");
        }
    }

    /**
     * 重载
     *
     * @return void
     * @author EricGU178
     */
    static public function __callStatic($name, $arguments)
    {
        return self::init($name, ...$arguments);//参数展开
    }

    static private function title($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return $value;
    }
}