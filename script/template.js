jQuery(function($) {
    "use strict";

    function is_touch_device() {  
        try {  
            document.createEvent("TouchEvent");  
            return true;  
        } catch (e) {  
            return false;  
        }  
    }

    $( document ).ready(function() {
        /* Listener */
        console.log(is_touch_device());

        $('header .bigScreenMenu nav .helper').addClass('search').prepend( "<svg xmlns='http://www.w3.org/2000/svg'viewBox='0 0 24 24'><defs></defs><g transform='translate(537 528.9)'><path class='a' d='M-520.28-513.553a9.412,9.412,0,0,0,2.111-5.931,9.424,9.424,0,0,0-9.416-9.416A9.424,9.424,0,0,0-537-519.484a9.424,9.424,0,0,0,9.416,9.416,9.412,9.412,0,0,0,5.931-2.111l7,7a.992.992,0,0,0,1.374,0,.992.992,0,0,0,0-1.374Zm-7.3,1.541a7.479,7.479,0,0,1-7.472-7.472,7.479,7.479,0,0,1,7.472-7.472,7.479,7.479,0,0,1,7.472,7.472A7.479,7.479,0,0,1-527.584-512.012Z'/></g></svg><ul><li></li></ul>");
        $('header .mobileMenu nav .helper').addClass('mobile-search').prepend("<li><a href='https://www.andreanum.de/index.php/component/search/?searchword=&searchphrase=all&Itemid=101'>Suche</a></li>");
        $(".moduletable.searchwrapper").appendTo("header .bigScreenMenu nav .search ul li");

        if(('ontouchstart' in window) || (navigator.MaxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0) || (window.DetectIt.deviceType === 'hybrid')){
            $('.bigScreenMenu .nav').addClass('touchscreen');
            $('.touchscreen > .parent > a').removeAttr("href");;

            // var href = $(this).attr('href');
            // $( ".open > .nav-child" ).prepend( "<li class='overview'><a href='#'>Kategorieübersicht</a></li>" );

            $(".touchscreen > .parent").click(function() {
                var current = $(this);
            
                if(current.hasClass('open')){
                    //Remove all
                    $('.open').removeClass('open');
                    console.log('this open vorhanden');
                }
                else{
                    //Remove all
                    $('.open').removeClass('open');
                
                    //Add to current
                    current.addClass("open");
                    console.log('this open NICHT vorhanden');

                }      
            
                //return false;
            });

            $(".touchscreen nav .search").click(function() {
                var current = $(this);
            
                if(current.hasClass('open')){
                    //Remove all
                    $('.open').removeClass('open');
                    console.log('this open vorhanden');
                }
                else{
                    //Remove all
                    $('.open').removeClass('open');
                
                    //Add to current
                    current.addClass("open");
                    console.log('this open NICHT vorhanden');

                }      
            });

            //$('.touchscreen > .parent.open').click().removeClass('open');

            $(document).click(function(e){
               
                var container = $('.open');
                var dropdown = $('.open > ul');
                // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0 && !dropdown.is(e.target) && dropdown.has(e.target).length === 0) 
                {
                    $('.open').removeClass('open');
                }
                
                // $('.bigScreenMenu').click(function(e){
                //     if($(".open")[0]){
                //         $('.open').removeClass('open');
                //     }
                //     else{
                        
                //     }
                    
                // });
            });

        }
        else{
            $('.bigScreenMenu .nav.menu > li').hover(
                function(){$(this).toggleClass('hover');}
            );

            $('.bigScreenMenu .nav .search').hover(
                function(){$(this).toggleClass('hover');}
            );


        }
      
        $('.mobileMenu > label').click(
            function(){$('.mobileMenu').toggleClass('active');}
        );

        $( "div.second" ).replaceWith( "<h2>New heading</h2>" );

        /* general */
        $( ".mobileMenu ul.nav > li.deeper > a" ).after( "<span class='expand'>+</span>" );

        $('.mobileMenuWrapper .parent .expand').bind('click touch', function (e){
            if ( $( this ).hasClass( "active" ) ) {
                $(this).text(function () {
                    return $(this).text().replace("–", "+"); 
                });                        
            }
            else{
                $(this).text(function () {
                    return $(this).text().replace("+", "–"); 
                });  
            }
            $( this ).toggleClass('active');
        }
        );


        $('.blog').imagesLoaded( function() {
            // console.log('alle bilder geladen');

            var adjustArticleHeights = (function () {
        
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
            })();
        });

        $('.blog-featured .items-row').imagesLoaded( function() {
            // console.log('alle bilder geladen');

            var adjustArticleHeights = (function () {
        
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
            })();
        });
        
        /* Ausblenden der Introduction auf Suchseite: */
        if ($('main > .search').length) {
            $(".moduletable-home-introduction .category-desc").remove();
            $(".moduletable-home-introduction .subheading-category > b").addClass("searchresultsintro").text("Suchergebnisse:");
        }

        if ($('.personlist .personid-121').length) {
            var htmlContent = `
                    <span class="fieldvalue" aria-label="E-Mail">
                        <span id="cloak86f50006bc2260aa7f98a1781f0fff77">
                            <span>a.lueck<!-- sdfjsdhfkjypcs -->@<span class="blockspam" aria-hidden="true">PLEASE GO AWAY!</span><!-- sdfjsdhfkjypcs -->andreanum.net</span>
                        </span>
                        <script type="text/javascript">
                            document.getElementById('cloak86f50006bc2260aa7f98a1781f0fff77').innerHTML = '';
                            var prefix = '&#109;a' + 'i&#108;' + '&#116;o';
                            var path = 'hr' + 'ef' + '=';
                            var addy86f50006bc2260aa7f98a1781f0fff77 = '&#97;.l&#117;&#101;ck' + '&#64;';
                            addy86f50006bc2260aa7f98a1781f0fff77 = addy86f50006bc2260aa7f98a1781f0fff77 + '&#97;ndr&#101;&#97;n&#117;m' + '&#46;' + 'n&#101;t';
                            var addy_text86f50006bc2260aa7f98a1781f0fff77 = '&#97;.l&#117;&#101;ck' + '&#64;' + '&#97;ndr&#101;&#97;n&#117;m' + '&#46;' + 'n&#101;t';
                            document.getElementById('cloak86f50006bc2260aa7f98a1781f0fff77').innerHTML += '<a ' + path + '\'' + prefix + ':' + addy86f50006bc2260aa7f98a1781f0fff77 + '\'>'+addy_text86f50006bc2260aa7f98a1781f0fff77+'<\/a>';
                        </script>
                    </span>
            `;
            $('.personid-121 div.personinfo .fieldemail').empty().append(htmlContent);
        }

    });

    $(".panorama").panorama_viewer({
        repeat: true,              // The image will repeat when the user scroll reach the bounding box. The default value is false.
        direction: "horizontal",    // Let you define the direction of the scroll. Acceptable values are "horizontal" and "vertical". The default value is horizontal
        animationTime: 0,         // This allows you to set the easing time when the image is being dragged. Set this to 0 to make it instant. The default value is 700.
        easing: "ease",         // You can define the easing options here. This option accepts CSS easing options. Available options are "ease", "linear", "ease-in", "ease-out", "ease-in-out", and "cubic-bezier(...))". The default value is "ease-out".
        overlay: true               // Toggle this to false to hide the initial instruction overlay
      });

    $(".andreaner").prepend( "<li class='inserted'><a href='/index.php/unsere-schule/geschichte/'>Geschichte</a></li>" );

    /* Digitatü Modul: Link übertragung auf Wrapper */
    var digitatueLink = $(".digitatue-subline").attr('href');
    $(".digitatue-wrapper").wrapAll(`<a class='digitatue-link' href='${digitatueLink}' target='_blank'>`);

     
});

