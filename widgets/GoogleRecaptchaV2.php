<?php
/**
 * @author GrandCMS https://www.grandcms.com/
 */
namespace app\widgets;

use yii\helpers\Html;

class GoogleRecaptchaV2 extends \yii\widgets\InputWidget
{
    public const THEME_LIGHT = 'light';
    public const THEME_DARK = 'dark';
    public const SIZE_NORMAL = 'normal';
    public const SIZE_COMPACT = 'compact';

    public $siteKey;
    public $language;
    public $theme;
    public $size;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
       parent::run();

       $this->view->registerJsFile(
           'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit' . ($this->language ? '&hl='.$this->language : ''), 
            ['position' => $this->view::POS_END, 'async' => true, 'defer' => true]
        );
       
       $this->view->registerJs(
            '
            function onloadCallback() {
                grecaptcha.render("'.Html::getInputId($this->model, $this->attribute).'-captchaV2", {
                    "sitekey" : "'.$this->siteKey.'",
                    "callback" : verifyCallback,
                    "theme" : "'.$this->theme.'",
                    "size" : "'.$this->size.'"
                });
            };

            function verifyCallback(response) {
                $("#'.Html::getInputId($this->model, $this->attribute).'").val(response);
            };
            ',
            $this->view::POS_END
        );

        if (\Yii::$app->request->isAjax) {
            $this->view->registerJs(
                '
                if (typeof grecaptcha !== "undefined") {
                    onloadCallback();
                }
                ', 
                $this->view::POS_END
            );
        }

       $html = '<div id="'.Html::getInputId($this->model, $this->attribute).'-captchaV2"></div>';

       $html .= $this->renderInputHtml('hidden');

       return $html;
    }
}
