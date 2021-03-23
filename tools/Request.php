<?php
namespace TelegramApi\tools;

class Request
{
    /**
     * get 请求
     *
     * @param string $url
     * @param array $headers
     * @param boolean $isProxy
     * @param string $proxy
     * @return void
     * @author EricGU178
     */
    static public function requestGet(string $url, $headers = [],$isProxy = false , $proxy = '')
    {
        $curl = curl_init();
        //设置选项，包括URL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if ($isProxy == true) {
            curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
        //执行并获取HTML文档内容
        $response = curl_exec($curl);
        //释放curl句柄
        curl_close($curl);

        return $response;
    }

    /**
     * post 请求
     *
     * @param string $url
     * @param array $headers
     * @param boolean $isProxy
     * @param string $proxy
     * @return void
     * @author EricGU178
     */
    static public function requestPost(string $url,array $data = [], array $headers = [], $isProxy = false , $proxy = '')
    {
        $curl  = curl_init();
        //设置选项，包括URL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
        if ($isProxy == true) {
            curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
        //执行并获取HTML文档内容
        $response = curl_exec($curl);
        //释放curl句柄
        curl_close($curl);
    
        return $response;
    }
}