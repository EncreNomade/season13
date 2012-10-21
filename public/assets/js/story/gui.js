// Mini MVC architecture implemented with Observer pattern
var mmvc = (function(){
    // Observe function for model object
    var observe = function(variable, callback) {
        // Add observer callback into the listeners list indexed with variable name
        this._mmvclisteners[variable].push(callback);
    };
    
    // Notify function for model object, this function is called automatically by variable setter function
    var notify = function(variable, value) {
        // Invoke all listeners' callback
        var ls = this._mmvclisteners[variable];
        for(var i = 0; i < ls.length; ++i)
            ls[i].invoke(value);
    };
    
    var addObservableVars = function(vars) {
        // vars must be an Array of variables' name
        if(!(vars instanceof Array)) return;
        
        for(var i = 0; i < vars.length; ++i) {
            var variable = vars[i];
            // Setter function existe already, ignore this variable, in all case, notify function can be called manully after a modification of variable
            if(this['set'+variable]) {
                console.log("Fail to define the setter function of "+variable);
                // Initialization of listeners array
                if(!this._mmvclisteners[variable]) this._mmvclisteners[variable] = [];
                continue;
            }
            
            // Initialization of listeners array
            if(!this._mmvclisteners[variable]) this._mmvclisteners[variable] = [];
            // Basic setter function is constructed with 'set' + variable name
            eval("this.set"+variable+" = function(value) {this."+variable+" = value; this.notify('"+variable+"', value);}");
        }
    };
    
    return {
        // This function can make a javascript Object a mmvc model, in which some variable predefined can be observed by any Callback object( which can simulate an internal function invokation environment of an object )
        makeModel: function(model, vars) {
            // Model must be an Object
            if(!(model instanceof Object)) 
                return;
                
            // Check existance of notify and observe function in model
            if(model.notify || model.observe || model.addObservableVars) {
                console.error("Model has his own observe, notify and/or addObservableVars method");
                return;
            }
            
            // Init listeners' list, observe and notify function for model
            model._mmvclisteners = {};
            model.observe = observe;
            model.notify = notify;
            model.addObservableVars = addObservableVars;
            
            // Config setter function for variables
            model.addObservableVars(vars);
        }
    };
}());


gui = {};


// Slider class
gui.Slider = function(w, level, parent, val) {
    // DOM structure
    this.jqObj = $("<div class='slider'></div>");
    this.line = $("<div class='line'></div>");
    this.btn = $("<div class='ctrlbtn'></div>");
    this.back = $("<img class='background' src='./assets/img/ui/slider_back.png'/>");
    this.jqObj.append(this.back).append(this.line).append(this.btn);
    
    if(!isNaN(w)) this.jqObj.css('width', w);
    
    // Attributes
    this.width = this.jqObj.width() - this.btn.width();;
    this.level = isNaN(level) ? 100 : level;
    this.step = this.width / (this.level-1);
    this.value = 0;
    this.ondrag = false;
    
    // Add to dom
    this.appendTo(parent);
    
    // Callbacks
    this.dragStartHandlerCB = new Callback(this.dragStartHandler, this);
    this.draggingHandlerCB = new Callback(this.draggingHandler, this);
    this.moveBtnCB = new Callback(this.moveBtn, this);
    
    // MMVC for value and observed by ui
    mmvc.makeModel(this, ['value']);
    this.observe('value', this.moveBtnCB);
    if(isNaN(val)) val = 0;
    this.setvalue(val);
    
    this.btn.mseInteraction().mseInteraction('addListener', 'gestureSingle', this.dragStartHandlerCB, true);
    this.back.mseInteraction().mseInteraction('addListener', 'gestureSingle', this.draggingHandlerCB, true);
};
gui.Slider.prototype = {
    constructor: gui.Slider,
    appendTo: function(parent) {
        if( this.jqObj && (parent instanceof jQuery) ) {
            parent.append(this.jqObj);
            // Vertical align
            this.jqObj.css({'top': (parent.height() - this.jqObj.height())/2});
            return this.jqObj;
        }
        else return null;
    },
    
    moveBtn: function(l) {
        var off = l*this.step-9;
        if(off < 0) off = 0;
        this.btn.css('left', off);
        this.line.css('width', off);
    },
    dragStartHandler: function(e) {
        if(e.type == "gestureStart") this.startDrag(e);
        else if(e.type == "gestureUpdate") this.dragging(e);
        else if(e.type == "gestureEnd") this.endDrag(e);
    },
    draggingHandler: function(e) {
        if(e.type == "gestureUpdate") this.dragging(e);
        else if(e.type == "gestureEnd") this.endDrag(e);
    },
    startDrag: function(e) {
        this.ondrag = true;
    },
    dragging: function(e) {
        if(this.ondrag) {
            var offset = e.windowX - this.back.offset().left;
            if(offset > this.width) offset = this.width;
            else if(offset < 0) offset = 0;
            var l = Math.ceil( offset / this.step );
            this.setvalue(l);
        }
    },
    endDrag: function(e) {
        this.ondrag = false;
    }
};



