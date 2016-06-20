<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Alert;
use mistwebit\materialbootstrap;

AppAsset::register($this);
materialbootstrap\MaterialLoaderAsset::register($this);

$menuItems2 = [
        ['label' => 'Inicio', 'url' => ['/site/index']],
        ['label' => 'Usuarios', 'template'=>'<a href="{url}" >{label}</a>', 
        	'items' => [
		 	 	['label' => 'Consulta Usuario', 'url' => ['user/index']],
		 		['label' => 'Categoria Usuario', 'url' => ['categoriauser/index']],
		 		['label' => 'Tramo de control por jefe de mecánico', 'url' => ['grupo/index']],
		  ]
		],
        ['label' => 'item',
         'url' => ['/item'],
		 'template'=>'<a href="{url}" >{label}</a>',
		 'items' => [
		 	['label' => 'Consulta item', 'url' => ['item/index']],

		 ]        
        ],
        ['label' => 'Maquina',
         'template'=>'<a href="{url}" >{label}</a>',
		 'items' => [
		 	  ['label' => 'Consulta maquina ', 'url' => ['maquina/index']],	
			  ['label' => 'Maquina inactivas', 'url' => ['maquina/maquinainactivas']],
		 	  ['label' => 'Consulta de Lineas', 'url' => ['linea/index']], 
		 	  ['label' => 'Centro de costos', 'url' => ['centrodecostos/index']],
			  
		 ]        
        ],
        ['label' => 'Impresion',
         'template'=>'<a href="{url}" >{label}</a>',
		 'items' => [
		 	  ['label' => 'Impresora', 'url' => ['/archivo/impresora']],
		 	  ['label' => 'Imprimir', 'url' => ['/compras/impresionprovisional']],	
		 ]        
        ],
        ['label' => 'Reportes',
         'template'=>'<a href="{url}" >{label}</a>',
		 'items' => [
		 	  ['label' => 'Salidas', 'url' => ['/transaccionrefaccion/']],
		 	  ['label' => 'Devoluciones', 'url' => ['/devoluciones/']],	
		 	  ['label' => 'Maquina costos', 'url' => ['/transaccionrefaccion/reporte']],
		 ]        
        ],
    ];
	$menuItems[] = '<li><div class="custom_menu" data-effect="st-effect-9" ><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>Menu</div></li>';
	if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
		$menuItems2[]= ['label' => 'Login', 'url' => ['/site/login']];
    } else {
    	$menuItems2[]=[
            'label' => 'Logout (' . Yii::$app->user->identity->tbl_user_nombre.' '.Yii::$app->user->identity->tbl_user_apellidomaterno.' '.Yii::$app->user->identity->tbl_user_apellidopaterno . ')',
            'url' => ['/site/logout'], 
            'linkOptions' => ['data-method' => 'post']
        ];
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->tbl_user_nombre.' '.Yii::$app->user->identity->tbl_user_apellidomaterno.' '.Yii::$app->user->identity->tbl_user_apellidopaterno . ')',
            'url' => ['/site/logout'], 
            'linkOptions' => ['data-method' => 'post']
        ];
    }
	
    
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this -> title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap st-container " id="st-container">
    <?php
    NavBar::begin([
        'brandLabel' => '<div class="eventual" ><img   src= "'.Yii::$app->request->baseUrl.'/img/circulo_marino.png" class="img-responsive"></div>',
        'brandUrl' => Yii::$app->homeUrl,
        'renderInnerContainer'=>false,
        'options' => [
            'class' => 'navbar-inverse menubimbo',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
    
    NavBar::end();
    ?>
	
    	<aside class="st-menu st-effect-9" id="st-menu st-effect-9">
    		<?php
   			 echo Nav::widget([
        	'options' => ['class' => 'navbar-pills'],
        	'items' => $menuItems2,
    		]);
    		?>
    	</aside>
    		
   <div class="st-pusher"  >
   		<div class="st-content">
   	    <section class="site-index content-wrapper">
   	    	<div class="col-md-12 col-lg-12" >
   	    	<section class="conten-header">
        	<?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        	]) ?>
        	</section>
        		<?= $content ?>
        	</div>
        </section>
    </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
