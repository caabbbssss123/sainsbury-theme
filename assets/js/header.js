import { gsap } from "gsap";

import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

(function ($) {
  // Burger Menu Functions
  function finished() {
    $(".navbar-toggle").addClass("finished");
  }
  function closeFinished() {
    $("#navBarText").empty().text("MENU");
    $(".navbar-toggle").removeClass("finished");
    $(".navbar-toggle").removeClass("active");
    $("#header").removeClass("finished");
  }

  // Menu click event
  $(".navbar-toggle").on("click", function (e) {
    if (!$(this).hasClass("active")) {
      $(this).addClass("active");
      $("#header").addClass("finished");

      var menuTl = gsap.timeline();
      menuTl
        .to(".main-menu", { duration: 0.5, right: 0, ease: "power2.out" }, 0)
        .to(
          ".main-menu .menu-header-main-menu-container > ul > li",
          { duration: 0.8, opacity: 1, ease: "power2.out", stagger: 0.08 },
          "myLabel"
        )
        .to(
          ".main-menu .icons-wrapper",
          { duration: 0.8, opacity: 1, ease: "power2.out", stagger: 0.08 },
          "myLabel"
        )
        .add(finished, "myLabel+=0.25");

      $("#navBarText").empty().text("CLOSE");
    } else if ($(this).hasClass("finished")) {
      var menuCloseTl = gsap.timeline();
      menuCloseTl
        .to(
          ".main-menu .menu-header-main-menu-container ul li",
          { duration: 0.4, opacity: 0, ease: "power2.out" },
          0
        )
        .to(
          ".main-menu .icons-wrapper",
          { duration: 0.4, opacity: 0, ease: "power2.out" },
          0
        )
        .to(".main-menu", { duration: 0.35, right: "-100%", ease: "power2.in" }, 0.15)
        .add(closeFinished);
    }
  });

  let isMobileMenu = $(window).width() < 782;

  function setupSubMenu() {
    if (isMobileMenu) {
      // Add parent menu items to sub-menu
      $('.menu-item-has-children > a:not(.sub-menu a)').each(function() {
        const parentLink = $(this);
        const parentHref = parentLink.attr('href');
        const parentText = parentLink.text();
        const subMenu = parentLink.siblings('.sub-menu');
    
        if (parentHref && subMenu.length) {
          // Create new list item with parent link
          const parentMenuItem = $('<li class="menu-item d-block d-md-none"><a href="' + parentHref + '">View ' + parentText + '</a></li>');
          
          // Insert at beginning of sub-menu
          subMenu.prepend(parentMenuItem);
        }
      });
    
      $(".main-menu .sub-menu").each(function () {
        const $li = $("<li>", {
          class: "sub-menu__previous",
        });
    
        const sibling_link = $(this).prev('a').attr('href');
    
        const $a = $("<a>", {
          href: "#",
          text: "Back",
        }).on("click", function (e) {
          e.preventDefault();
          $('.sub-menu.active').removeClass('active');
        });
    
        $li.append($a);
        $(this).prepend($li);
      });
    
      // Handle click on menu items with children
      $('header .menu-item-has-children > a:not(.sub-menu a)').on('click', function(e) {
        e.preventDefault();
        if($(this).siblings('.sub-menu').hasClass('active')){
          $(this).siblings('.sub-menu').removeClass('active');
          $('header .menu-item > a:not(.sub-menu a)').removeClass('deactivated');
        } else {
          $('header .sub-menu').removeClass('active');
          $(this).addClass('active-parent');
          $(this).siblings('.sub-menu').addClass('active');
          $(this).removeClass('deactivated');
          $('header .menu-item > a:not(.sub-menu a)').not(this).addClass('deactivated');
        }
      });
    } else {
      $('header .menu-item-has-children').hoverIntent({
        over: function () {
          $(this).children('.sub-menu').addClass('active');
        },
        out: function () {
          $(this).children('.sub-menu').removeClass('active');
        },
        timeout: 200,
      });
    }
  }

  setupSubMenu();

  $(window).on('resize', function() {
    const nextIsMobile = $(window).width() < 782;

    if (nextIsMobile !== isMobileMenu) {
      isMobileMenu = nextIsMobile;

      $('header .menu-item-has-children > a:not(.sub-menu a)').off('click');
      $('header .menu-item-has-children').off('mouseenter mouseleave mouseover mouseout');
      $('header .sub-menu').removeClass('active');
      $('header .menu-item > a:not(.sub-menu a)').removeClass('deactivated active-parent');
      $('header .sub-menu .sub-menu__previous').remove();
      $('header .sub-menu > .menu-item.d-block.d-md-none').remove();

      setupSubMenu();
    }
  });


  $('#close-top-bar').on('click', function(e) {
    e.preventDefault();

    $('#top-bar').fadeOut();
  });
})(jQuery);