gui.openhideMenu = function() {
    // Hide
    if(gui.menu.hasClass('active')) {
        gui.menu.removeClass('active');
        $('#icon_menu').removeClass('active');
        $('#switch_menu').removeClass('active');
    }
    else {
        gui.menu.addClass('active');
        $('#icon_menu').addClass('active');
        $('#switch_menu').addClass('active');
    }
}

gui.openPref = function() {
    if(!gui.pref.hasClass('show')) {
        gui.pref.addClass('show');
    }
}

gui.openhideUploader = function(e) {
    if(e) e.stopPropagation();
    if(!gui.uploader.hasClass('show')) {
        gui.uploader.addClass('show');
        gui.comment.click(gui.openhideUploader);
    }
    else {
        gui.comment.unbind('click', gui.openhideUploader);
        gui.uploader.removeClass('show');
    }
}





gui.fb = {};
gui.fb.user = null; // initiated in gui.fb.connect or init
gui.fb.checkConnect = function(){
    FB.getLoginStatus(function(response){ // test login
      if (response.status === 'connected') {
        var uid = response.authResponse.userID;
        FB.api('/me',function(u){
            gui.fb.user = u;
        });
      } 
      else if (response.status === 'not_authorized') {//the user is logged in to Facebook, but has not authenticated your app
          gui.fb.user = false;
      } 
      else { // the user isn't logged in to Facebook.
          gui.fb.user = false;
      }
    });
};
gui.fb.init = function() {
    if(!gui.fb.user) return;
    $('.comment_fblike').each(function() {
        var btn = $(this);
        var postid = btn.data('postid');
        // Query: SELECT user_id FROM like WHERE object_id=postid AND user_id=gui.fb.user.id
        var query = 'SELECT%20user_id%20FROM%20like%20WHERE%20object_id%3D'+postid+'%20AND%20user_id%3D'+gui.fb.user.id;
        var url = '/fql?q='+query;
        FB.api(url, 'get', function(result) {
            if (!result || !result.data) {
                return;
            } else if (result.data.length > 0) {
                btn.text('J\'aime plus');
            } else if (result.error) {
                console.log('Error: '+result.error.message+'');
            }
        });
    });
}
gui.fb.like = function(){
    FB.getLoginStatus(function(response){
        if (response.status === 'connected') { // do only if connected
            FB.api('/me/og.likes', 'post', { object:location.href }, function(res) {
                if (!res || res.error) {
                    if(res.error.code == 3501) { // already like it !
                        msgCenter.send('Tu aimes déjà cette page');
                        return;
                    }
                    // console.error(res);
                    if(confirm("Une erreur s'est produite lors de l'envoie. Réessayes ?"))
                        gui.fb.connect(gui.fb.like);
                } 
                else {
                    var msg = $('<p>Tu as aimé cette page sur Facebook. </p>');
                    if(gui.fb.user)
                        msg.append('<a href="'+gui.fb.user.link+'">Voir.</a>');
                    msgCenter.send(msg);
                }
            });
        }
        else if(confirm("Il faut être connecté à Facebook pour poster un like. Tu veux te connecter?")){
            // not connected and
            gui.fb.connect(gui.fb.like);
        }
    });
}
gui.fb.post = function(imgUrl, msg, position, successCB, failCB){
    if(imgUrl){
        if(!msg) msg = "";
        var postData = {'url': imgUrl, 'message': msg};
        
        FB.api('me/photos', 'POST', postData, function(res){ // post the img to fb
            if(!res.id) return failCB(res);
            FB.api(res.id, function(fbImgObj){ // get the img url
                if(!fbImgObj.source) return failCB(fbImgObj);
                var postData = {
                    'imgUrl': fbImgObj.source, 
                    'message': msg, 
                    'fbID': fbImgObj.id, 
                    'position': position, 
                    'ep': mse.configs.epid,
                    'fbUserID': fbImgObj.from.id
                };
                $.post('./13comments/comment', postData, successCB, 'json');
            });
        });
    }
    else if(msg){
        FB.api('/me/feed', 'POST', {'message': msg}, function(obj){
            if(!obj.id) return failCB(obj);
            var postData = {
                'imgUrl': '', 
                'message': msg, 
                'fbID':obj.id, 
                'position': position, 
                'ep': mse.configs.epid,
                'fbUserID': obj.id.split('_')[0]  // obj.id = "<fbuserID>_<postID>"
            }; 
            $.post('./13comments/comment', postData, successCB, 'json');
        });
    }
};

