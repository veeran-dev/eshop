function mycarousel_initCallback(carousel)
{
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto();
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto();
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        auto: 0,
        wrap: 'both',
        visible: carousel_items_visible,
        scroll: carousel_scroll,
        initCallback: mycarousel_initCallback
    });
});