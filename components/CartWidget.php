<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\ProductModel;

class CartWidget extends Widget{
    
    public $value = 0;
    public $items = 0;
    public $message;
    
    public function init(){
        parent::init();
        
        //Get cart items and calculate total value
        //Cookie cart array type : ['product_id' => 'quantity', ...]
        $cart_info = \Yii::$app->request->cookies->getValue('cart');
        if ($cart_info !== null) {
            $products = unserialize($cart_info);
            if (is_array($products)) {
                $product_ids = array_keys($products);
                $product_models = ProductModel::getProducts($product_ids);//find()->where(['id'=>$product_ids])->all();
                foreach ($product_models as $product_model)
                {
                    $this->value += $product_model->price * $products[$product_model->id];
                    $this->items += $products[$product_model->id];
                    \Yii::info('Quantity of '.$product_model->id.' ('.$product_model->price.') - '.$products[$product_model->id]);
                }
            }
        }

        if ($this->value > 0)
            $this->message = "$('.cart').addClass('active'); $('.cart').append(\"<span class='cart-value'> ({$this->value} ₴ - {$this->items} items)</span>\");";
        else
            $this->message = "";
    }
    
    public function run(){
        return $this->message;
    }
}
?>
