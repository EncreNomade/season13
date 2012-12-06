function onYouTubePlayerReady(playerId) {
    ytplayer = document.getElementById("myytplayer");
    ytplayer.setPlaybackQuality('hd720');
}


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
    var expo = elems.ep_expos.children('.expo:eq('+id+')');
    elems.ep_title.children('h2').html( titleContent(expo.data('episode'), expo.data('title'), expo.data('price')) );
    
    // Availability
    var ddaystr = expo.data('dday');
    var today = new Date();
    
    elems.ep_play.data('id', expo.data('id'));
    if(dateReg.test(ddaystr)) {
        var arr = ddaystr.split("-", 3);
        var dday = new Date(arr[0], arr[1]-1, arr[2], 0, 0, 0, 0);
        // Available
        if(dday <= today) {
            elems.ep_play.text("VOIR L'EPISODE").prop('href', window.config.publicRoot+"story?ep="+expo.data('id'));
            elems.ep_title.add(elems.ep_expos).removeClass('indispo');
        }
        else {
            elems.ep_play.text("Disponible le "+arr[2]+"/"+arr[1]).prop('href', "");
            elems.ep_title.add(elems.ep_expos).addClass('indispo');
        }
    }
    else {
        elems.ep_play.text("Indisponible").prop('href', "");
        elems.ep_title.add(elems.ep_expos).addClass('indispo');
    }
}

var accessGateway = {
    'success' : false,
    
    'buyClicked' : function(ep, updateAction) {
        var ok = confirm("MERCI\nTu es l’un de nos premiers clients. Pour te remercier, nous t’offrons gratuitement le "+ep+"ème épisode de Voodoo Connection.");
        if(ok) {
            if(updateAction) {
                $.ajax({
                    url: window.config.publicRoot+updateAction,
                    type: 'POST',
                    async: false,
                    dataType : 'json',
                    data: {'epid': ep},
                });
            }
        
            window.open(window.config.publicRoot+'story?ep='+ep, '_newtab');
        }
    },
    
    'ep3': function(data) {
        $('#invitation_dialog h1').nextAll().remove();
        $('#invitation_dialog h1').after(data.form);
        var invitation = $('.center #invitation_dialog');
        invitation.addClass('show');

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
        $('#access_submit_btn3').click(function(e) {
            e.preventDefault();
            fuel_set_csrf_token($('#invitation_form').get(0));
            $('#invitation_form').submit();
            if(accessGateway.success) {
                accessGateway.success = false;
                window.open(window.config.publicRoot+'story?ep=3', '_newtab');
            }
        });
        
        $('#access_buy_btn3').unbind('click').click(function(e) {
            e.preventDefault();
            invitation.removeClass('show');
            accessGateway.buyClicked(3, 'accessaction/no_invitation');
        });
    },
    
    'ep4': function(data) {
        $('#like_dialog h1').nextAll().remove();
        $('#like_dialog h1').after(data.form);
        var like = $('.center #like_dialog');
        
        // Like button
        $('#like_dialog #like_section').html('<fb:like href="http://season13.com/" id="fb_like_form_btn" send="true" width="400" show_faces="true" font="lucida grande"></fb:like>');
        FB.XFBML.parse();
        
        FB.Event.subscribe('edge.create', function(response) {
            $.ajax({
                url: window.config.publicRoot+'accessaction/liked',
                type: 'POST'
            });
        
            //$('.center #like_dialog').removeClass('show');
            $('#like_dialog #like_section fb').nextAll().remove();
            $('#like_dialog #like_section').append("<p><input id='access_submit_btn4' type='submit' value=\"Accède à l'épisode 4\"></p>");
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
        $('#access_submit_btn4').live('click', function(e) {
            e.preventDefault();
            fuel_set_csrf_token($('#like_form').get(0));
            $('#like_form').submit();
            if(accessGateway.success) {
                accessGateway.success = false;
                window.open(window.config.publicRoot+'story?ep=4', '_newtab');
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
                    $('#like_dialog #like_section').html("<h5>Bravo! Tu as déjà aimé SEASON13 sur Facebook, nous t'offrons le 4ème épisode de Voodoo Connection.</h5><p><input id='access_submit_btn4' type='submit' value=\"Accède à l'épisode 4\"></p>").nextAll().remove();
                } else if (result.error) {
                    console.log('Error: '+result.error.message+'');
                }
            });
        });
        
        like.addClass('show');
        
        $('#access_buy_btn4').unbind('click').click(function(e) {
            e.preventDefault();
            $('.center #like_dialog').removeClass('show');
            accessGateway.buyClicked(4, 'accessaction/no_like');
        });
    }
};

