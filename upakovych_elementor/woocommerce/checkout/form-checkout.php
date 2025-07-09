<?php
if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// Если пользователь должен войти в систему перед оформлением заказа
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', 'Вы должны войти в систему, чтобы оформить заказ.'));
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout wrap_form_content" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
  <div class="col_left">
  <!-- Шаг 1: Контактные данные -->
  <div class="checkout-section section-contact">
    <div class="section-header">
      <h3>1. Ваши контактные данные</h3>
      <a href="#" class="toggle-section"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/angle-small-down.svg" alt=""></a>
    </div>
    <div class="section-content">
      <?php do_action('woocommerce_checkout_billing'); ?>
    </div>
  </div>

  <!-- Шаг 2: Доставка -->
  <div class="checkout-section section-delivery collapsed">
    <div class="section-header">
      <h3>2. Доставка</h3>
      <a href="#" class="toggle-section"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/angle-small-down.svg" alt=""> </a>
    </div>
    <div class="section-content">
      <div class="delivery-methods">
        <label class="delivery-method">
          <input type="radio" name="delivery_option" value="courier" checked>
          <strong>Доставка курьером</strong>
        </label>
        <label class="delivery-method">
          <input type="radio" name="delivery_option" value="pickup">
          <strong>Самовывоз</strong>
        </label>
      </div>
      <div class="address-fields">
        <?php do_action('woocommerce_checkout_shipping'); ?>
      </div>
      <div class="delivery-zones">
        <p>Зоны доставки (интерактивная карта или пояснение)</p>
		<?php 
		 ?>
      </div>
    </div>
  </div>
</div>
  <!-- Подтверждение заказа -->
  <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

  

  <?php do_action('woocommerce_checkout_before_order_review'); ?>

  <div id="order_review" class="woocommerce-checkout-review-order col_right">
    <?php do_action('woocommerce_checkout_order_review'); ?>
  </div>

  <?php do_action('woocommerce_checkout_after_order_review'); ?>
</form>
 
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>