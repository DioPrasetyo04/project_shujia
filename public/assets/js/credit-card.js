const dataExpand = document.querySelectorAll("[data-expand]");
const dataOpen = document.querySelectorAll("[data-open]");

window.addEventListener("DOMContentLoaded", function () {
  // dibuat foreach karena data expand ada 2 melebihi satu sehingga harus dibuat forEach agar bisa digunakan dalam jumlah banyak yang lebih dari satu
  dataExpand.forEach((items) => {
    // ditambahkan event click untuk setiap data expand
    items.addEventListener("click", function () {
      // mengambil id dari data expand
      const id = items.getAttribute("data-expand");
      // mengambil data open
      const open = items.getAttribute("data-open");

      const bottomArrow = items.querySelector("img");

      //   jika open bernilai false maka data open diubah menjadi true dan data dengan id yang sama dengan id di data expand dihapus class hidden
      if (open === "false") {
        items.setAttribute("data-open", "true");
        document.getElementById(id).classList.remove("hidden");
        bottomArrow.classList.remove("rotate-0");
        bottomArrow.classList.add("rotate-180");
        // jika open bernilai true maka data open diubah menjadi false dan data dengan id yang sama dengan id di data expand ditambahkan class hidden
      } else {
        items.setAttribute("data-open", "false");
        document.getElementById(id).classList.add("hidden");
        bottomArrow.classList.remove("rotate-180");
        bottomArrow.classList.add("rotate-0");
      }
    });
  });
});
