<?php
/**
 * @author GrandCMS https://www.grandcms.com/
 */
namespace app\components;

class GoogleRecaptchaV2 extends \yii\base\Component
{
    public $siteKey;
    public $secretKey;
    public $url = 'https://www.google.com/recaptcha/api/siteverify?secret=';

    public function isResponseValid(string $response): bool
    {

        $url = $this->url . urlencode($this->secretKey) .  '&response=' . urlencode($response);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        // should return JSON with success as true
        
        if($responseKeys["success"]) {
            return true;
        } 

        return false;
    }
}