function superpuper(elem) {

        $(elem).addClass('active_f');
        var values = $('.active_f').map(function (index, element) {
            return $(this).attr('data-id');
        }).get();
        var section_id = $('#section_list').attr('data-id');
        $.ajax({
                url: '/include/ajax/section.php',
                metod: 'POST',
                data: {'section_id': section_id, 'filter_id': values},
                success: function (data) {
                    $('#section_list').html('');
                    $('#section_list').html(data);
                    $('.slider-container').bxSlider({
                        auto: false,
                        pause: 3000,
                        speed: 500,
                        controls: true,
                        pager: false
                    });
                }
            }
        )
}

$(document).ready(function () {


        $('.slider-container').bxSlider({
            auto: false,
            pause:3000,
            speed:500,
            controls: true,
            pager:false
        });
    $('.sort_item').click(function (event) {
        if($(event.target).attr('class') == 'sort_item') {
            superpuper(this);
        }
    });

    $('.close_im').click(function (event) {
        $(this).parent().removeClass('active_f');
        superpuper();
    });

});
