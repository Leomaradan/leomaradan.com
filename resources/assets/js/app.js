var minmax = function (value, min, max) {

    if (min == undefined) {
        return value;
    }

// 75, 80 => min(75, 80) = 75
    if (max == undefined) {
        return Math.min(min, value);
    }
// 0.5, 0, 1 => max(0, min(1, 0.5))
    return Math.max(min, Math.min(max, value));
};

var fixedNavbar = function () {



    $(window).scroll(function () {

        var position = $('.SiteHeader').innerHeight() /* - $('.HorizontaleMenu').outerHeight()*/;
        var positionBottom = position - $('.HorizontaleMenu').outerHeight();

        // fade à 50% -> 75%
        var relativeScroll = 100 / position * $(window).scrollTop();

        var titlePosition = minmax((40 / 75 * relativeScroll) + 35, 80);

        //var titleOpacity = /*minmax(*/relativeScroll - 50/*, 50, 75)*/;// (5-Math.min(5,Math.max(,0)))/5; 
        //var titleOpacity = minmax(1-(relativeScroll - 50)/25, 0, 1);// (5-Math.min(5,Math.max(,0)))/5; 
        var titleOpacity = minmax(1 - (relativeScroll) / 75, 0, 1);// (5-Math.min(5,Math.max(,0)))/5; 

        console.log(relativeScroll);
        console.log(titleOpacity);

        $('.SiteHeader h1').css('top', titlePosition + '%');
        $('.SiteHeader h1').css('opacity', titleOpacity);

        if ($(window).scrollTop() > positionBottom) {
            $('.HorizontaleMenu').addClass('Scroll');
        }
        if ($(window).scrollTop() < (positionBottom + 1)) {
            $('.HorizontaleMenu').removeClass('Scroll');
        }
    });
};

fixedNavbar();		