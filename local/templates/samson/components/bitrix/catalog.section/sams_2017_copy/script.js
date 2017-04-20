$(document).ready(function () {
    $('.slider-container').each(function () {
        var _this = $(this).bxSlider({
            auto: false,
            pause:3000,
            speed:500,
            controls: false,
            pager:false,
            onSlideBefore: function () {
               var pr = _this.parents('.section_image').children('.progress_bar');
                pr.animate({width: "0"}, 1 );
            },
            onSlideAfter: function () {
                var pr = _this.parents('.section_image').children('.progress_bar');
                pr.animate({width: "90%"}, 2000);
            }

        })
        _this.mouseenter(function () {
            timer = setTimeout(function () {
                var pr = _this.parents('.section_image').children('.progress_bar');
                pr.animate({width: "90%"}, 2000);
                _this.startAuto();
            }, 500);

        }).mouseleave(function () {
            clearTimeout(timer);
            _this.stopAuto();
            var pr = _this.parents('.section_image').children('.progress_bar');
            pr.animate({width: "0"}, 100);
        });
    });
});
