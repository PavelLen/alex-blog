$(document).ready(function () {
    $('#submit_search').bind('click', function(e) {
        e.preventDefault();
        var data = $('#my_search_form_mySearch').serialize(); //serialize data from <input>
        console.log(data);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: $(this).closest('form').attr('action'), //searchAction, my_search route
            data: $('#my_search_form_mySearch').serialize(), //serialize data from <input>
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            }

        });
    });
});
