<?php
/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\User $user
 */

use webvimark\modules\UserManagement\models\UserProduct;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

BootstrapPluginAsset::register($this);
$this->title = 'Produkty użytkownika ' . $user->username;

$this->params['breadcrumbs'][] = ['label' => UserManagementModule::t('back', 'Users'), 'url' => ['/user-management/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2 class="lte-hide-title"><?= $this->title ?></h2>

<?php if ( Yii::$app->session->hasFlash('success') ): ?>
	<div class="alert alert-success text-center">
		<?= Yii::$app->session->getFlash('success') ?>
	</div>
<?php endif; ?>

<div class="user-product-form">
		<?= Html::beginForm(['set-products', 'id'=>$user->id]) ?>
		<?= Html::checkboxList(
			'products',
			UserProduct::getProductsByUser($user->id),
			UserProduct::getProductList(),
			[
				'separator'=>'<br>',
			]
		) ?>
		<br/>

		<?= Html::submitButton(
			'<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
			['class'=>'btn btn-primary btn-sm']
		) ?>
		<?= Html::endForm() ?>

</div>