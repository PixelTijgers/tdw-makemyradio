common.View.create('front.modules.home.Index', {

    onDOMLoad()
    {
        this.initTest();
        this.initSlickslider();
    },

    initTest() {
        console.log('Init: front.modules.home.Index');
    },

    initSlickslider()
    {
        $('#pageSlider').slick({
            arrows: false,
            cssEase: 'linear',
            dots: true,
            fade: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 500,
        });

        $('#pageSlider').css('height', $(window).height() + 'px');
    }
})
