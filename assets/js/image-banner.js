import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

(function () {
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  var mm = gsap.matchMedia();

  mm.add("(min-width: 768px)", function () {
    gsap.utils.toArray(".image-banner").forEach(function (banner) {
      var image = banner.querySelector(".image-banner__image");

      if (!image) {
        return;
      }

      gsap.fromTo(
        image,
        {
          yPercent: -10,
        },
        {
          yPercent: 10,
          ease: "none",
          scrollTrigger: {
            trigger: banner,
            start: "top bottom",
            end: "bottom top",
            scrub: 1,
            invalidateOnRefresh: true,
          },
        }
      );
    });
  });
})();
