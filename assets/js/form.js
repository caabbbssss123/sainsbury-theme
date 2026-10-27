(function ($) {
  function isValueControl(element) {
    var type = (element.type || "").toLowerCase();

    return type !== "hidden" && type !== "submit" && type !== "button";
  }

  function fieldHasValue($field) {
    var hasValue = false;

    $field.find("input, textarea, select").each(function () {
      if (!isValueControl(this)) {
        return;
      }

      if (this.type === "checkbox" || this.type === "radio") {
        if (this.checked) {
          hasValue = true;
        }
        return;
      }

      if ($.trim($(this).val())) {
        hasValue = true;
      }
    });

    return hasValue;
  }

  function floatTarget(element) {
    var $element = $(element);
    var $column = $element.closest(".gform-grid-col");

    if ($column.length) {
      return $column;
    }

    return $element.closest(".gfield");
  }

  function updateFieldState($field) {
    $field.toggleClass("has-value", fieldHasValue($field));
  }

  function initFloatingLabels($context) {
    $context.find(".gform-field-label__text").each(function () {
      if ($(this).text().indexOf("*") !== -1) {
        $(this).siblings(".gfield_required").attr("hidden", true);
      }
    });

    $context.find(".gfield, .gform-grid-col").each(function () {
      updateFieldState($(this));
    });
  }

  $(document).on("focusin", ".gfield input, .gfield textarea, .gfield select", function () {
    floatTarget(this).addClass("is-active");
  });

  $(document).on("focusout", ".gfield, .gform-grid-col", function () {
    var $field = $(this);

    window.setTimeout(function () {
      if (!$field.find(document.activeElement).length) {
        $field.removeClass("is-active");
      }

      updateFieldState($field);
    }, 0);
  });

  $(document).on("input change", ".gfield input, .gfield textarea, .gfield select", function () {
    updateFieldState(floatTarget(this));
  });

  $(function () {
    initFloatingLabels($(document));
  });

  $(document).on("gform_post_render", function (event, formId) {
    initFloatingLabels($("#gform_wrapper_" + formId));
  });
})(jQuery);
