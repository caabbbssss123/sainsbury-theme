(function ($) {
  function scrollTabIntoView($tab) {
    var grid = $tab.closest(".icon-grid__grid").get(0);
    var tab = $tab.get(0);

    if (!grid || !tab || grid.scrollWidth <= grid.clientWidth) {
      return;
    }

    grid.scrollTo({
      left: Math.max(0, tab.offsetLeft - (grid.clientWidth - tab.offsetWidth) / 2),
      behavior: "smooth",
    });
  }

  function activateTab($tab) {
    var $block = $tab.closest(".icon-grid");
    var $tabs = $block.find(".icon-grid__item");

    $tabs
      .removeClass("is-active")
      .attr({ "aria-selected": "false", tabindex: "-1" });

    $tab.addClass("is-active").attr({ "aria-selected": "true", tabindex: "0" });

    $block.find(".icon-grid__panel").attr("hidden", "hidden");
    $block.find("#" + $tab.attr("aria-controls")).removeAttr("hidden");
    scrollTabIntoView($tab);
  }

  $(document).on("click", ".icon-grid__item", function () {
    activateTab($(this));
  });

  $(document).on("keydown", ".icon-grid__item", function (e) {
    if (e.key !== "ArrowLeft" && e.key !== "ArrowRight") {
      return;
    }

    e.preventDefault();

    var $tabs = $(this).closest(".icon-grid").find(".icon-grid__item");
    var index = $tabs.index(this);
    var next = e.key === "ArrowRight" ? index + 1 : index - 1;

    if (next < 0) {
      next = $tabs.length - 1;
    } else if (next >= $tabs.length) {
      next = 0;
    }

    var $next = $tabs.eq(next);

    activateTab($next);
    $next.trigger("focus");
  });
})(jQuery);
