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

<!-- вывод метода доставки -->
<?php $packages = WC()->shipping->get_packages();
foreach ( $packages as $i => $package ) {
    $chosen_method = WC()->session->get( "chosen_shipping_methods" )[ $i ];
    foreach ( $package['rates'] as $method_id => $rate ) {
        ?>
        <p class="delivery-method">
            <input type="radio"
                   name="shipping_method[<?php echo esc_attr( $i ); ?>]"
                   data-index="<?php echo esc_attr( $i ); ?>"
                   id="shipping_method_<?php echo esc_attr( $i ); ?>_<?php echo esc_attr( sanitize_title( $rate->id ) ); ?>"
                   value="<?php echo esc_attr( $rate->id ); ?>"
                   class="shipping_method"
                   <?php checked( $method_id, $chosen_method ); ?> />
            <strong><label for="shipping_method_<?php echo esc_attr( $i ); ?>_<?php echo esc_attr( sanitize_title( $rate->id ) ); ?>">
                <?php echo wc_cart_totals_shipping_method_label( $rate ); ?>
            </label></strong>
        </p>
        <?php
    }
} ?>

<!--конец  вывод метода доставки -->
      </div>
      <div class="address-fields">
        <?php do_action('woocommerce_checkout_shipping'); ?>
		<p class="note_for_order">*укажите адрес доставки</p>
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