gui.fb.commentLike = function() {
    if( !gui.fb.user ) return;
    var btn = $(this);
    var postid = btn.data('postid');
    //var like = (btn.text() != "J\'aime plus");
    // Like post
    //if(like) {
        FB.api('/'+postid+'/likes', 'post', function(result) {
            if (result === true) {
                msgCenter.send('You like the post: '+postid);//btn.text('J\'aime plus');
            } else if (result.error) {
                console.log('Error: '+result.error.message+'');
            }
        });
    /*}
    else {
        FB.api('/'+postid+'/likes', 'DELETE', function(result) {
            if (result === true) {
                btn.text('J\'aime');
            } else if (result.error) {
                console.log('Error: '+result.error.message+'');
            }
        });
    }*/
}





gui.openComment = function(){
    gui.comment.addClass('show');
    
    if(gui.userComments.children('li').length == 0) {
        gui.updateUsersComments(0);
    }
}
function constructDomComment(comment) {
    // create a new javascript Date object based on the timestamp
    // multiplied by 1000 so that the argument is in milliseconds, not seconds
    var date = new Date(comment.date*1000);
    // Format date
    var formattedDate = date.getDate()+"/"+(date.getMonth()+1);

    var str = '<li>';
    str +=        '<img class="comment_avatar" src="'+comment.avatar+'"/>';
    str +=        '<div class="comment_body">';
    str +=            '<div class="arrow"></div>';
    str +=            '<h5>'+comment.content+'</h5>';
    str +=            (comment.image!='' ? '<img class="comment_image" src="'+comment.image+'"/>' : '');
    str +=            '<div class="comment_footer">';
    str +=                '<h5>De '+comment.user+', le '+formattedDate+'</h5>';
    if(comment.fbpostid) {
        str +=            '<a class="comment_fblike" data-postid="'+comment.fbpostid+'"></a>';
        str +=            '<a class="comment_fblink" href="http://www.facebook.com/'+comment.fbpostid+'" target="_blank"></a>';
    }
    str +=            '</div>';
    str +=        '</div>';
    str +=    '</li>';
    return $(str);
}
gui.updateUsersComments = function(start) {
    start = isNaN(start) ? gui.userComments.children('li').length : start;
    $.ajax({
        type: 'GET', 
        url: './13comments/comment_by_ep', 
        data: {'start': start, 'ep': mse.configs.epid}, 
        dataType: 'json', 
        success: function(data, textStatus, jqXHR) {
            if(!data) {
                var error = $('<h5>Echec de récupérer les commentaires</h5>');
                gui.userComments.children('#renew_comments').before(error);
                error.delay(1000).fadeOut(400, function() {
                    error.remove();
                });
            }
            else if(data.success == false) {
                if(data.errorMessage) msgCenter.send(data.errorMessage);
            }
            else if(data.success == true && $.isArray(data.comments)) {
                var comments = data.comments;
                if(comments.length == 0)
                    gui.userComments.children('#renew_comments').text('Plus d\'anciens commentaires').unbind('click');
                else {
                    var domcomments = $("");
                    for(var i = 0; i < comments.length; ++i) {
                        var comment = comments[i];
                        domcomments = domcomments.add( constructDomComment(comment) );
                    }
                    gui.userComments.children('#renew_comments').before(domcomments);
                }
            }
            else {
                var error = $('<h5>Echec de récupérer les commentaires</h5>');
                gui.userComments.children('#renew_comments').before(error);
                error.delay(1000).fadeOut(400, function() {
                    error.remove();
                });
            }
        }
    });
}

