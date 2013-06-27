(function (window) {

var elems = {};

var config = {
    expo_width: 684
};

var sections = {
    'accueil' : 0,
    'episode' : 250
}

var dateReg = /^\d{4}-\d{2}-\d{2}$/;

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
    }*/
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

function titleContent(epid, title, price) {
    return '#'+epid+'  '+title+'<span>'+(price == "" ? "" : price+"€")+'</span>';
}

function activeEpisode(id) {
    elems.ep_btns.removeClass('active');
    elems.ep_btns.eq(id).addClass('active');
    elems.ep_expos.css( 'left', -config.expo_width * id );
}

var accessGateway = {
    'success' : false,
    
    'ep3': function(data) {
        $('#access_dialog').attr('class', 'dialog invitation_dialog');
        $('#access_dialog h1').text('Invitation');
        $('#access_dialog .sep_line').nextAll().remove();
        $('#access_dialog .sep_line').after(data.form);
        var invitation = $('#access_dialog');
        
        FB.XFBML.parse();
        
        // Send event
        FB.Event.subscribe('message.send', function(response) {
            $.ajax({
                url : window.config.publicRoot+'accessaction/invitation_fb',
                type : 'POST',
                dataType : 'json',
                success :   function(res) {
                    if(res && res.valid && res.valid === true) {
                        accessGateway.success = true;
                    }
                    else if(res && res.errorMessage) {
                        alert(res.errorMessage);
                    }
                    else {
                        alert('Une erreur de connexion est survenue.');
                    }
                },
                error :     function(res) {
                    alert('Une erreur de connexion est survenue.');
                }
                
            });
        
            $('#access_dialog #fbsend_section').nextAll().remove();
            $('#access_dialog #fbsend_section').append("<p><input id='send_fb_btn' type='submit' value=\"Accède à l'épisode 3\"></p>");
            
            $('#send_fb_btn').click(function(e) {
                e.preventDefault();
                if(accessGateway.success) {
                    accessGateway.success = false;
                    invitation.removeClass('show');
                    window.open(window.config.publicRoot+'Voodoo_Connection/season1/episode3', '_newtab');
                }
            });
        });
        
        // Prepare Options Object for form
        var options = {
            type :      'POST',
            async :     false,
            dataType :  'json',
            success :   function(res) {
                if(res && res.valid && res.valid === true) {
                    invitation.removeClass('show');
                    accessGateway.success = true;
                }
                else if(res && res.errorMessage) {
                    alert(res.errorMessage);
                }
                else {
                    alert('Une erreur de connexion est survenue.');
                 }
            },
            error :     function(res) {
                alert('Une erreur de connexion est survenue.');
            }
        };
        // Prepare ajax form
        $('#invitation_form').ajaxForm(options);
        $('#send_mail_btn').click(function(e) {
            e.preventDefault();
            fuel_set_csrf_token($('#invitation_form').get(0));
            $('#invitation_form').submit();
            if(accessGateway.success) {
                accessGateway.success = false;
                window.open(window.config.publicRoot+'Voodoo_Connection/season1/episode3', '_newtab');
            }
        });

        invitation.addClass('show');
        
        $('#access_buy_btn3').unbind('click').click(function(e) {
            invitation.removeClass('show');
        });
    },
    
    'ep4': function(data) {
        $('#access_dialog').attr('class', 'dialog like_dialog');
        $('#access_dialog h1').text('J\'aime SEASON13 sur Facebook');
        $('#access_dialog .sep_line').nextAll().remove();
        $('#access_dialog .sep_line').after(data.form);
        var like = $('#access_dialog');
        
        // Like button
        //$('#access_dialog #like_section').html();
        FB.XFBML.parse();
        
        FB.Event.subscribe('edge.create', function(response) {
            $.ajax({
                url: window.config.publicRoot+'accessaction/liked',
                type: 'POST'
            });
        
            //$('.center #like_dialog').removeClass('show');
            $('#access_dialog #like_section fb').nextAll().remove();
            $('#access_dialog #like_section').append("<p><input id='access_submit_btn4' type='submit' value=\"Accède à l'épisode 4\"></p>");
            
            $('#access_submit_btn4').click(function(e) {
                e.preventDefault();
                fuel_set_csrf_token($('#like_form').get(0));
                $('#like_form').submit();
                if(accessGateway.success) {
                    accessGateway.success = false;
                    window.open(window.config.publicRoot+'Voodoo_Connection/season1/episode4', '_newtab');
                }
            });
        });
        
        // Prepare Options Object for form
        var options = {
            type :      'POST',
            async :     false,
            dataType :  'json',
            success :   function(res) {
                if(res && res.valid && res.valid === true) {
                    like.removeClass('show');
                    accessGateway.success = true;
                }
                else if(res && res.errorMessage) {
                    alert(res.errorMessage);
                }
                else {
                    alert('Une erreur de connexion est survenue.');
                }
            },
            error :     function(res) {
                alert('Une erreur de connexion est survenue.');
            }
        };
        // Prepare ajax form
        $('#like_form').ajaxForm(options);
        $('#access_submit_btn4').click(function(e) {
            e.preventDefault();
            fuel_set_csrf_token($('#like_form').get(0));
            $('#like_form').submit();
            if(accessGateway.success) {
                accessGateway.success = false;
                window.open(window.config.publicRoot+'Voodoo_Connection/season1/episode4', '_newtab');
            }
        });
    
        fbapi.connect(function() {
            var user_id = fbapi.user.id;
            var query = 'SELECT%20user_id%20FROM%20url_like%20WHERE%20url%3D"http://season13.com/"%20AND%20user_id%3D'+user_id;
            var url = '/fql?q='+query;
            FB.api(url, 'get', function(result) {
                if (!result || !result.data) {
                    return;
                } else if (result.data.length > 0) {
                    $('#access_dialog #like_section').html("<h5>Bravo! Tu as déjà aimé SEASON13 sur Facebook, nous t'offrons le 4ème épisode de Voodoo Connection.<br/></h5><p><input id='access_submit_btn4' type='submit' value=\"Accède à l'épisode 4\"></p>").nextAll().remove();
                    
                    $('#access_submit_btn4').click(function(e) {
                        e.preventDefault();
                        fuel_set_csrf_token($('#like_form').get(0));
                        $('#like_form').submit();
                        if(accessGateway.success) {
                            accessGateway.success = false;
                            window.open(window.config.publicRoot+'Voodoo_Connection/season1/episode4', '_newtab');
                        }
                    });
                } else if (result.error) {
                    console.log('Error: '+result.error.message+'');
                }
            });
        });
        
        like.addClass('show');
        
        $('#access_buy_btn4').unbind('click').click(function(e) {
            $('.center #access_dialog').removeClass('show');
        });
    }
};

function story_access_resp(data, epid) {
    if (!data.valid)
    {
        if(data.errorCode != null) {
            switch (data.errorCode) {
            case 201:
                alert(data.errorMessage);
                if(showLogin) showLogin();
                break;
                
            case 302:
                alert(data.errorMessage);
                if(showSignup) showSignup();
                break;
            
            case 303:
                accessGateway.ep3(data);
                data.errorMessage = "";
                break;
                
            case 304:
                accessGateway.ep4(data);
                data.errorMessage = "";
                break;
            
            case 202:
            case 102:
            case 101:
            default:
                if(data.errorMessage && data.errorMessage != "") alert(data.errorMessage);
                break;
            }
        }
    }
}
function playEpisode(e) {
    if($(this).attr('href') != "#")
        return;
    
    var expo = $(this).parents('.expo');
    var epid = expo.data('id');
    
    $.ajax({
        url: window.config.publicRoot + 'base/story_access',
        type: 'GET',
        async: false,
        dataType: 'json',
        data: {'epid': epid},
        success: function(data, textStatus, XMLHttpRequest)
        {
            if (!data.valid) e.preventDefault();
            story_access_resp(data, epid);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
            e.preventDefault();
            alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
        }
    });
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
    $('#menu li a:lt(2)').parent().click(gotoSection);
    
    
    $('#back').parallax("50%", -0.5);
    $('#booktitle').parallax("50%", -0.9);
    $('#bookresume').parallax("50%", 2);
    $('#episodes_section').parallax("50%", 0.6);
    elems.btns.parallax("10%", -0.17);
    elems.concept.parallax("50%", 0.6);
    //elems.simon.parallax("50%", -0.7);
    //elems.band4.parallax("50%", -0.7);
    
	elems.container.bind('scroll', scrollUpdate);
	
	// Episodes list interaction
	elems.episodes = $('#episodes');
	elems.ep_expos = elems.episodes.children('#expos');
	elems.ep_play = elems.episodes.find('.ep_play');
	elems.ep_btns = elems.episodes.find('.ep_list ul li.ep_btn');
	elems.ep_btns.each(function(id) {
	    $(this).click(function() {
	        activeEpisode(id);
	    });
	});
	
	// Play episode for request access
	elems.ep_play.click(playEpisode);
	
	if(current_section) {
	    gotoSection(current_section);
	}
}

$(window).ready(init);

})(window);