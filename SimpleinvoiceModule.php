<?php

namespace harrytang\simpleinvoice;
use Yii;
use yii\base\Module;

class SimpleinvoiceModule extends Module
{
    public $controllerNamespace = 'harrytang\simpleinvoice\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
        // $this->params['foo'] = 'bar';
        // ...  other initialization code ...
        // initialize the module with the configuration loaded from config.php
        Yii::configure($this, require(__DIR__ . '/config.php'));
        $this->registerTranslations();
        $this->registerMailer();
    }

    /**
     * Config Mailer for the Module
     */
    public function registerMailer(){
        Yii::$app->mailer->setViewPath($this->basePath.'/mail');
        Yii::$app->mailer->htmlLayout='@common/mail/layouts/html';
    }

    /**
     * Register translation for the Module
     */
    public function registerTranslations()
    {

        Yii::$app->i18n->translations['simpleinvoice'] = [
            'class' => 'harrytang\i18n\MyPhpMessageSource',
            'basePath'=>$this->basePath.DIRECTORY_SEPARATOR.'messages',
            'on missingTranslation' => function ($event) {
                $event->sender->insertMissingTranslation($event);
            },
        ];
    }

    /**
     * Translate message
     * @param $message
     * @param array $params
     * @param null $language
     * @return mixed
     */
    public static function t($message, $params = [], $language = null)
    {
        return Yii::$app->getModule('simpleinvoice')->translate($message, $params , $language );
    }

    /**
     * Translate message
     * @param $message
     * @param array $params
     * @param null $language
     * @return mixed
     */
    public static function translate($message, $params = [], $language = null){
        return Yii::t('simpleinvoice', $message, $params, $language);
    }
}
