"use strict";

jQuery(function ($) {
  "use strict";

  function is_touch_device() {
    try {
      document.createEvent("TouchEvent");
      return true;
    } catch (e) {
      return false;
    }
  }

  function close_touch_menu() {
    var container = $('.open'); // if the target of the click isn't the container nor a descendant of the container

    if (!container.is(e.target) && container.has(e.target).length === 0) {
      $('.open').removeClass('open');
    }
  }

  $(document).ready(function () {
    /* Listener */
    console.log(is_touch_device());
    var touchresult = is_touch_device();

    if (touchresult == true) {
      $('.bigScreenMenu .nav').addClass('touchscreen');
      $('.touchscreen > .parent > a').attr("href", "#");
      $('.touchscreen > .parent').click(function () {
        $(this).addClass('open');
      });
      $(document).click(close_touch_menu);
      $('.open').click(close_touch_menu);
    } else {
      $('.bigScreenMenu .nav.menu > li').hover(function () {
        $(this).toggleClass('hover');
      });
    }

    $('.mobileMenu > label').click(function () {
      $('.mobileMenu').toggleClass('active');
    });
    $("div.second").replaceWith("<h2>New heading</h2>");
    /* general */

    $(".mobileMenu ul.nav > li.deeper > a").after("<span class='expand'>+</span>");
    $('.mobileMenuWrapper .parent .expand').bind('click touch', function (e) {
      if ($(this).hasClass("active")) {
        $(this).text(function () {
          return $(this).text().replace("–", "+");
        });
      } else {
        $(this).text(function () {
          return $(this).text().replace("+", "–");
        });
      }

      $(this).toggleClass('active');
    });
    $('.blog').imagesLoaded(function () {
      console.log('alle bilder geladen');

      var adjustArticleHeights = function () {
        var leftColumnHeight = 0,
            rightColumnHeight = 0,
            $articles = $('.items-row');

        for (var i = 0; i < $articles.length; i++) {
          // This just adds random heights to articles
          //   $articles.eq(i).height(Math.floor(Math.random() * 300) + 10);
          if (leftColumnHeight > rightColumnHeight) {
            rightColumnHeight += $articles.eq(i).addClass('right').outerHeight(true);
          } else {
            leftColumnHeight += $articles.eq(i).outerHeight(true);
          }
        }

        return $articles;
      }();
    });
    $('.blog-featured .items-row').imagesLoaded(function () {
      console.log('alle bilder geladen');

      var adjustArticleHeights = function () {
        var leftColumnHeight = 0,
            rightColumnHeight = 0,
            $articles = $('.item');

        for (var i = 0; i < $articles.length; i++) {
          if (leftColumnHeight > rightColumnHeight) {
            rightColumnHeight += $articles.eq(i).addClass('right').outerHeight(true);
          } else {
            leftColumnHeight += $articles.eq(i).outerHeight(true);
          }
        }

        return $articles;
      }();
    });
  });
});