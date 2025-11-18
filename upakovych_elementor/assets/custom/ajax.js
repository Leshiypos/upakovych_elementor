document.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const target = e.target;
    const btnLoadMore = target.closest("#load_more");
    if (!btnLoadMore) return;
    e.preventDefault();
    btnLoadMore.classList.add("loading");

    let container = document.getElementById("article_wrap");
    if (!container) return;

    const paged = btnLoadMore.dataset.paged;
    const maxPages = btnLoadMore.dataset.max_pages;

    const formData = new FormData();
    formData.append("action", "load_more_articles"); // имя хука
    formData.append("paged", paged);
    formData.append("max_pages", maxPages);

    fetch(my_ajax_object.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.success) {
          container.insertAdjacentHTML("beforeend", response.data.html);

          btnLoadMore.classList.remove("loading");
          // обновляем paged
          btnLoadMore.dataset.paged = Number(paged) + 1;

          // скрываем кнопку
          if (Number(paged) + 1 >= Number(maxPages)) {
            btnLoadMore.remove();
          }
        } else {
          console.log("Ошибка ответа:", response);
          throw new Error("ошибка ответа");
        }
      })
      .catch((err) => console.log("Ошибка fetch:", err));
  });
});
