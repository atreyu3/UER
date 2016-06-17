<?php

/*
 * 2015-03-10
 * @author Mika Ståhlberg <mika.stahlberg@interaktiva.fi>
 * https://github.com/mist-webit/yii2-bootstrap-material-design
 */

namespace mistwebit\materialbootstrap;

use yii\web\AssetBundle;

class MaterialAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-material-design/dist';
    public $css = [
        'css/bootstrap-material-design.min.css',
        'css/ripples.min.css',
    ];
    public $js = [
        'js/ripples.min.js',
        'js/material.min.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        parent::init();
    }

}
