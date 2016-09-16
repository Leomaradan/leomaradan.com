
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

/*Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: 'body'
});
*/

/*var adminmenu = new Vue({
    el: '#adminmenu',
    data: {
        items: [
            {name: 'admin', href:'#'}
        ]
    }
});*/

var app = new Vue({
    el: 'body',
    /*components: {
        alert: alert,
        navbar: navbar,
    },*/
    data: {
        test: 'test2',
        items: [],
        errors: [],
        successes: []
    } 
});

var jsonp = {};

var iniForm = function(e) {
    e.each(function() {
         $(this).data('initial', $(this).val());
    });
};

jQuery(document).ready(function ($) {

    var storageMenu = Store.get("adminmenu");
    if(storageMenu !== null) {
        app.items = storageMenu;
    }
    $.getJSON('api/admin', function(data) {
        app.items = data;
        Store.set('adminmenu', data);
    });

    $(document).on("click", ".modal-link", function() {
            var src = $(this).attr('href');
            var height = $(this).attr('data-height') || 300;
            var width = $(this).attr('data-width') || 860;
            //var 

            $("#modal_link_frame iframe").attr({'src':src,
                               'height': height,
                               'width': width});

            return false;
    });

    iniForm($(".inline-edit"));

    $(document).on('change', '.inline-edit', function() {
        var mod = 0;
        if($(this).val() !== $(this).data('initial')) {
            $(this).data('modified', 'true');
            mod = 1;
        } else {
            $(this).data('modified', 'false');
        }

        $(this).siblings().each(function() {
            if($(this).val() !== $(this).data('initial')) {
                mod++;
            }
        });

        if(mod > 0) {
            $(this).parents('tr').addClass('info'); 
        } else {
            $(this).parents('tr').removeClass('info'); 
        }

        
    });


    $(document).on("click", ".rest-link, .ajax-button", function () {

        var url = $(this).data("url");

        if (url === undefined) {
            url = $(this).attr("href");
        }

        if($(this).hasClass("rest-link-confirm")) {
            var message = ($(this).data("confirm") !== undefined) ? $(this).data("confirm") : "Êtes vous sur ?";
            if(!confirm(message)) {
                return;
            }
        }

        var method = $(this).data("method");

        var precall_fn = $(this).data("precall");

        var data = {};

        data._token = $(this).data("token");
        data.callback = $(this).data("callback");
        data.id = $(this).data("id");

        if(precall_fn !== undefined) {
            var fn = window[precall_fn];
            if(typeof fn === 'function') {
                data = fn(data);
            }
        }

        $(".errors").empty();

        $.ajax({
            type: method,
            url: url, //resource
            data: data,
            complete: function (response) {

            },
            error: function (response) {

                //var errors = $(".errors"),
                    //classes = errors.data("surround-class"),
                    //message = $("<div class='" + classes + "' />").append($("<ul/>")),
                    //message = $("<alert type='danger' />").append($("<ul/>")),
                //var list = Object.keys(response.responseJSON).map(function(value, index) {  });
                var list = response.responseJSON;

                $.each(list, function(i) {
                    app.errors.push(list[i]);
                    //var li = $('<li/>').appendTo(message);

                    //var aaa = $('<span/>').text(list[i]).appendTo(li);
                });


                //errors.append(message);

            }
        });

        return false;
    });
});

jsonp.delete_element = function (data) {
    $("[data-id='"+data.id+"']").remove();
};

jsonp.update_element = function (data) {
    var e = $("[data-id='"+data.id+"']");
    for(var k in data) {
       e.find("input[name='"+k+"']").val(data[k]);
    }   
    iniForm(e.find('.inline-edit'));
    e.removeClass('info');
};

function get_table_element(data) {
    $("[data-id='"+ data.id +"'] input").each(function() {
        var key = $(this).attr('name');
        var value = $(this).val();
        data[key] = value;
    });

    return data;
}