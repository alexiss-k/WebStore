<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menu = [];
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Products',
                        'items' => [
                            ['label' => 'Product list', 'url' => ['/admin/product/index'],],
                            ['label' => 'Characteristic Values', 'url' => ['/admin/characteristic-value/index']],
                            ['label' => 'Price History', 'url' => ['/admin/price-history/index']],
                        ],
                    ],
                    ['label' => 'Product Settings',
                        'items' => [
                            ['label' => 'Characteristics', 'url' => ['/admin/characteristic/index']],        
                            ['label' => 'Categories', 'url' => ['/admin/category/index']],
                        ],
                    ],
                    ['label' => 'Shop Settings',
                        'items' => [
                            ['label' => 'Payment methods', 'url' => ['/admin/payment/index']],
                            ['label' => 'Shipping methdos', 'url' => ['/admin/shipping/index']],
                        ],
                    ],
                    ['label' => 'Comment', 'url' => ['/admin/comment/index']],
                    ['label' => 'Order', 'url' => ['/admin/order/index']],
                    ['label' => 'User', 'url' => ['/admin/user/index']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
