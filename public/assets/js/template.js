(function () {

function init() {
    $('.main_container').css({
        'top'    : $('header').outerHeight(),
        'height' : $('body').height() - $('header').outerHeight() - $('footer').outerHeight()
    });
    
        
    $('#cpt_banner, #actu_banner').click(function() {
        window.location = "/story?ep=1&source=banner";
    });
};

$(document).ready(init);

})();