gui.setCommentImage = function(src, type) {
    if(type != "base64" && type != "path") type = "path";
    
    var img = gui.comment_menu.children('#commentImg');
    // Reattach the comment image
    if(img.length == 0) {
        img = $('<li id="commentImg"><img class="preview" src="'+src+'"/></li>');
        gui.comment_menu.append(img);
    }
    else img.children('img').prop('src', src);
    
    img.children('img').attr('type', type);
    img.hide().fadeIn(500);
};

gui.postComment = function(imgUrl, msg){
    var position = JSON.stringify(mse.root.getProgress());
    function postSuccess(data){
        if(data) {
            var posted = data.posted;
            
            gui.userComments.prepend(constructDomComment(posted));
            gui.userComments.scrollTop(-gui.userComments.position().top);
            // Hide loading
            gui.comment.children('.loading').removeClass('show');
            
            var msg = null;
            if(gui.fb.user && posted.fbpostid != "0") // the post is on facebook
                msg = $('<p>Votre message a bien été posté ici et sur Facebook. <a href="'+gui.fb.user.link+'" target="_blank">Voir.</a></p>');
            else 
                msg = $('<p>Votre message a bien été posté.</p>')
            msgCenter.send(msg);
        } else {
            errorPost(data, e);
        }
    }
    function errorPost(){
        if(config.readerMode == "debug") {
            console.log('ERROR WHILE POSTING COMMENT : ');
            console.log(arguments);
        }
        gui.comment.children('.loading').removeClass('show');
        msgCenter.send('Une erreur est survenue. Lors de l\'envoie ou la recupération du commentaire.');
    }
    
    if(gui.fb.user)
        return gui.fb.post(imgUrl, msg, position, postSuccess, errorPost);
        
    if(imgUrl){
        if(msg == null) msg = "";
        $.post('./13comments/comment', {'imgUrl': imgUrl, 
                                        'message': msg, 
                                        'position': position, 
                                        'fbID':'', 
                                        'ep': mse.configs.epid
                                        }, postSuccess, 'json');
    }
    else if(msg){
        $.post('./13comments/comment', {'imgUrl': '', 
                                        'message': msg, 
                                        'position': position, 
                                        'fbID':'', 
                                        'ep': mse.configs.epid
                                        }, postSuccess, 'json');
    }
};

