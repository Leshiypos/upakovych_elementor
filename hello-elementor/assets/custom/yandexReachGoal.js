window.addEventListener("load", () => {
  //Кнопка корзины

  function sendRichGoal(selector, target, event) {
    let buttonAddToCard = document.querySelectorAll(selector);
    if (buttonAddToCard) {
      buttonAddToCard.forEach((el) => {
        el.addEventListener(event, (e) => {
          ym(100712159, "reachGoal", target);
        });
      });
    }
  }
  //Кнопка корзины
  sendRichGoal(".add_to_cart_button", "add_to_cart", "click");
  //   Кнопка оформления заказа
  sendRichGoal(".checkout-button", "oformit_zakaz", "click");
  //   Кнопка размещение заказа
  setTimeout(
    () =>
      sendRichGoal(
        ".wc-block-components-checkout-place-order-button",
        "buy",
        "click"
      ),
    500
  );
  // Событие отправки формы
  sendRichGoal("form.metform-form-content", "send_form", "submit");
});
