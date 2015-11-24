<?php
namespace webvimark\modules\UserManagement\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\buchalter\models\Product;

/**
 * This is the model class for table "user_product".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 */
class UserProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['user_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Użytkownik',
            'product_id' => 'Produkt',
        ];
    }
    
    /**
     * getProductList
     * @return array
     */
    public static function getProductList()
    {
    	return ArrayHelper::map(Product::find()->orderBy('name ASC')->all(), 'id', 'name');
    }
    
    /**
     * getProductsByUser
     * @return array
     */
    public static function getProductsByUser($user_id)
    {
    	return ArrayHelper::map(UserProduct::find()->where(['user_product.user_id' => $user_id])->all(), 'id', 'product_id');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
