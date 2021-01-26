$(document).ready(function () {
    "use strict";
    $(document).on('click', '.add-card-btn', function (e) {
        e.preventDefault();
        showLoading();
        const btn = this;
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
                if (res.status) {
                    alert('Add thẻ thành công!');
                    alert(JSON.stringify(res.data));
                    $(btn).hide();
                } else {
                    alert('Add thẻ không thành công!');
                }
                hideLoading();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(2, thrownError);
                alert(thrownError);
                hideLoading();
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
