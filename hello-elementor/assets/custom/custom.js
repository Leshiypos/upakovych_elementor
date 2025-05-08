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
});
