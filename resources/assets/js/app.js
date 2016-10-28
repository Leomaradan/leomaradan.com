var app = new Vue({
    el: 'body',
    /*components: {
        alert: alert,
        navbar: navbar,
    },*/
    data: {
        errors: [],
        successes: [],
        posts: [],
        infiniteScrollUrl: null,
        infiniteScrollData: [],
        infiniteScrollInProgress: false,
        infiniteScrollCallback: null
    },
    ready: function () {
        var vm = this;
        
        window.addEventListener('scroll', function () {
            if (endOfPage() && !vm.infiniteScrollInProgress && !!vm.infiniteScrollUrl) {
                vm.infiniteScrollInProgress = true;
              vm.$http.get(vm.infiniteScrollUrl).then(function(response) {
                  var data = response.data;
                  if(data.items !== undefined) {
                      data.items.forEach(function(e) {
                          vm.infiniteScrollData.push(e);
                      });
                  }
                  if(data.nextUrl !== undefined) {
                     vm.infiniteScrollUrl = data.nextUrl;
                  }
                  if(!!vm.infiniteScrollCallback) {
                      vm.infiniteScrollCallback();
                  }
                
              }, function(response) {
                console.log(response);
                vm.infiniteScrollInProgress=false;
              });
            };
        });
    }
});

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

var endOfPage = function () {
    var totalHeight, currentScroll, visibleHeight;

    if (document.documentElement.scrollTop)
    {
        currentScroll = document.documentElement.scrollTop;
    } else
    {
        currentScroll = document.body.scrollTop;
    }

    totalHeight = document.body.offsetHeight;
    visibleHeight = document.documentElement.clientHeight;

    return totalHeight <= currentScroll + visibleHeight;
}

var fixedNavbar = function () {



    $(window).scroll(function () {

        var position = $('.SiteHeader').innerHeight() /* - $('.HorizontaleMenu').outerHeight()*/;
        var positionBottom = position - $('.HorizontaleMenu').outerHeight();

        if ($(window).scrollTop() > positionBottom) {
            $('.HorizontaleMenu').addClass('Scroll');
        }
        if ($(window).scrollTop() < (positionBottom + 1)) {
            $('.HorizontaleMenu').removeClass('Scroll');
        }
            
        if (window.matchMedia("(min-width: 600px)").matches) {

            // fade à 50% -> 75%
            var relativeScroll = 100 / position * $(window).scrollTop();

            var titlePosition = minmax((40 / 75 * relativeScroll) + 35, 80);

            //var titleOpacity = /*minmax(*/relativeScroll - 50/*, 50, 75)*/;// (5-Math.min(5,Math.max(,0)))/5; 
            //var titleOpacity = minmax(1-(relativeScroll - 50)/25, 0, 1);// (5-Math.min(5,Math.max(,0)))/5; 
            var titleOpacity = minmax(1 - (relativeScroll) / 75, 0, 1);// (5-Math.min(5,Math.max(,0)))/5; 

            $('.SiteHeader h1').css('top', titlePosition + '%');
            $('.SiteHeader h1').css('opacity', titleOpacity);


        } else {
            $('.SiteHeader h1').css('top', '0');
        }
    });
};

/*if (window.matchMedia("(max-width: 600px)").matches) {
    var height = ($('.HorizontaleMenu ul').height() + 30) + 'px';
    $('.HorizontaleMenu, .HorizontaleMenu-Background').css('height', height);
}*/

fixedNavbar();		