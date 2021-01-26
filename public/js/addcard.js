$(document).ready(function () {
    "use strict";
    $(document).on('click', '.add-card-btn', function (e) {
        e.preventDefault();
        const adsId = $(this).data("id");
        const url = './addcard/' + adsId;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {},
            success: function (res) {
                console.log(1, res);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(2, thrownError);
            }
        });
    });
});

function showLoading() {
    $('.loading').show();
}

function hideLoading() {
    $('.loading').hide();
}
