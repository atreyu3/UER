<?php

/*
 * 2015-03-10
 * @author Mika Ståhlberg <mika.stahlberg@interaktiva.fi>
 * https://github.com/mist-webit/yii2-bootstrap-material-design
 */

namespace mistwebit\materialbootstrap;

use yii\web\AssetBundle;

class MaterialLoaderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/mist-webit/yii2-bootstrap-material-design/assets';
    public $js = [
        'js/loader.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $depends = [
        'mistwebit\materialbootstrap\MaterialAsset',
    ];

    public function init()
    {
        parent::init();
    }

}
