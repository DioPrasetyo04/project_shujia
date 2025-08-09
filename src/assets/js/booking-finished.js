window.addEventListener("scroll", function () {
  const Navbar = this.document.getElementById("NavTop");
  const containerNav = this.document.getElementById("ContainerNav");
  const Title = this.document.getElementById("Title");
  const Scroll = this.window.scrollY;
  if (Scroll > 0) {
    Navbar.classList.remove("top-[16px]");
    Navbar.classList.add("top-[30px]");
    Title.classList.remove("text-white");
    Title.classList.add("text-black");
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
    containerNav.classList.remove(
      "bg-white",
      "rounded-[22px]",
      "px-[16px]",
      "shadow-[0px_12px_20px_0px_#0305041C]"
    );
  }
});