// Initialisation
$(window).load(function() {
    initMseConfig();
    
    // Save variables
    gui.menu = $('#menu');
    gui.pref = $('#preference');
    gui.controler = $('#controler');
    gui.comment = $('#comment');
    gui.comment_menu = $('#comment_menu');
    gui.userComments = $('#comment_list');
    gui.uploader = $('#upload_container');
    gui.uploadForm = $('#imageuploadform');
    gui.speedup = $('#controler #ctrl_speedup');
    gui.slowdown = $('#controler #ctrl_slowdown');
    gui.commentbtn = $('#controler #ctrl_comment');
    gui.fblike = $('#controler #ctrl_like');
    
    // General Interaction
    $('.close').click(function() {$(this).parent().removeClass('show');});

    $('#icon_menu, #switch_menu').click(gui.openhideMenu);

    $('#btn_param').click(gui.openPref);
    gui.audioctrl = new gui.Slider(200, 100, gui.pref.children('p:first'), 50);
    gui.speedctrl = new gui.Slider(200, 16, gui.pref.children('p:eq(1)'), 8);
    gui.audioctrl.jqObj.css('left', 70);
    gui.speedctrl.jqObj.css('left', 70);
    // Observer to audio
    gui.audioctrl.observe('value', new Callback(mse.src.setVolume, mse.src));
// Speed observation a little bit strange, because there are two models
    mse.ArticleLayer.prototype.observe('speedLevel', new Callback(function(level) {
            gui.speedctrl.setvalue(level);
        }, null));
    gui.speedctrl.observe('value', new Callback(function(level) {
            mse.ArticleLayer.prototype.speedLevel = level;
        }, null));
    
    // Controler activation
    gui.controler.children('#circle').click(function() {
        var lis = gui.controler.find('li');
        if(lis.eq(1).hasClass('active'))
            lis.removeClass('active');
        else lis.addClass('active');
    });
/*    gui.controler.mouseout(function() {
        gui.controler.find('li').removeClass('active');
    });*/
    
    // Controler interaction
    $('#ctrl_playpause').click(function() {
        mse.currTimeline.playpause();
        if(mse.currTimeline.inPause) {
            $(this).html('<img src="'+config.publicRoot+'assets/img/ui/wheel_play.png"/>');
        }
        else $(this).html('<img src="'+config.publicRoot+'assets/img/ui/wheel_pause.png"/>');
    });
    $('#ctrl_speedup').click(function() {
        mse.ArticleLayer.prototype.setspeedLevel(mse.ArticleLayer.prototype.speedLevel - 1);
    });
    $('#ctrl_slowdown').click(function() {
        mse.ArticleLayer.prototype.setspeedLevel(mse.ArticleLayer.prototype.speedLevel + 1);
    });
    $('#ctrl_like').click(function() {
        gui.fb.like();
    });
    
    
    // Open Comment
    gui.commentbtn.click(gui.openComment);
    
    // Comment like action
    gui.userComments.on('click', '.comment_fblike', gui.fb.commentLike);
    
    // Comment Image Uploader
    gui.comment_menu.children('#btn_upload_img').click(gui.openhideUploader);
    gui.uploader.click(function(e) {e.stopPropagation();});
    
    // Prepare Options Object for upload form
    var options = {
        type :      'POST',
        url :       config.restUploadPath+'create_img', 
        dataType :  'json',
        success :   function(res) {
            gui.comment.children('.loading').removeClass('show');
            gui.uploadForm.get(0).reset();
            gui.openhideUploader();
            if(res.success) {
                gui.setCommentImage(res.path, 'path');
            }
            else {
                if(res.errorMessage) msgCenter.send(res.errorMessage);
            }
        },
        error :     function(res) {
            gui.comment.children('.loading').removeClass('show');
            gui.uploadForm.get(0).reset();
            gui.openhideUploader();
            msgCenter.send("Erreur de téléchargement");
        }
    };
    // Prepare ajax form
    gui.uploadForm.ajaxForm(options);
    // Upload interaction
    $('#imageuploadform #upload_btn').click(function() {
        if(gui.comment_menu.children('.preview').length > 0) {
            var ok = confirm("Tu vas remplacer l'image précédemment téléchargée, sûr?");
            if(!ok) return;
        }

        gui.uploadForm.submit();
        gui.comment.children('.loading').addClass('show');
    });
    
    // Share process
    // Post
    gui.comment_menu.children('#btn_share').click(function(){
        // Check image source existance and its type
        var img = gui.comment_menu.children('#commentImg').children('img');
        var imgSrc = img.prop('src');
        var srcType = img.attr('type');
        imgSrc = (!imgSrc || imgSrc.trim() == "") ? false : imgSrc;
        var msg = $('#comment_content').val();
        if(!imgSrc && msg == ''){
            msgCenter.send('Tu dois envoyer au moins du texte ou une image.')
            return;
        }
        
        //re init the comment form
        img.parent().remove();
        $('#comment_content').val('');
        
        gui.comment.children('.loading').addClass('show');
        
        // Upload image if needed
        if(imgSrc && srcType == "base64") {
            var postdata = {'imgData64': imgSrc};
            if(gui.fb.user) postdata.fbComment = true;
            $.ajax({
                'type' : 'POST',
                'url' : config.restUploadPath+'create_drawing', 
                'dataType' : 'json',
                'data' : postdata, 
                success : function(data){
                    if(res.success) {
                        imgSrc = res.path;
                        gui.postComment(imgSrc, msg);
                    }
                    else {
                        gui.comment.children('.loading').removeClass('show');
                        if(res.errorMessage) msgCenter.send(res.errorMessage);
                    }
                },
                error : function(res) {
                    gui.comment.children('.loading').removeClass('show');
                    msgCenter.send("Erreur de téléchargement");
                }
            });
        }
        else gui.postComment(imgSrc, msg);
    });
});