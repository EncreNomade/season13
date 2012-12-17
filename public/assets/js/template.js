(function () {

function init() {
    $('.main_container').css({
        'top'    : $('header').outerHeight(),
        'height' : $('body').height() - $('header').outerHeight() - $('footer').outerHeight()
    });
    
        
    $('#cpt_banner, #actu_banner').click(function() {
        window.location = "/Voodoo_Connection/season1/episode1?source=banner";
    });
};

$(document).ready(init);

})();


