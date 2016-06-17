<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TransaccionAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';

  	public $css = [
  	'css/transaccion.css'
  	];
    public $js = [
      'js/modernizr.custom.js',
      'js/draggabilly.pkgd.min.js',
      'js/dragdrop.js',
      'js/transaccion.js',
    ];
    public $depends = [
            'yii\web\YiiAsset',
        ];
}
