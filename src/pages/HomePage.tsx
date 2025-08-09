import React, { useEffect, useState } from "react";
import BackgroundHomeBanner from "../../public/assets/images/backgrounds/home-banner.png";
import CompanyLogo from "../../public/assets/images/logos/company.svg";
import logoNotification from "../../public/assets/images/icons/notification.svg";
import logoCart from "../../public/assets/images/icons/cart.svg";
import iconLivingRoom from "../../public/assets/images/icons/living-room.svg";
import iconKitchen from "../../public/assets/images/icons/kitchens.svg";
import iconGarden from "../../public/assets/images/icons/gardens.svg";
import iconSecurity from "../../public/assets/images/icons/security.svg";
import iconRecreation from "../../public/assets/images/icons/recreation.svg";
import iconStorage from "../../public/assets/images/icons/storages.svg";
import backgroundAdverticement from "../../public/assets/images/backgrounds/adverticement.png";
import iconStar from "../../public/assets/images/icons/star.svg";
import cardDecoration from "../../public/assets/images/backgrounds/decoration.svg";
import watchMovie from "../../public/assets/images/thumbnails/watchtv-medium.png";
import iconDate from "../../public/assets/images/icons/date.svg";
import iconClock from "../../public/assets/images/icons/clock.svg";
import iconNote from "../../public/assets/images/icons/note.svg";
import iconChat from "../../public/assets/images/icons/chat.svg";
import iconProfile from "../../public/assets/images/icons/profil.svg";
import iconBrowse from "../../public/assets/images/icons/browse.svg";
import type { Category, HomeService } from "../interface/type";
import apiClient from "../services/apiServices";

const fetchCategories = async () => {
  const response = await apiClient.get("categories");
  return response.data.data;
};

const fetchServices = async () => {
  const response = await apiClient.get("services?is_popular=1");
  return response.data.data;
};

