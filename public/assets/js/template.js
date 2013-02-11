(function () {

function init() {
    $('.main_container, #cgv').css({
        'top'    : $('header').outerHeight(),
        'height' : $('body').height() - $('header').outerHeight() - $('footer').outerHeight()
    });
    
        
    $('#cpt_banner, #actu_banner').click(function() {
        window.location = "/Voodoo_Connection/season1/episode1?utm_source=banner&utm_medium=banniere";
    });
};

$(document).ready(init);

})();


