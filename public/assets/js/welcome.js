(function () {

var elems = {};

var config = {
    expo_width: 684
};

var sections = {
    'accueil' : 0,
    'episode' : 250,
    'concept' : 670
}

function scrollUpdate(){
	var pos = elems.container.scrollTop();
	/*
	if(pos < 160) {
	    if(elems.btns.css('visibility') == 'hidden')
	        elems.btns.css('visibility', 'visible');
	    var opac = 1 - pos/160;
	    elems.btns.css('opacity', opac.toFixed(2));
	}
	else if(elems.btns.css('visibility') != 'hidden')
	    elems.btns.css('visibility', 'hidden');
	*/
    if(pos > 200 && pos < 600) {
        if(elems.simon.css('visibility') == 'hidden')
            elems.simon.css('visibility', 'visible');
        if(elems.band4.css('visibility') == 'hidden')
            elems.band4.css('visibility', 'visible');
        var opac = 1 - (pos-200)/400;
        elems.simon.css('opacity', opac.toFixed(2));
        elems.band4.css('opacity', opac.toFixed(2));
    }
    else if(pos >= 600) {
        if(elems.simon.css('visibility') != 'hidden')
            elems.simon.css('visibility', 'hidden');
        if(elems.band4.css('visibility') != 'hidden')
            elems.band4.css('visibility', 'hidden');
    }
}

function gotoSection(name) {
    if(!(typeof name == "string")) {
        // Desactive page reload
        if(current_section != "other") {
            name.preventDefault();
        }
    
        var name = $(this).attr('section');
        if(!name) return;
    }
    var offset = sections[name];
    if(isNaN(offset))
        offset = 0;
    elems.container.scrollTo({ top:offset, left:0 }, 600);
}

function titleContent(epid, title) {
    return '#'+epid+'  '+title;
}

function activeEpisode(id) {
    elems.ep_btns.removeClass('active');
    elems.ep_btns.eq(id).addClass('active');
    elems.ep_expos.css( 'left', -config.expo_width * id );
    var expo = elems.ep_expos.children('.expo:eq('+id+')');
    elems.ep_title.children('h2').text( titleContent(expo.data('episode'), expo.data('title')) );
    var dispo = expo.data('dispo').toUpperCase();
    elems.ep_title.children('.ep_play').text(dispo);
    if(dispo.match('VOIR'))
        elems.ep_title.add(elems.ep_expos).removeClass('indispo');
    else
        elems.ep_title.add(elems.ep_expos).addClass('indispo');
}

function init() {
    elems.container = $('.main_container').css('height', $('body').height() - $('header').outerHeight() - $('footer').outerHeight());
    elems.btns = $('#btns');
    elems.simon = $('#simon');
    elems.band4 = $('#bande4');
    elems.concept = $('#concept');
    
    $('#open_login2').click(showLogin);
    
    // Set anchor for menu
    $('#continue').click(gotoSection);
    $('#menu li a:lt(3)').parent().click(gotoSection);
    
    
    $('#back').parallax("50%", -0.5);
    $('#booktitle').parallax("50%", -0.9);
    $('#bookresume').parallax("50%", 2);
    $('#episodes_section').parallax("50%", 0.6);
    elems.btns.parallax("10%", -0.17);
    elems.concept.parallax("50%", 0.6);
    elems.simon.parallax("50%", -0.7);
    elems.band4.parallax("50%", -0.7);
    
	elems.container.bind('scroll', scrollUpdate);
	
	// Episodes list interaction
	elems.episodes = $('#episodes');
	elems.ep_expos = elems.episodes.children('#expos');
	elems.ep_title = elems.episodes.children('.ep_title');
	elems.ep_btns = elems.episodes.find('.ep_list ul li');
	elems.ep_btns.each(function(id) {
	    $(this).click(function() {
	        activeEpisode(id);
	    });
	});
	
	if(current_section) {
	    gotoSection(current_section);
	}
}

$(window).ready(init);

})();