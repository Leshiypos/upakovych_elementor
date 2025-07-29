window.addEventListener("load", () => {
  //Кнопка корзины

  function sendRichGoal(selector, target, event) {
    let buttonAddToCard = document.querySelectorAll(selector);
    if (buttonAddToCard) {
      buttonAddToCard.forEach((el) => {
        el.addEventListener(event, (e) => {
          ym(100712159, "reachGoal", target);
          console.log("reachGoal сработал");
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

  //   кнопка подтвердить заказ
  setTimeout(
    () => sendRichGoal(".woocommerce-checkout #place_order", "buy", "click"),
    500
  );

  // Событие нажатия на кнопку отправки формы
  sendRichGoal("#metform-wrap-4942b43-314 .metform-btn", "send_form", "click");
  sendRichGoal("#metform-wrap-291ed67b-314 .metform-btn", "send_form", "click");

  //   отправка формы - заказать звонок
  function catchMetformSuccess(selector, target) {
    const responseWrap = document.querySelector(selector);
    if (!responseWrap) {
      // Если форма еще не появилась — повторяем попытку через 200мс
      setTimeout(catchMetformSuccess, 200);
      return;
    }
    const observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        // Признак успешной отправки: появление класса .mf-success-icon с ненулевой видимостью
        if (responseWrap.querySelector(".mf-success-icon")) {
          // Сработает ОДИН раз
          observer.disconnect();
          ym(100712159, "reachGoal", target);
          console.log(`Событие отправки формы сработало ${target}`);
          // Твои действия, например:
          if (typeof PUM !== "undefined") {
            PUM.close(6653);
          } else {
            document.querySelector("#pum-6653 .pum-close")?.click();
          }
        }
      });
    });
    observer.observe(responseWrap, { childList: true, subtree: true });
  }
  catchMetformSuccess(
    "#metform-wrap-6644-6644 .mf-main-response-wrap",
    "call_order"
  );

  //   Отправка формы "Купить в один клик" - тк форма генерируется динамически
  document.addEventListener(
    "wpcf7mailsent",
    function (event) {
      // event.detail.contactFormId — ID формы, можно проверить, что нужная форма
      // event.target — сам DOM-элемент .wpcf7, в который вложена форма
      // Например, чтобы реагировать только на конкретную форму:
      if (event.detail.contactFormId == "6756") {
        ym(100712159, "reachGoal", "kupit_1_klick");
      }
      if (event.detail.contactFormId == "8516") {
        ym(100712159, "reachGoal", "popup_send");
        // закрываем форму после отправки
        setTimeout(() => {
          document.querySelector("#popmake-8507 .popmake-close").click();
        }, 5000);
      }
      if (event.detail.contactFormId == "8671") {
        ym(100712159, "reachGoal", "need_cheaper");
      }
      if (event.detail.contactFormId == "8676") {
        ym(100712159, "reachGoal", "opt");
      }
    },
    false
  );

  //   Отправка форм обратной связи на главной
  function observeMetformSuccess(formWrapperId, onSuccess) {
    function waitAndObserve() {
      const responseWrap = document.querySelector(
        `#${formWrapperId} .mf-main-response-wrap`
      );
      if (!responseWrap) {
        setTimeout(waitAndObserve, 200); // Ждём появления формы, если она появляется динамически
        return;
      }
      const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
          if (responseWrap.querySelector(".mf-success-icon")) {
            observer.disconnect();
            if (typeof onSuccess === "function") onSuccess();
          }
        });
      });
      observer.observe(responseWrap, { childList: true, subtree: true });
    }
    waitAndObserve();
  }
  // главная
  observeMetformSuccess("metform-wrap-4942b43-314", () => {
    ym(100712159, "reachGoal", "zayavka_sent");
  });
  //   Страница каталога
  observeMetformSuccess("metform-wrap-291ed67b-314", () => {
    ym(100712159, "reachGoal", "zayavka_sent");
  });

  //   Отправка PopUp Хочу дешевле
});
