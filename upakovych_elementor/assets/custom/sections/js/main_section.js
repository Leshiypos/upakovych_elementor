document.addEventListener("DOMContentLoaded", () => {
  // добавляем слайдер на cекцию hero section
  let hero_section = document.querySelector(".hero_section_slider");
  if (hero_section) {
    new Swiper(hero_section, {
      effect: "fade",
      slidesPerView: 1,
      speed: 400,
      spaceBetween: 100,
      autoplay: {
        delay: 5000,
      },
    });
  }

  //   Слайдер наши клиенты
  let our_clients_clider = document.querySelectorAll(".our_clients_slider");

  if (our_clients_clider.length) {
    our_clients_clider.forEach((slider) => {
      let btn_prev = slider
        .closest("section")
        .querySelector(".our_client_prev");
      let btn_next = slider
        .closest("section")
        .querySelector(".our_client_next");

      new Swiper(slider, {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        speed: 400,
        autoplay: {
          delay: 5000,
        },
        navigation: {
          nextEl: btn_next,
          prevEl: btn_prev,
        },
      });
    });
  }

  //   Слайдер наши клиенты
  let logo_slider = document.querySelectorAll(".logo_slider");

  if (logo_slider.length) {
    logo_slider.forEach((slider) => {
      let btn_prev = slider.closest("section").querySelector(".logo_btn_prev");
      let btn_next = slider.closest("section").querySelector(".logo_btn_next");

      new Swiper(slider, {
        slidesPerView: 1,
        spaceBetween: 10, // отступ между слайдами
        // centeredSlides: true,
        loop: true,
        speed: 400,
        // autoplay: {
        //   delay: 5000,
        // },
        navigation: {
          nextEl: btn_next,
          prevEl: btn_prev,
        },
        breakpoints: {
          1200: {
            slidesPerView: 6,
          },
          1000: {
            slidesPerView: 4,
          },
          600: {
            slidesPerView: 3,
          },
          420: {
            slidesPerView: 2,
          },
        },
      });
    });
  }
});
