var jsonp = {};

jQuery(document).ready(function ($) {


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
        data.data_id = $(this).data("id");

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

                var errors = $(".errors"),
                    classes = errors.data("surround-class"),
                    message = $("<div class='" + classes + "' />").append($("<ul/>")),
                    list = response.responseJSON;

                $.each(list, function(i) {
                    var li = $('<li/>').appendTo(message);

                    var aaa = $('<span/>').text(list[i]).appendTo(li);
                });


                errors.append(message);

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
};

function get_table_element(data) {
    $("[data-id='"+ data.data_id +"'] input").each(function() {
        var key = $(this).attr('name');
        var value = $(this).val();
        data[key] = value;
    });

    return data;
}