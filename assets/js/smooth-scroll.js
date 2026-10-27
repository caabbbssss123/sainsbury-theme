import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

(function () {
  var wrapper = document.getElementById("smooth-wrapper");
  var content = document.getElementById("smooth-content");

  if (!wrapper || !content) {
    return;
  }

  document.querySelectorAll(".card-grid__popup").forEach(function (popup) {
    document.body.appendChild(popup);
  });

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  var mobileNavQuery = window.matchMedia("(max-width: 782px)");
  var mobileNav = document.querySelector("header .nav");

  function fitAdminBar() {
    var adminBar = document.getElementById("wpadminbar");

    if (!adminBar) {
      return;
    }

    var height = adminBar.offsetHeight;

    wrapper.style.top = height + "px";
    wrapper.style.bottom = "auto";
    wrapper.style.height = "calc(100% - " + height + "px)";
  }

  function syncMobileNav() {
    if (!mobileNav || !mobileNavQuery.matches) {
      return;
    }

    var y = parseFloat(gsap.getProperty(content, "y")) || 0;

    gsap.set(mobileNav, { y: -y });
  }

  var smoother = ScrollSmoother.create({
    wrapper: wrapper,
    content: content,
    smooth: 1,
    smoothTouch: 0.1,
    effects: true,
    onUpdate: syncMobileNav,
  });

  document.body.classList.add("has-smooth-scroll");
  fitAdminBar();
  syncMobileNav();

  ScrollTrigger.addEventListener("refresh", function () {
    fitAdminBar();
    syncMobileNav();
  });

  mobileNavQuery.addEventListener("change", function () {
    if (!mobileNavQuery.matches && mobileNav) {
      gsap.set(mobileNav, { clearProps: "transform" });
    }

    ScrollTrigger.refresh();
  });

  var popupOpen = document.body.classList.contains("popup-open");
  var classObserver = new MutationObserver(function () {
    var isOpen = document.body.classList.contains("popup-open");

    if (isOpen === popupOpen) {
      return;
    }

    popupOpen = isOpen;
    smoother.paused(isOpen);
  });

  classObserver.observe(document.body, {
    attributes: true,
    attributeFilter: ["class"],
  });
})();