function HomePage() {
  const [categories, setCategories] = useState<Category[]>([]);
  const [services, setServices] = useState<HomeService[]>([]);
  const [loadingCategories, setLoadingCategories] = useState(true);
  const [loadingServices, setLoadingServices] = useState(true);
  const [error, setError] = useState<string | null>(null);

  // tambahkan script untuk load js swiper
  // useEffect dalam react adalah method untuk maipulasi DOM menambahkan style dan js
  useEffect(() => {
    // script js
    if (!loadingCategories && !loadingServices) {
      const script = document.createElement("script");
      script.src = "/assets/js/main.js";
      script.async = true;
      document.body.appendChild(script);

      // styling css
      const css = document.createElement("link");
      css.href = "/assets/css/main.css";
      css.rel = "stylesheet";
      document.head.appendChild(css);

      return () => {
        document.body.removeChild(script);
        document.head.removeChild(css);
      };
    }

    // fetch data API
    const fetchCategoriesData = async () => {
      try {
        const categories = await fetchCategories();
        setCategories(categories);
        setLoadingCategories(false);
        // console.log(categories);
      } catch (error) {
        console.error("Error fetching categories:", error);
        setError("Failed to fetch categories");
        setLoadingCategories(false);
      } finally {
        setLoadingCategories(false);
      }
    };

    const fetchServicesData = async () => {
      try {
        const services = await fetchServices();
        setServices(services);
        setLoadingServices(false);
        // console.log(services);
      } catch (error) {
        console.error("Error fetching services:", error);
        setError("Failed to fetch services");
        setLoadingServices(false);
      } finally {
        // Update services state
        setLoadingServices(false);

        // Set loading state to false
      }
    };

    fetchCategoriesData();
    fetchServicesData();
  }, [loadingCategories, loadingServices]);

  if (loadingCategories && loadingServices) {
    return <p>Loading Data Categories && Loading Data Services...</p>;
  }

  if (error) {
    return <p>Error Loading Data: {error}</p>;
  }

  const BASE_URL_STORAGE = import.meta.env.VITE_BASE_URL_API_STORAGE;

  const formatCurrency = (value: number) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      maximumFractionDigits: 0,
    }).format(value);
  };
  return (
    <>
      <main className="relative w-full bg-white mx-auto overflow-hidden pb-[200px]">
        <div id="Background" className="absolute left-0 right-0 top-0">
          <img
            src={BackgroundHomeBanner}
            alt="image"
            className="h-[300px] lg:h-[500px] md:h-[400px] sm:h-[300px] w-full object-cover object-bottom"
          />
        </div>
        <nav id="Navbar" className="fixed left-0 right-0 top-5 z-30">
          <div className="relative mx-auto max-w-[640px] px-5">
            <div
              id="NavTop"
              className="flex items-center justify-between rounded-[22px] bg-white px-4 py-[14px] transition-all duration-300"
            >
              <a href="#">
                <img
                  src={CompanyLogo}
                  alt="icon"
                  className="h-[40px] w-[114px] shrink-0"
                />
              </a>
              <ul className="flex items-center gap-[10px]">
                <li className="shrink-0">
                  <a href="#">
                    <div className="flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-full border border-[#E4E5E9]">
                      <img
                        src={logoNotification}
                        alt="icon"
                        className="h-[22px] w-[22px] shrink-0"
                      />
                    </div>
                  </a>
                </li>
                <li className="shrink-0">
                  <a href="#">
                    <div className="flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-full border border-[#E4E5E9]">
                      <img
                        src={logoCart}
                        alt="icon"
                        className="h-[22px] w-[22px] shrink-0"
                      />
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <header className="relative mt-[180px] flex justify-center items-center lg:justify-center lg:items-center md:justify-center md:items-center sm:items-center sm:justify-center">
          <h1 className="lg:text-[32px] md:text-[25px] sm:text-[25px] lg:max-w-full sm:max-w-full md:max-w-full font-extrabold">
            Discover Top Home Services
          </h1>
        </header>
        {/* pake swiper untuk geser katalog categories di import */}
        <section
          id="Categories"
          className="swiper z-5 mt-[60px] lg:mt-[190px] md:mt-[120px] sm:mt-[60px] w-full flex items-center justify-center overflow-x-hidden"
        >
          <div className="swiper-wrapper pb-[30px] flex flex-row lg:flex-row md:flex-row sm:flex-row items-center justify-center">
            {categories.length > 0
              ? categories.map((category) => (
                  <div key={category.id} className="swiper-slide !w-fit">
                    <a href="src/category.html" className="card">
                      <div className="flex flex-col shrink-0 space-y-3 rounded-[24px] border border-[#E4E5E9] bg-white py-5 px-5 text-center hover:border-[#D04B1E]">
                        <div className="mx-auto h-[70px] w-[70px] shrink-0 flex items-center justify-center overflow-hidden rounded-full">
                          <img
                            src={`${BASE_URL_STORAGE}/${category.photo}`}
                            alt="icon"
                            className="h-full w-full object-cover object-center"
                          />
                        </div>
                        <div className="flex flex-col min-w-[130px] gap-[2px]">
                          <h3 className="font-semibold">{category.name}</h3>
                          <p className="text-sm leading-[21px] text-[#43484C]">
                            {category.home_services_count} Services
                          </p>
                        </div>
                      </div>
                    </a>
                  </div>
                ))
              : "Belum ada data"}
          </div>
          <div className="swiper-button-prev" />
          <div className="swiper-button-next" />
        </section>
        <section
          id="Adverticement"
          className="relative flex justify-center items-center px-5 lg:px-5 md:px-5 sm:px-10"
        >
          <a href="#">
            <img
              src={backgroundAdverticement}
              alt="icon"
              className="h-[140px] w-full sm:h-[140px] md:h-[240px] lg:h-[340px]"
            />
          </a>
        </section>
        <section
          id="PopularSummer"
          className="relative mt-[50px] flex flex-col gap-y-[14px] justify-center items-center mx-auto left-0 right-0"
        >
          <div className="flex justify-center items-center mx-auto w-full">
            <h2 className="text-[50px] sm:text-[45px] md:text-[45px] lg:text-[50px] font-bold leading-[27px]">
              Popular This Summer
            </h2>
          </div>
          <div
            id="PopularSummerSwiper"
            className="swiper w-full overflow-x-hidden mt-[50px]"
          >
            <div className="swiper-wrapper flex flex-row justify-center items-center">
              {services.length > 0 ? (
                services.map((service) => (
                  <div key={service.id} className="swiper-slide !w-fit">
                    <a href="src/service-details.html" className="card">
                      <div className="relative flex flex-col overflow-hidden rounded-[24px] border border-[#E4E5E9] p-4 shrink-0 gap-[12px] w-[230px] transistion-all duration-300 hover:border-[#D04B1E]">
                        <span className="absolute right-[26px] top-[26px] shrink-0 rounded-full bg-white px-2 py-[7px]">
                          <div className="flex items-center gap-[4px]">
                            <img
                              src={iconStar}
                              alt="icon"
                              className="h-[15px] w-full"
                            />
                            <p className="text-xs font-semibold leading-[18px]">
                              4.8
                            </p>
                          </div>
                        </span>
                        <div className="flex h-[140px] w-full shrink-0 items-center justify-center overflow-hidden rounded-[16px] bg-[#D9D9D9]">
                          <img
                            src={`${BASE_URL_STORAGE}/${service.thumbnail}`}
                            alt="service 1"
                            className="w-full h-full object-cover object-center"
                          />
                        </div>
                        <h3 className="line-clamp-2 min-h-[48px] font-semibold max-w-full text-justify">
                          {service.name}
                        </h3>
                        <div className="flex flex-col gap-y-3">
                          <div className="flex items-center gap-2">
                            <img
                              src={iconDate}
                              alt="icon"
                              className="h-8 w-8 shrink-0"
                            />
                            <p className="text-sm leading-[21px] text-[#43484C]">
                              {service.category.name}
                            </p>
                          </div>
                          <div className="flex items-center gap-2">
                            <img
                              src={iconClock}
                              alt="icon"
                              className="h-8 w-8 shrink-0"
                            />
                            <p className="text-sm leading-[21px] text-[#43484C]">
                              {service.duration} Hours
                            </p>
                          </div>
                          <strong className="font-semibold text-[#D04B1E]">
                            {formatCurrency(service.price)}
                          </strong>
                          <img
                            className="absolute right-0 bottom-0"
                            src={cardDecoration}
                            alt="icon"
                          />
                        </div>
                      </div>
                    </a>
                  </div>
                ))
              ) : (
                <p>Belum ada data</p>
              )}
            </div>
          </div>
          <div className="swiper-button-prev" />
          <div className="swiper-button-next" />
        </section>
        <nav className="fixed bottom-5 left-0 right-0 z-30 mx-auto w-full">
          <div className="mx-auto max-w-[640px] px-5">
            <div className="rounded-[24px] bg-[#030504] px-[20px] py-[14px]">
              <ul className="flex items-center gap-[20.30px]">
                <li className="w-full">
                  <a href="#">
                    <div className="flex items-center justify-center gap-2 rounded-full bg-[#D04B1E] px-[18px] py-[10px] transition-all duration-300 hover:shadow-[0px_4px_10px_0px_#D04B1E80]">
                      <img
                        src={iconBrowse}
                        alt="icon"
                        className="h-6 w-6 shrink-0"
                      />
                      <p className="text-sm font-semibold leading-[21px] text-white">
                        Browse
                      </p>
                    </div>
                  </a>
                </li>
                <li className="shrink-0">
                  <a href="#">
                    <div className="flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-full border border-shujia-graylight transition-all duration-300 hover:border-shujia-orange">
                      <img
                        src={iconNote}
                        alt="icon"
                        className="h-[22px] w-[22px] shrink-0"
                      />
                    </div>
                  </a>
                </li>
                <li className="shrink-0">
                  <a href="#">
                    <div className="flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-full border border-shujia-graylight transition-all duration-300 hover:border-shujia-orange">
                      <img
                        src={iconChat}
                        alt="icon"
                        className="h-[22px] w-[22px] shrink-0"
                      />
                    </div>
                  </a>
                </li>
                <li className="shrink-0">
                  <a href="#">
                    <div className="flex h-[44px] w-[44px] shrink-0 items-center justify-center rounded-full border border-shujia-graylight transition-all duration-300 hover:border-shujia-orange">
                      <img
                        src={iconProfile}
                        alt="icon"
                        className="h-[22px] w-[22px] shrink-0"
                      />
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </main>
    </>
  );
}

export default HomePage;
