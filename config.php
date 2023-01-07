<?php
/**
 * @author: Harry Tang (giaduy@gmail.com)
 * @link: http://www.greyneuron.com
 * @copyright: Grey Neuron
 */

return [

    'params' => [
        'ipb'=>[
            'integration'=>false, // integrate with IPB (use IPB users to login)
            'url'=>'http://forum.cuasotinhoc.vn', // IPB forum url
            'tokenValidationKey'=>'csth2013'
        ],

        'loginDuration' => 2592000,
        'enableCaptcha' => true,
        'minPasswordLength' => 6,
        'rememberMeExpire'=>3600 * 24 * 30,
        'tokenExpire'=>3600,

        'facebookLogin'=>true,
        'googleLogin'=>true,
        'yahooLogin'=>true,
    ]
];