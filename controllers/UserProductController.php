<?php

namespace webvimark\modules\UserManagement\controllers;

use webvimark\components\BaseController;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\UserProduct;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\web\NotFoundHttpException;
use Yii;

class UserProductController extends BaseController
{

	/**
	 * @param int $id User ID
	 *
	 * @throws \yii\web\NotFoundHttpException
	 * @return string
	 */
	public function actionSet($id)
	{
		$user = User::findOne($id);

		if ( !$user )
		{
			throw new NotFoundHttpException('User not found');
		}

		return $this->renderIsAjax('set', compact('user'));
	}
	
	/**
	 * @param int $id - User ID
	 *
	 * @return \yii\web\Response
	 */
	public function actionSetProducts($id)
	{
		$oldAssignments = UserProduct::getProductsByUser($id);
		$newAssignments = Yii::$app->request->post('products', []);

		$toAssign = array_diff($newAssignments, $oldAssignments);
		$toRevoke = array_diff($oldAssignments, $newAssignments);

		foreach ($toRevoke as $product)
		{
			$userProduct = UserProduct::find()
			    ->where(['user_id' => $id, 'product_id' => $product])
			    ->one();
			
			$userProduct->delete();
		}

		foreach ($toAssign as $product)
		{
			$userProduct = new UserProduct;
			$userProduct->user_id = $id;
			$userProduct->product_id = $product;
			$userProduct->save();
		}

		Yii::$app->session->setFlash('success', UserManagementModule::t('back', 'Saved'));

		return $this->redirect(['set', 'id'=>$id]);
	}
}
