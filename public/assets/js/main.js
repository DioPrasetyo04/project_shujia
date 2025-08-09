const Categoryswiper = new Swiper("#Categories", {
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

const Serviceswiper = new Swiper("#PopularSummerSwiper", {
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

const NavbarTop = document.querySelector("#NavTop");
const Navbar = document.querySelector("#Navbar");

let previousScrollY = window.scrollY;

window.addEventListener("scroll", () => {
  const currentScrollY = window.scrollY;

  // Scroll ke bawah ➜ Sembunyikan navbar
  if (currentScrollY > previousScrollY) {
    Navbar.classList.add("hidden");
  }
  // Scroll ke atas ➜ Tampilkan navbar
  else if (currentScrollY < previousScrollY) {
    Navbar.classList.remove("hidden");
    Navbar.classList.remove("top-5");
    Navbar.classList.add("top-3");
  }

  // Jika posisi scroll mentok ke atas (0) ➜ Ubah transparansi
  if (currentScrollY === 0) {
    NavbarTop.classList.remove("bg-white/90", "backdrop-blur-md");
    NavbarTop.classList.add("bg-white");

    Navbar.classList.remove("top-3");
    Navbar.classList.add("top-5");
    Navbar.classList.remove("hidden");
  } else {
    NavbarTop.classList.remove("bg-white");
    NavbarTop.classList.add("bg-white/90", "backdrop-blur-md");
  }

  previousScrollY = currentScrollY;
});
