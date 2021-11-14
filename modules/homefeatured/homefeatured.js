function mycarousel_initCallback(carousel)
{
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto(0);
    }, function() {
        carousel.startAuto(0);
    });
};

jQuery(document).ready(function() {
    jQuery('#featuredcarousel').jcarousel({
        auto: 0,
        wrap: 'both',
        visible: carousel_items_visible,
        scroll: carousel_scroll,
        initCallback: mycarousel_initCallback
    });
});