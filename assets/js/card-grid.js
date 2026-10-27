(function ($) {
  function openPopup($popup) {
    $popup.removeAttr("hidden").addClass("is-open");
    $("body").addClass("popup-open");
    $popup.find(".card-grid__popup-close").trigger("focus");
  }

  function closePopup($popup) {
    if (!$popup.length) {
      return;
    }

    $popup.attr("hidden", "hidden").removeClass("is-open");
    $("body").removeClass("popup-open");
  }

  $(document).on("click", ".card-grid__item-trigger", function (e) {
    e.preventDefault();

    var $popup = $($(this).data("popup"));

    if (!$popup.length) {
      return;
    }

    openPopup($popup);
  });

  $(document).on("click", ".card-grid__popup [data-popup-close]", function (e) {
    e.preventDefault();

    closePopup($(this).closest(".card-grid__popup"));
  });

  $(document).on("keyup", function (e) {
    if (e.key !== "Escape") {
      return;
    }

    closePopup($(".card-grid__popup.is-open"));
  });
})(jQuery);
