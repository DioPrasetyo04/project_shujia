const Slider = new Swiper("#mostOrderedSlider", {
  direction: "horizontal",
  slidesPerView: "auto",
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    320: {
      slidesPerView: "auto",
      spaceBetween: 20,
      slidesOffsetAfter: -390,
      slidesOffsetBefore: 430,
    },
    360: {
      slidesPerView: "auto",
      spaceBetween: 20,
      slidesOffsetAfter: -390,
      slidesOffsetBefore: 410,
    },
    490: {
      slidesPerView: "auto",
      spaceBetween: 20,
      slidesOffsetAfter: -320,
      slidesOffsetBefore: 350,
    },
    600: {
      slidesPerView: "auto",
      spaceBetween: 20,
      slidesOffsetAfter: -250,
      slidesOffsetBefore: 290,
    },
    750: {
      slidesPerView: "auto",
      spaceBetween: 20,
      slidesOffsetAfter: -200,
      slidesOffsetBefore: 240,
    },
    768: {
      slidesPerView: "auto",
      spaceBetween: 20,
      slidesOffsetAfter: -170,
      slidesOffsetBefore: 210,
    },
    1024: {
      slidesPerView: "auto",
      spaceBetween: 20,
      loop: true,
      slidesOffsetAfter: -70,
      slidesOffsetBefore: 50,
    },
  },
});

window.addEventListener("scroll", function () {
  const Navbar = this.document.getElementById("Navbar");
  const containerNav = this.document.getElementById("ContainerNav");
  const Title = this.document.getElementById("title");
  const cart = this.document.getElementById("cart");
  const back = this.document.getElementById("back");
  const Scroll = this.window.scrollY;
  if (Scroll > 0) {
    Navbar.classList.remove("top-[16px]");
    Navbar.classList.add("top-[30px]");
    Title.classList.remove("text-white");
    Title.classList.add("text-black");
    cart.classList.add("border", "border-[#43484C]");
    back.classList.add("border", "border-[#43484C]");
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
    cart.classList.remove("border", "border-[#43484C]");
    back.classList.remove("border", "border-[#43484C]");
    containerNav.classList.remove(
      "bg-white",
      "rounded-[22px]",
      "px-[16px]",
      "shadow-[0px_12px_20px_0px_#0305041C]"
    );
  }
});
