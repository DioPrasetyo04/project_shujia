window.addEventListener("scroll", function () {
  const Navbar = this.document.getElementById("NavTop");
  const containerNav = this.document.getElementById("ContainerNav");
  const Title = this.document.getElementById("Title");
  const backArrow = this.document.getElementById("iconArrow");
  const Scroll = this.window.scrollY;
  if (Scroll > 0) {
    Navbar.classList.remove("top-[16px]");
    Navbar.classList.add("top-[30px]");
    Title.classList.remove("text-white");
    Title.classList.add("text-black");
    backArrow.classList.add("border", "border-[#43484C]");
    containerNav.classList.add(
      "bg-white",
      "rounded-[22px]",
      "px-[16px]",
      "shadow-[0px_12px_20px_0px_#0305041C]"
    );
  } else {
    Navbar.classList.remove("top-[30px]");
    Navbar.classList.add("top-[16px]");
    Title.classList.add("text-white");
    backArrow.classList.remove("border", "border-[#43484C]");
    containerNav.classList.remove(
      "bg-white",
      "rounded-[22px]",
      "px-[16px]",
      "shadow-[0px_12px_20px_0px_#0305041C]"
    );
  }
});

const dataExpand = document.querySelectorAll("[data-expand]");
const dataOpen = document.querySelectorAll("[data-open]");

window.addEventListener("DOMContentLoaded", function () {
  // dibuat foreach karena data expand ada 2 melebihi satu sehingga harus dibuat forEach agar bisa digunakan dalam jumlah banyak yang lebih dari satu
  dataExpand.forEach((items) => {
    // ditambahkan event click untuk setiap data expand
    items.addEventListener("click", function () {
      // mengambil id dari data expand
      const id = this.getAttribute("data-expand");
      // mengambil data open
      const open = this.getAttribute("data-open");

      const bottomArrow = this.querySelector("img");

      //   jika open bernilai false maka data open diubah menjadi true dan data dengan id yang sama dengan id di data expand dihapus class hidden
      if (open === "false") {
        this.setAttribute("data-open", "true");
        document.getElementById(id).classList.remove("hidden");
        bottomArrow.classList.remove("rotate-0");
        bottomArrow.classList.add("rotate-180");
        // jika open bernilai true maka data open diubah menjadi false dan data dengan id yang sama dengan id di data expand ditambahkan class hidden
      } else {
        this.setAttribute("data-open", "false");
        document.getElementById(id).classList.add("hidden");
        bottomArrow.classList.remove("rotate-180");
        bottomArrow.classList.add("rotate-0");
      }
    });
  });
});