function story_access_resp(data, epid) {
    if (!data.valid)
    {
        if(data.errorCode != null) {
            switch (data.errorCode) {
            case 201:
                if(showLogin) showLogin();
                break;
            
            case 303:
                accessGateway.ep3(data);
                break;
                
            case 304:
                accessGateway.ep4(data);
                break;
            
            case 202:
                accessGateway.buyClicked(epid, 'accessaction/buy_episode');
                data.errorMessage = "";
                break;
            
            case 102:
            case 101:
            default:
                break;
            }
        }
        if(data.errorMessage && data.errorMessage != "") alert(data.errorMessage);
    }
}
function playEpisode(e) {
    if(elems.ep_title.hasClass('indispo')) {
        e.preventDefault();
        return;
    }
    var epid = elems.ep_play.data('id');
    
    $.ajax({
        url: './base/story_access',
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

function addToCart(idProduct, idCombination, static_token, addedFromProductPage, callerElement, quantity, whishlist){
    var baseUri = "http://localhost:8888/prestashop/index.php";
    
	//disabled the button when adding to do not double add if user double click
	//$(callerElement).attr('disabled', true);

	//send the ajax request to the server
	$.ajax({
		type: 'POST',
		url: baseUri,
		async: true,
		cache: false,
		dataType: "json",
		data: 'controller=cart&add=1&ajax=true&qty=1&id_product=' + idProduct,
		success: function(jsonData,textStatus,jqXHR)
		{
			// add appliance to whishlist module
			if (whishlist && !jsonData.errors)
				WishlistAddProductCart(whishlist[0], idProduct, idCombination, whishlist[1]);

			// add the picture to the cart
			var $element = $(callerElement).parent().parent().find('a.product_image img,a.product_img_link img');
			if (!$element.length)
				$element = $('#bigpic');
			var $picture = $element.clone();
			var pictureOffsetOriginal = $element.offset();

			if ($picture.size())
				$picture.css({'position': 'absolute', 'top': pictureOffsetOriginal.top, 'left': pictureOffsetOriginal.left});

			var pictureOffset = $picture.offset();
			if ($('#cart_block').offset().top && $('#cart_block').offset().left)
				var cartBlockOffset = $('#cart_block').offset();
			else
				var cartBlockOffset = $('#shopping_cart').offset();

			// Check if the block cart is activated for the animation
			if (cartBlockOffset != undefined && $picture.size())
			{
				$picture.appendTo('body');
				$picture.css({ 'position': 'absolute', 'top': $picture.css('top'), 'left': $picture.css('left'), 'z-index': 4242 })
				.animate({ 'width': $element.attr('width')*0.66, 'height': $element.attr('height')*0.66, 'opacity': 0.2, 'top': cartBlockOffset.top + 30, 'left': cartBlockOffset.left + 15 }, 1000)
				.fadeOut(100, function() {
					ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
				});
			}
			else
				ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown)
		{
			alert("Impossible to add the product to the cart.\n\ntextStatus: '" + textStatus + "'\nerrorThrown: '" + errorThrown + "'\nresponseText:\n" + XMLHttpRequest.responseText);
			//reactive the button when adding has finished
			if (addedFromProductPage)
				$('body#product p#add_to_cart input').removeAttr('disabled').addClass('exclusive').removeClass('exclusive_disabled');
			else
				$(callerElement).removeAttr('disabled');
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
    
    // Title click to episodes
    $('#booktitle').click(function() {
        gotoSection('episode');
    });
    
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
	elems.ep_title = elems.episodes.children('.ep_title');
	elems.ep_play = elems.ep_title.children('.ep_play');
	elems.ep_btns = elems.episodes.find('.ep_list ul li');
	elems.add_to_cart = elems.episodes.find('#add_to_cart');
	elems.ep_btns.each(function(id) {
	    $(this).click(function() {
	        activeEpisode(id);
	    });
	});
	
	elems.ep_play.click(playEpisode);
	
	if(current_section) {
	    gotoSection(current_section);
	}
	
	elems.add_to_cart.click(function() {
	    addToCart( $('#product_id').val(), "", "", true, null, 1, null );
	});
	
	activeEpisode(0);
	
	// Youtube video
	var params = { allowScriptAccess: "always" };
    var atts = { id: "myytplayer" };
    swfobject.embedSWF("http://www.youtube.com/v/lwuMe5fzeyU?enablejsapi=1&playerapiid=ytplayer&version=3&rel=0", "ytapiplayer", "420", "236", "8", null, null, params, atts);
}

$(window).ready(init);

})(window);