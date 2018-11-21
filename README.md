<h1 align="center"> ocr图片识别 </h1>

<p align="center"> 基于百度API的图片识别.</p>


## 安装

```shell
$ composer require expnull/ocr
```

## 配置

在使用本扩展之前，你需要去 [百度AI开放平台](http://ai.baidu.com/) 注册账号，然后创建应用，获取应用的 API Key

## 使用

```shell
use Expnull\Ocr\Ocr;
```
```shell
$apiKey    = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
$secretKey = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
```
```shell
$ocr = new Ocr($apiKey, $secretKey);
$token = $ocr->getToken(); // 获取token,有效期理论上30天，请自行保存
```
```shell
$ocr->setImage('xxxxx'); // 图像数据，base64编码后进行urlencode，要求base64编码和urlencode后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效
$ocr->setImageUrl('http://'); // 图片完整URL，URL长度不超过1024字节，URL对应的图片base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效，不支持https的图片链接
$ocr->setLanguageType('CHN_ENG'); // 识别语言类型，默认为CHN_ENG。可选值包括：CHN_ENG：中英文混合； ENG：英文； POR：葡萄牙语； FRE：法语； GER：德语； ITA：意大利语； SPA：西班牙语； RUS：俄语； JAP：日语； KOR：韩语
$ocr->setDetectDirection('true'); // 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括: true：检测朝向； false：不检测朝向。
$ocr->setProbability('true'); // 是否返回识别结果中每一行的置信度
$ocr->setDetectLanguage('true'); // 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
```
```shell
$words = $ocr->getImgWords($token['access_token']);
```

#### 示例
```shell
array:5 [▼
  "log_id" => 6.572111E+18
  "direction" => 0
  "words_result_num" => 1
  "words_result" => array:1 [▼
    0 => array:2 [▼
      "words" => "神马"
      "probability" => array:3 [▼
        "variance" => 0.010854
        "average" => 0.895663
        "min" => 0.79148
      ]
    ]
  ]
  "language" => -1
]
```

## Laravel中使用
在 Laravel 中使用也是同样的安装方式，配置写在 config/services.php 中：
```shell
'ocr' => [
    'key' => env('OCR_API_KEY'),
    'secret' => env('OCR_API_SECRET'),
],
```
然后在 .env 中配置 WEATHER_API_KEY ：
```shell
OCR_API_KEY=xxxxxxxxxxxxxxxxxxxxx
OCR_API_SECRET=xxxxxxxxxxxxxxxxxxxxx
```

可以用两种方式来获取 Expnull\Ocr\Ocr 实例：
```shell
public function index(Ocr $ocr)
{
    $token = $ocr->getToken(); // 其他类似
}
```
服务名访问
```shell
public function index()
{
    $token = app('ocr')->getToken();
    app('ocr')->setImageUrl('图片url');
    $img = app('ocr')->getImgWords($token['access_token']);
}
```

## 参考
[百度开发平台开发文档](http://ai.baidu.com/docs#/OCR-API/top)

## License

MIT