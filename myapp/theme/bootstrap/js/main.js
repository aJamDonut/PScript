// Your own scripts

(function($, document, window, viewport){

$(".main-nav").click(function() {
        if(viewport.is("<sm")) {
        $(".navbar-toggle").click();
        }
        console.debug("clicknav");
        $(".main-nav").each(function() { $(this).attr("class","main-nav");});
        $(this).attr("class", "main-nav active");
    });


    var highlightBox = function( className ) {
        $(className).addClass('active');
    }

    var highlightBoxes = function() {
        $('.comparison-operator').removeClass('active');

        if( viewport.is("<=sm") ) {
            console.debug("small");
        }

        if( viewport.is("md") ) {
            console.debug("med");
        }

        if( viewport.is(">md") ) {
            console.debug("large");
        }
    }

    // Executes once whole document has been loaded
    $(document).ready(function() {

        highlightBoxes();

        console.log('Current breakpoint:', viewport.current());

    });

    $(window).resize(
        viewport.changed(function(){
            highlightBoxes();

            console.log('Current breakpoint:', viewport.current());
        })
    );

})(jQuery, document, window, ResponsiveBootstrapToolkit);

