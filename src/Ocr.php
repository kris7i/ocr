<?php

namespace Expnull\Ocr;

use Expnull\Ocr\Exceptions\HttpException;
use GuzzleHttp\Client;

class Ocr
{
    public static $guzzleUrl = '';
    private static $guzzleOptions = array();
    private static $paramImage = '';
    private static $paramUrl = '';
    private static $paramLanguageType = 'CHN_ENG';
    private static $paramDetectDirection = 'true';
    private static $paramDetectLanguage = 'true';
    private static $paramProbability = 'true';
    private static $apiKey = '';
    private static $secretKey = '';
    private static $tokenUrl = 'https://aip.baidubce.com/oauth/2.0/token';
    private static $imgWords = 'https://aip.baidubce.com/rest/2.0/ocr/v1/general_basic';

    public function __construct(string $apiKey, string $secretKey)
    {
        self::$apiKey = $apiKey;
        self::$secretKey = $secretKey;
    }

    /**
     * 获取Token 有效期30天
     *
     * @return mixed
     * @throws HttpException
     * @author EXP_NULL mail:setorget@163.com
     */
    public function getToken()
    {
        self::setGuzzleUrl(self::$tokenUrl . '?grant_type=client_credentials&client_id=' . self::$apiKey . '&client_secret=' . self::$secretKey);

        try {
            return \json_decode(self::getHttpClient(), true);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 请求图片转文字
     *
     * @param string $token
     * @return mixed
     * @throws HttpException
     * @author EXP_NULL mail:setorget@163.com
     */
    public function getImgWords(string $token)
    {
        self::setGuzzleUrl(self::$imgWords . '?access_token=' . $token);
        $param = [
            'url' => self::$paramUrl,
            'language_type' => self::$paramLanguageType,
            'detect_direction' => self::$paramDetectDirection,
            'detect_language' => self::$paramDetectLanguage,
            'probability' => self::$paramProbability,
        ];

        if (! empty($image)) {
            $param['image'] = self::$paramImage;
        }
        self::setGuzzleOptions(['headers' => ['Content-Type' => 'application/x-www-form-urlencoded'], 'form_params' => $param]);
        
        try {
            return \json_decode(self::getHttpClient(), true);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 发送请求
     *
     * @param string $method
     * @return string
     * @author EXP_NULL mail:setorget@163.com
     */
    public function getHttpClient(string $method = 'POST')
    {
        $client = new Client(self::$guzzleOptions);
        return $client->request($method, self::$guzzleUrl)->getBody()->getContents();
    }

    /**
     * 设置需要请求参数
     *
     * @param array $options
     * @author EXP_NULL mail:setorget@163.com
     */
    public function setGuzzleOptions(array $options)
    {
        self::$guzzleOptions = $options;
    }

    /**
     * 设置需要请求的URL
     *
     * @param string $url
     * @author EXP_NULL mail:setorget@163.com
     */
    public function setGuzzleUrl(string $url)
    {
        self::$guzzleUrl = $url;
    }

    /**
     * 设置发送的图片
     *
     * @param string $image
     * @author EXP_NULL mail:setorget@163.com
     */
    public function setImage(string $image)
    {
        self::$paramImage = $image;
    }

    /**
     * 设置发送的图片地址 url格式
     *
     * @param string $url
     * @author EXP_NULL mail:setorget@163.com
     */
    public function setImageUrl(string $url)
    {
        self::$paramUrl = $url;
    }

    /**
     * 设置识别的语言类型
     *
     * @param string $languageType
     * @author EXP_NULL mail:setorget@163.com
     */
    public function setLanguageType(string $languageType)
    {
        self::$paramLanguageType = $languageType;
    }

    /**
     * 是否检测图像朝向 true 检测， false 不检测
     *
     * @param string $detectDirection
     * @author EXP_NULL mail:setorget@163.com
     */
    public function setDetectDirection(string $detectDirection)
    {
        self::$paramDetectDirection = $detectDirection;
    }

    /**
     * 是否返回识别结果中每一行的置信度
     *
     * @param string $probability
     * @author EXP_NULL mail:setorget@163.com
     */
    public function setProbability(string $probability)
    {
        self::$paramProbability = $probability;
    }

    public function setDetectLanguage(string $detectLanguage)
    {
        self::$paramDetectLanguage = $detectLanguage;
    }


}