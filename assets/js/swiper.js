(function ($) {
  function containerWidth() {
    const container = document.querySelector(".container");
    return container ? container.offsetWidth : window.innerWidth;
  }

  function initMediaTextSliders() {
    document.querySelectorAll(".two-column-media-and-text-slider").forEach((section) => {
      const carousel = section.querySelector(".two-column-media-and-text-slider__carousel");

      if (!carousel || carousel.classList.contains("swiper-initialized") || typeof Swiper === "undefined") {
        return;
      }

      const slides = carousel.querySelectorAll(".swiper-slide");

      if (!slides.length) {
        return;
      }

      const setSlideWidth = () => {
        section.style.setProperty("--slide-width", containerWidth() + "px");
      };

      setSlideWidth();

      const swiper = new Swiper(carousel, {
        slidesPerView: "auto",
        centeredSlides: true,
        spaceBetween: 30,
        loop: slides.length > 1,
        speed: 600,
        watchOverflow: true,
        slideToClickedSlide: true,
        navigation: {
          prevEl: section.querySelector(".two-column-media-and-text-slider__arrow--prev"),
          nextEl: section.querySelector(".two-column-media-and-text-slider__arrow--next"),
        },
      });

      $(window).on("resize", function () {
        setSlideWidth();
        swiper.update();
      });
    });
  }

  initMediaTextSliders();
})(jQuery);
