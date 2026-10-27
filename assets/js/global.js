import { gsap } from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { ScrollSmoother } from "gsap/ScrollSmoother";

gsap.registerPlugin(ScrollToPlugin, ScrollSmoother);

(function ($) {
  function scrollTarget(hash) {
    if (!hash || hash === "#") {
      return $();
    }

    var $target = $(hash);

    if (!$target.length) {
      $target = $('[data-scroll="' + hash + '"]').first();
    }

    return $target;
  }

  function scrollToSection(hash) {
    var $target = scrollTarget(hash);

    if (!$target.length) {
      return false;
    }

    var smoother = ScrollSmoother.get();

    if (smoother) {
      smoother.scrollTo($target.get(0), true, "top top");
    } else {
      gsap.to(window, {
        duration: 0.9,
        scrollTo: {
          y: $target.offset().top,
          autoKill: true,
        },
        ease: "power2.inOut",
      });
    }

    if (window.history && window.history.replaceState) {
      window.history.replaceState(null, "", hash);
    }

    return true;
  }

  $(document).on("click", 'a[href*="#"]', function (e) {
    if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) {
      return;
    }

    var link;

    try {
      link = new URL(this.href, window.location.href);
    } catch (error) {
      return;
    }

    if (link.origin !== window.location.origin || link.pathname !== window.location.pathname || !link.hash || link.hash === "#") {
      return;
    }

    if (!scrollToSection(link.hash)) {
      return;
    }

    e.preventDefault();

    if ($(".navbar-toggle").hasClass("finished")) {
      $(".navbar-toggle").trigger("click");
    }
  });

  if (window.location.hash && scrollTarget(window.location.hash).length) {
    $(window).on("load", function () {
      scrollToSection(window.location.hash);
    });
  }
})(jQuery);
