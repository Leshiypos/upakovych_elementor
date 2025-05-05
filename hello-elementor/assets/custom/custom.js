window.addEventListener("load", () => {
  // Если тег найден, удаляем его
  function deleteMetaTag() {
    let metaTag = document.querySelectorAll('meta[name="description"]');

    metaTag.forEach((elem) => {
      let contentText = elem.getAttribute("content");
      elem.setAttribute("content", contentText.slice(0, 100));
    });

    if (metaTag[1]) {
      metaTag[1].remove();
    } else {
      console.log("Метотег не найден");
    }
  }
  deleteMetaTag();
});
