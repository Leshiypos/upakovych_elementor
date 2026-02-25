window.addEventListener("load", () => {
  // Если тег найден, удаляем его
  function deleteMetaTag() {
    let metaTag = document.querySelectorAll('meta[name="description"]');

    if (metaTag[1]) {
      metaTag[1].remove();
    } else {
      //   console.log("Метотег не найден");
    }
  }
  deleteMetaTag();

  //   Filling empty ALT attributes with text from H1 headings

  function setAtributsImg() {
    let contentH1 = document.querySelector("h1").textContent;
    let imgesTag = document.querySelectorAll("img");
    imgesTag.forEach((img) => {
      if (!img.hasAttribute("alt") || img.getAttribute("alt") === "") {
        img.setAttribute("alt", contentH1);
      }
    });
  }

  setTimeout(setAtributsImg, 1000);

  //   Маска для формы

  function formatPhone(e) {
    const input = e.target;
    let value = input.value.replace(/\D/g, "").slice(0, 11);

    if (value.startsWith("8")) value = "7" + value.slice(1);

    let result = "+7 (";
    if (value.length > 1) result += value.slice(1, 4);
    if (value.length >= 4) result += ") " + value.slice(4, 7);
    if (value.length >= 7) result += "-" + value.slice(7, 9);
    if (value.length >= 9) result += "-" + value.slice(9, 11);

    input.value = result;
  }

  function handleBackspace(e) {
    const input = e.target;

    // Разрешить удаление при Backspace
    if (e.key === "Backspace") {
      let value = input.value.replace(/\D/g, "");
      value = value.slice(0, -1); // удалить последний символ
      e.preventDefault();

      // Перезапустить форматирование без последнего символа
      let fakeEvent = new Event("input", { bubbles: true });
      input.value = value;
      input.dispatchEvent(fakeEvent);
    }
  }

  setTimeout(() => {
    const phoneInputs = document.querySelectorAll("input[type='tel']");

    phoneInputs.forEach(function (input) {
      input.addEventListener("input", formatPhone);
      input.addEventListener("keydown", handleBackspace);
    });
  }, 1000);

  //   7form
  function initPhoneHandlers() {
    const phoneInputs = document.querySelectorAll(".wpcf7-tel");
    phoneInputs.forEach((input) => {
      input.removeEventListener("input", formatPhone); // во избежание дубликатов
      input.removeEventListener("keydown", handleBackspace);
      input.addEventListener("input", formatPhone);
      input.addEventListener("keydown", handleBackspace);
    });
  }

  // 1. При загрузке страницы
  document.addEventListener("DOMContentLoaded", initPhoneHandlers);

  // 2. Следим за появлением элементов
  const observer = new MutationObserver((mutations) => {
    for (let mutation of mutations) {
      if (mutation.addedNodes.length && document.querySelector(".wpcf7-tel")) {
        initPhoneHandlers();
        break;
      }
    }
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true,
  });
  //   7form конец

  // Инициализация swiper
  if (document.querySelector(".related-products-swiper")) {
    new Swiper(".related-products-swiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      autoplay: {
        delay: 3000,
      },
      loop: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 4,
        },
      },
    });
  }
  if (document.querySelector(".cross-sells-slider")) {
    new Swiper(".cross-sells-slider", {
      slidesPerView: 1,
      spaceBetween: 20,
      autoplay: {
        delay: 3000,
      },
      loop: false,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 4,
        },
      },
    });
  }

  //   Кнопка главного мобильного меню
  let burger_but = document.querySelector("#burger_button img");
  let menu_active = document.querySelector(".header_mobile .mobile_menu_list");
  let menu_cat_active = document.querySelector(".wrap_menu_catalog");
  let burger_cat_but = document.querySelector("#burger_catalog_button img");

  //   menu_active.classList.add("not_active");
  burger_but.addEventListener("click", () => {
    let icons_header = document.querySelector(".always_display_mobile_icons");
    menu_active.classList.toggle("not_active");
    burger_cat_but.src =
      "/wp-content/themes/hello-elementor/assets/images/menu-burger-white.svg ";
    menu_cat_active.classList.remove("active");
    if (menu_active.classList.contains("not_active")) {
      burger_but.src =
        "/wp-content/themes/hello-elementor/assets/images/menu-burger-white.svg";
      icons_header.style.opacity = 1;
    } else {
      burger_but.src =
        "/wp-content/themes/hello-elementor/assets/images/cross-white.svg";
      icons_header.style.opacity = 0;
    }
  });
  //   КОНЕЦ Кнопка главного мобильного меню

  //   Кнопка каталога мобильного меню
  if (burger_cat_but) {
    burger_cat_but.addEventListener("click", () => {
      menu_active.classList.add("not_active");
      menu_cat_active.classList.toggle("active");
      burger_but.src =
        "/wp-content/themes/hello-elementor/assets/images/menu-burger-white.svg";
      if (menu_cat_active.classList.contains("active")) {
        burger_cat_but.src =
          "/wp-content/themes/hello-elementor/assets/images/cross-white.svg";
      } else {
        burger_cat_but.src =
          "/wp-content/themes/hello-elementor/assets/images/menu-burger-white.svg ";
      }
    });
    let burger_cat_but_cross = document.querySelector(
      "#burger_catalog_button_cross",
    );
    burger_cat_but_cross.addEventListener("click", () => {
      menu_cat_active.classList.remove("active");
      burger_cat_but.src =
        "/wp-content/themes/hello-elementor/assets/images/menu-burger-white.svg ";
    });

    //   выпадающие списки
    let itemsMenuCatalog = document.querySelectorAll("#list_menu_catalog>li>a");

    itemsMenuCatalog.forEach((item) => {
      if (!item.nextElementSibling) {
        item.classList.add("no-icon");
      }
    });
    itemsMenuCatalog.forEach((item) => {
      item.addEventListener("click", (e) => {
        if (e.target.nextElementSibling) {
          e.preventDefault();
        }
        const li = e.target.closest("li");
        const isOpen = li.classList.contains("open");
        // Закрыть все пункты
        itemsMenuCatalog.forEach((item) => {
          item.closest("li").classList.remove("open");
        });
        // Если был закрыт — открыть, если был открыт — не открывать заново
        if (!isOpen) {
          li.classList.add("open");
        }
      });
    });

    //   Восота меню
    function setHeightWrapCatlogMenu() {
      let wrapMenuCatalogList = document.getElementById("list_menu_catalog");
      let cordTopMenuCatalogList =
        wrapMenuCatalogList.getBoundingClientRect().top;
      let heightWindow = window.innerHeight;
      let heightMenuCatalogList = heightWindow - cordTopMenuCatalogList;
      wrapMenuCatalogList.style.height = `${heightMenuCatalogList}px`;
    }
    setHeightWrapCatlogMenu();
    //   КОНЕЦ каталога главного мобильного меню
  }

  //   Кнопка фильтров каталога
  let filters_but = document.querySelector(".header_filters");
  let filters = document.querySelector(".filter_catalog_wrap .filters");
  if (filters) {
    filters_but.addEventListener("click", () => {
      console.log("клик");
      filters.classList.toggle("not_active");
      filters_but.classList.toggle("not_active");
    });
  }
  //   КОНЕЦ фильтров каталога
});
document.addEventListener("DOMContentLoaded", () => {
  const toggleButtons = document.querySelectorAll(".toggle-section");
  toggleButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      let target = e.currentTarget;
      console.log(target.classList.contains("collapsed"));
      const section = button.closest(".checkout-section");
      section.classList.toggle("collapsed");
    });
  });

  const floorToggle = document.getElementById("floor_delivery");
  const floorInput = document.getElementById("floor_input_wrap");

  floorToggle?.addEventListener("change", () => {
    floorInput.style.display = floorToggle.checked ? "block" : "none";
  });

  //   Делаем высоту карточки на странице категории одинаковой
  function maxHeight(select) {
    let height = 0;
    let elemcart = document.querySelectorAll(select);
    if (elemcart) {
      for (let elem of elemcart) {
        if (!elem.classList.contains("product-category")) {
          if (elem.offsetHeight > height) height = elem.offsetHeight;
        }
      }
      for (let elem of elemcart) {
        if (!elem.classList.contains("product-category")) {
          if (elem.offsetHeight != height) elem.style.height = height + "px";
          console.log("Высота изменена");
        }
      }
    }
  }
  //   maxHeight(".archive.tax-product_cat ul.products>li");
  maxHeight("ul.products>li");

  //   Устанавливаем чекбокс формы заказа Политики конфенденциальности по умолчанию в чекед
  (function () {
    const CHECKBOX_ID = "mailpoet_woocommerce_checkout_optin";

    function setMailpoetOptinChecked() {
      const checkbox = document.getElementById(CHECKBOX_ID);
      if (!checkbox) return;

      checkbox.checked = true;
      // чтобы плагины отреагировали
      checkbox.dispatchEvent(new Event("change", { bubbles: true }));
    }

    // 1. Ставим галку при первой загрузке
    setMailpoetOptinChecked();

    // 2. После каждого AJAX-обновления WooCommerce ставим её снова
    if (window.jQuery) {
      jQuery(function ($) {
        $("body").on("updated_checkout", setMailpoetOptinChecked);
      });
    } else {
      // На всякий случай — если вдруг без jQuery
      document.body.addEventListener(
        "updated_checkout",
        setMailpoetOptinChecked,
      );
    }
  })();

  //Секция Вопросы
  hiddenLiQuestionsSection();
});

