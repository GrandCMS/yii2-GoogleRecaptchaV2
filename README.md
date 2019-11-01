# Simple Yii2 Google Recaptcha V2 widget and component

You can use it in simple or Pjax ActiveForm

### Load component
```
'components' => [
        'captcha' => [
            'class' => 'app\components\GoogleRecaptchaV2',
            'siteKey' => 'Your site key',
            'secretKey' => 'Your secret key',
        ],
],
```

### Use in model:
```
public $captcha;
/**
 * @return array the validation rules.
 */
public function rules()
{
    return [
        ['captcha', 'required', 'message' => 'Please complete the Captcha test!'],
        ['captcha', 'validateCaptcha'],
    ];
}

public function validateCaptcha($attribute)
{
    if (!Yii::$app->captcha->isResponseValid($this->captcha)) {
        $this->addError($attribute, 'Captcha test failed!');
    }
}
```
### Use in view
```
<?= 
$form->field($model, 'captcha')->widget(
  'app\widgets\GoogleRecaptchaV2', 
  [
    'siteKey' => Yii::$app->captcha->siteKey
  ]
) 
  ?>
```
### Options
```
<?= 
$form->field($model, 'captcha')->widget(
  'app\widgets\GoogleRecaptchaV2', 
  [
    'siteKey' => 'Your site key',
    'language' => 'Forced language code',
    'theme' => 'light or dark',
    'size' => 'normal or compact',
  ]
) 
  ?>
```
