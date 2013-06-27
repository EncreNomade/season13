(function (window) {

var elems = {};

var dateReg = /^\d{4}-\d{2}-\d{2}$/;

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
            if(!data.valid) {
                e.preventDefault();
                story_access_resp(data, epid);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown)
        {
            e.preventDefault();
            alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
        }
    });
}

function init() {
	// Play episode for request access
	$('.expo a').click(playEpisode);
}

$(window).ready(init);

})(window);