// MARK: Кнопка срыть пункты секции Вопросы
function hiddenLiQuestionsSection() {
  const LIMIT = 10;

  // контейнер аккордеона
  const acc = document.querySelector(".e-n-accordion");
  if (!acc) return;

  const items = Array.from(acc.querySelectorAll("details.e-n-accordion-item"));
  if (items.length <= LIMIT) return;

  // скрываем всё после 10
  const hidden = items.slice(LIMIT);
  hidden.forEach((el) => {
    el.style.display = "none";
    el.dataset.faqHidden = "1";
  });

  // кнопка
  const btn = document.createElement("button");
  btn.type = "button";
  btn.className = "btn cta_primary questions";
  btn.textContent = "Показать все";
  btn.style.marginTop = "16px";

  // вставим кнопку после аккордеона
  acc.parentNode.appendChild(btn);

  btn.addEventListener("click", () => {
    const isExpanded = btn.dataset.expanded === "1";

    if (!isExpanded) {
      // показать скрытые
      hidden.forEach((el) => (el.style.display = ""));
      btn.textContent = "Скрыть";
      btn.dataset.expanded = "1";
    } else {
      // снова скрыть
      hidden.forEach((el) => (el.style.display = "none"));
      btn.textContent = "Показать все";
      btn.dataset.expanded = "0";

      // прокрутка к началу списка (по желанию)
      acc.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  });
}
