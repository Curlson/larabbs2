<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/3
 * Time: 16:29
 */

namespace App\Handlers;


use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    
    protected $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
    
    protected $appid = '';
    
    protected $key = '';
    
    protected $salt = '';
    
    public function __construct()
    {
        $this->appid = config('services.baidu_translate.appid');
        $this->key = config('services.baidu_translate.key');
        $this->salt = time();
    }
    
    public function translate($text)
    {
        
        
        // 如果没有配置百度翻译, 自动使用兼容的拼音方案
        if (empty($this->appid) || empty($this->key)) {
            return $this->pinyin($text);
        }
        
        // 根据文档, 生成 sign
        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+密钥 的MD5值
        $sign = md5($this->appid . $text . $this->salt . $this->key);
        
        // 构建请求参数
        $query = http_build_query([
            "q" => $text,
            "from" => 'zh',
            "to" => 'en',
            "appid" => $this->appid,
            "salt" => $this->salt,
            "sign" => $sign,
        ]);
        
        return $this->baiduTranslate($this->api.$query, $text);
        
    }
    
    private function pinyin($text): string
    {
        return Str::slug(app(Pinyin::class)->permalink($text));
    }
    
    private function baiduTranslate(string $url, string $text)
    {
        // 实例化 HTTP 客户端
        $http = new Client();
        
        $response = $http->get($url);
        
        $result = json_decode($response->getBody(), true);
    
        /**
        获取结果，如果请求成功，dd($result) 结果如下：
    
        array:3 [▼
        "from" => "zh"
        "to" => "en"
        "trans_result" => array:1 [▼
        0 => array:2 [▼
        "src" => "XSS 安全漏洞"
        "dst" => "XSS security vulnerability"
        ]
        ]
        ]
     
         **/
        
        // 尝试获取翻译结果
        if (isset($result['trans_result'][0]['dst'])) {
            return Str::slug($result['trans_result'][0]['dst']);
        } else {
            // 百度翻译没有结果, 使用拼音作为后备计划.
            return $this->pinyin($text);
        }
    }
}