/* Script für Slider im Header */
jQuery(window).on("load", function() {
    new JCaption("img.caption");
  });

  jQuery(function($) {
    $(document).ready(function() {

      setInterval(function(){
        if ($('.image-wrapper .image-slider').length) {
            var elemId = $('.image-wrapper .image-slider').attr('id');

            var nextId = parseInt(elemId) + 1;

            //wenn ID vorhanden
            if($('.hidden-helper-container #'+nextId).length){
              $("#"+nextId).detach().appendTo('.image-wrapper').hide().fadeIn(2000);
              // console.log("neues Bild eingefügt, altes Bild wird entfernt");
              $("#"+elemId).fadeOut(2000, function() { $(this).detach().appendTo('.hidden-helper-container'); });
              // console.log("Bild verschoben");
            }
            else{
              $("#1").detach().appendTo('.image-wrapper').hide().fadeIn(2000);
              // $("#"+elemId).detach().appendTo('.hidden-helper-container');
              $("#"+elemId).fadeOut(2000, function() { $(this).detach().appendTo('.hidden-helper-container'); });
              // console.log("Schleife beginnt von neu");
            }


        } else {
            $("#1").detach().appendTo('.image-wrapper').hide().fadeIn(2000);
            // console.log("Bild noch nicht vorhanden");
        };
      }, 6000); // Zeit bis nächstes Bild geladen wird
    });
  });