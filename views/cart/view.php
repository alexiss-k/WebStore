<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = "Shopping cart | WebStore";
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
        <h2>Shopping Cart</h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                <form action="<?=Url::to('/cart/set-info')?>" method="post" id="refresh-cart-form">
                <?php $form = ActiveForm::begin(); ?>
                <?php 
                $total_price = 0;
                foreach($products as $product) {?>
                    <tr>
                        <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="<?=Url::to(['product/view','id'=>$product->id])?>"> <img class="media-object" src="/<?=$product->photo?>" style="width: 72px; height: 72px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="<?=Url::to(['product/view','id'=>$product->id])?>"><?=$product->name?></a></h4>
                                <h5 class="media-heading">
                                <?php 
                                    $arr = explode( ' ', $product->description );
                                    $arr = array_slice( $arr, 0, 18 );
                                    echo implode( ' ', $arr ).'...';
                                    ?>
                                </h5>
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        <input name="Cart[<?=$product->id?>]" type="number" min="0" max="10" class="form-control" id="productQuantity<?=$product->id?>" value="<?=$cart[$product->id]?>">
                        </td>
                        <td class="col-sm-1 col-md-2 text-center"><strong><?=$product->price?> ₴</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong><?=$product->price*$cart[$product->id]?> ₴</strong></td>
                        <td class="col-sm-1 col-md-2 text-right">
                        <button type="button" class="btn btn-danger remove-button" data-product-id="<?=$product->id?>">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </button></td>
                    </tr>
                <?php
                $total_price += $product->price*$cart[$product->id];
                 } ?>
                 <input type="hidden" name="shipping" value="<?=\Yii::$app->session->getFlash('shipping_method')?>" id="hidden-shipping"/>
                 <?php ActiveForm::end(); ?>
                 </form>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal</h5></td>
                        <td class="text-right"><h5><strong id="subtotal_price" data-value="<?=$total_price?>"><?=$total_price?> ₴</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td class="text-left"><h5>Estimated shipping</h5></td>
                        <td><select class="form-control" id="shipping-method">
                            <option value=''>Select method... </option>
                        <?php 
                        $shipping_method = \Yii::$app->session->getFlash('shipping_method');
                        foreach($shippings as $shipping) {?>
                             <?php 
                                
                                $info = '';
                                if ($shipping_method != null && $shipping->systemName == $shipping_method) {
                                $info = 'selected'; }
                                else $info = '';?>
                            <option value="<?=$shipping->systemName?>" <?=$info?>>
                            <?php echo $shipping->name?></option>
                        <?php }?>
                        </select></td>
                        <td class="text-right"><h5><strong id="shipping_price">0 ₴</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong id="total_price"><?=$total_price?> ₴</strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td class="text-right">
                        <button id="refresh-cart" type="button" class="btn btn-info">
                            <span class="glyphicon glyphicon-refresh"></span> Refresh
                        </button>
                        </td>
                        <td>
                        <a href="<?=\Yii::$app->user->getReturnUrl();?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </button>
                        </td>
                        <td>
                        <button id="checkout-button" type="button" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body text-center">
      <br><img src="/files/you-sure.jpg" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Nah</button>
        <button type="button" class="btn btn-primary">Yeah!</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="shippingModal" tabindex="-1" role="dialog" aria-labelledby="shippingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    <div class="modal-header text-center">
      <h4>First choose shipping method!</h4>
      </div>
      <div class="modal-body text-center">
      <br><img src="/files/no-way.jpg" width="100%"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
      </div>
    </div>
  </div>
</div>