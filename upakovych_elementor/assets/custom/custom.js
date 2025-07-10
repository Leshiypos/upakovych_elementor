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
  //   Кнопка главного мобильного меню
  let burger_but = document.querySelector("#burger_button img");
  let menu_active = document.querySelector(".header_mobile .mobile_menu_list");
  burger_but.addEventListener("click", () => {
    menu_active.classList.toggle("not_active");
    if (menu_active.classList.contains("not_active")) {
      burger_but.src =
        "/wp-content/themes/hello-elementor/assets/images/menu-burger-white.svg";
    } else {
      burger_but.src =
        "/wp-content/themes/hello-elementor/assets/images/cross-white.svg";
    }
  });
  //   КОНЕЦ Кнопка главного мобильного меню

  //   Кнопка главного мобильного меню
  let burger_cat_but = document.querySelector("#burger_catalog_button img");
  let menu_cat_active = document.querySelector("#list_menu_catalog");
  burger_cat_but.addEventListener("click", () => {
    menu_cat_active.classList.toggle("not_active");
    if (menu_cat_active.classList.contains("not_active")) {
      burger_cat_but.src =
        "/wp-content/themes/hello-elementor/assets/images/menu-burger.svg";
    } else {
      burger_cat_but.src =
        "/wp-content/themes/hello-elementor/assets/images/cross.svg";
    }
  });
  //   КОНЕЦ Кнопка главного мобильного меню
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
});
