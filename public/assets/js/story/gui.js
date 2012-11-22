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
                //console.log("Fail to define the setter function of "+variable);
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
    this.back = $("<img class='background' src='./assets/img/season13/ui/slider_back.png'/>");
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



gui.openhideMenu = function(e) {
    e.stopPropagation();
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
    if(!gui.center.hasClass('show')) gui.center.addClass('show');
    if(!gui.pref.hasClass('show')) {
        gui.pref.siblings().removeClass('show');
        
        gui.pref.addClass('show');
        
        if(window.mse) {
            mse.root.pause();
            gui.updatePlayPauseIcon();
        }
    }
}

gui.openAuthorBio = function() {
    if(!gui.center.hasClass('show')) gui.center.addClass('show');
    if(!gui.author_bio.hasClass('show')) {
        gui.author_bio.siblings().removeClass('show');
        
        gui.author_bio.addClass('show');
        
        if(window.mse) {
            mse.root.pause();
            gui.updatePlayPauseIcon();
        }
    }
}

gui.openCredits = function() {
    if(!gui.center.hasClass('show')) gui.center.addClass('show');
    if(!gui.credits.hasClass('show')) {
        gui.credits.siblings().removeClass('show');
        
        gui.credits.addClass('show');
        
        if(window.mse) {
            mse.root.pause();
            gui.updatePlayPauseIcon();
        }
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

gui.updatePlayPauseIcon = function() {
    if(mse.root.inPause) {
        $('#ctrl_playpause').html('<img src="'+config.publicRoot+'assets/img/season13/ui/wheel_play.png"/>');
    }
    else $('#ctrl_playpause').html('<img src="'+config.publicRoot+'assets/img/season13/ui/wheel_pause.png"/>');
}






gui.openComment = function(){
    if(!gui.center.hasClass('show')) gui.center.addClass('show');
    if(!gui.comment.hasClass('show')) {
        gui.comment.addClass('show');
        gui.comment.siblings().removeClass('show');
        
        mse.root.pause();
        gui.updatePlayPauseIcon();
        
        if(gui.userComments.children('li').length == 0) {
            gui.updateUsersComments(0);
        }
    }
}
gui.closeComment = function() {
    gui.comment_loading.removeClass('show');
    gui.comment_menu.children('#commentImg').remove();
    gui.comment_content.val('');
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
            gui.comment_loading.removeClass('show');
            
            var msg = null;
            if(fbapi.user && posted.fbpostid != "0") // the post is on facebook
                msg = $('<p>Ton message a bien été posté sur SEASON13 et sur Facebook. <a href="'+fbapi.user.link+'" target="_blank">Voir.</a></p>');
            else 
                msg = $('<p>Ton message a bien été posté.</p>')
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
        gui.comment_loading.removeClass('show');
        msgCenter.send('Une erreur est survenue. Lors de l\'envoie ou la recupération du commentaire.');
    }
    
    if(fbapi.user)
        return fbapi.post(imgUrl, msg, position, postSuccess, errorPost);
        
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
$(document).ready(function() {
    initMseConfig();
    
    // Save variables
    gui.menu = $('#menu');
    gui.center = $('#center')
    gui.pref = $('#preference');
    gui.author_bio = $('#author_bio');
    gui.credits = $('#credits');
    gui.controler = $('#controler');
    gui.comment = $('#comment');
    gui.comment_menu = $('#comment_menu');
    gui.comment_content = $('#comment_content');
    gui.comment_loading = gui.comment.children('.loading');
    gui.userComments = $('#comment_list');
    gui.uploader = $('#upload_container');
    gui.uploadForm = $('#imageuploadform');
    gui.speedup = $('#controler #ctrl_speedup');
    gui.slowdown = $('#controler #ctrl_slowdown');
    gui.commentbtn = $('#controler #ctrl_comment');
    gui.fblike = $('#controler #ctrl_like');
    gui.currPlayState = true;
    
    // Init scriber
    if(gui.scriber) gui.scriber.init();
    
    // General Interaction
    // Close the preference panel or the comment panel
    gui.center.children().children('.close').click(function() {
        $(this).parent().removeClass('show');
        mse.root.play();
        gui.updatePlayPauseIcon();
        
        var hasShownChild = false;
        gui.center.children().each(function() {
            if($(this).hasClass('show'))
                hasShownChild = true;
        });
        if(!hasShownChild)
            gui.center.removeClass('show');
    });
    gui.comment.children('.close').click(gui.closeComment);

    $('header .right').click(gui.openhideMenu);

    $('#btn_param').click(gui.openPref);
    gui.audioctrl = new gui.Slider(200, 100, gui.pref.children('p:first'), 50);
    gui.speedctrl = new gui.Slider(200, 10, gui.pref.children('p:eq(1)'), 5);
    gui.audioctrl.jqObj.css('left', 70);
    gui.speedctrl.jqObj.css('left', 70);
    if(window.mse) {
        // Observer to audio
        gui.audioctrl.observe('value', new Callback(mse.src.setVolume, mse.src));
// Speed observation a little bit strange, because there are two models
        mse.ArticleLayer.prototype.observe('speedLevel', new Callback(function(level) {
                gui.speedctrl.setvalue(level);
            }, null));
        gui.speedctrl.observe('value', new Callback(function(level) {
                mse.ArticleLayer.prototype.speedLevel = level;
            }, null));
    }
        
    // Author bio and credits
    $('#btn_author').click(gui.openAuthorBio);
    $('#btn_credits').click(gui.openCredits);
    
    if(window.mse) {
        // Controler activation
        gui.controler.children('#circle').click(function() {
            // Show or hide the controler btns
            var lis = gui.controler.find('li');
            if(lis.eq(1).hasClass('active')) {
                lis.removeClass('active');
                // Show the config image on circle
                $(this).removeClass('active');
            }
            else {
                lis.addClass('active');
                // Hide the config image on circle for showing other informations
                $(this).addClass('active');
            }
        });
    /*    gui.controler.mouseout(function() {
            gui.controler.find('li').removeClass('active');
        });*/
    
        // Controler interaction
        var flash_info = gui.controler.children('#circle').children('span');
        var timer;
        $('#ctrl_playpause').click(function() {
            if(mse.root.inPause) mse.root.play();
            else mse.root.pause();
            gui.currPlayState = !mse.root.inPause;
            gui.updatePlayPauseIcon();
        });
        gui.speedup.click(function() {
            var v = mse.ArticleLayer.prototype.speedLevel + 1;
            mse.ArticleLayer.prototype.setspeedLevel(v);
            flash_info.text(v);
            if(timer) clearTimeout(timer);
            flash_info.animate({opacity: 1}, 300);
            timer = setTimeout(function() {
                flash_info.animate({opacity: 0}, 300);
            }, 800);
        });
        gui.slowdown.click(function() {
            var v = mse.ArticleLayer.prototype.speedLevel - 1;
            mse.ArticleLayer.prototype.setspeedLevel(v);
            flash_info.text(v);
            if(timer) clearTimeout(timer);
            flash_info.animate({opacity: 1}, 300);
            timer = setTimeout(function() {
                flash_info.animate({opacity: 0}, 300);
            }, 800);
        });
        $('#ctrl_like').click(function() {
            fbapi.like();
        });
    
    
        // Open Comment
        gui.commentbtn.click(gui.openComment);
        
        // Comment like action
        gui.userComments.on('click', '.comment_fblike', fbapi.commentLike);
        
        // Comment capture screen
        gui.comment_menu.children('#btn_capture_img').click(function() {
            gui.comment.removeClass('show');
            mse.root.startCapture(new Callback(gui.scriber.showWithImg, gui.scriber));
        });
        
        // Comment Image Uploader
        gui.comment_menu.children('#btn_upload_img').click(gui.openhideUploader);
        gui.uploader.click(function(e) {e.stopPropagation();});
        
        // Prepare Options Object for upload form
        var options = {
            type :      'POST',
            url :       config.restUploadPath+'create_img', 
            dataType :  'json',
            success :   function(res) {
                gui.comment_loading.removeClass('show');
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
                gui.comment_loading.removeClass('show');
                gui.uploadForm.get(0).reset();
                gui.openhideUploader();
                msgCenter.send("Erreur de téléchargement");
            }
        };
        // Prepare ajax form
        gui.uploadForm.ajaxForm(options);
        // Upload interaction
        $('#imageuploadform #upload_btn').click(function() {
            if(gui.comment_menu.children('#commentImg').length > 0) {
                var ok = confirm("Tu vas remplacer l'image précédemment téléchargée, sûr?");
                if(!ok) return;
            }
    
            gui.uploadForm.submit();
            gui.comment_loading.addClass('show');
        });
        
        // Share process
        // Post
        gui.comment_menu.children('#btn_share').click(function(){
            // Check image source existance and its type
            var img = gui.comment_menu.children('#commentImg').children('img');
            var imgSrc = img.prop('src');
            var srcType = img.attr('type');
            imgSrc = (!imgSrc || imgSrc.trim() == "") ? false : imgSrc;
            var msg = gui.comment_content.val();
            if(!imgSrc && msg == ''){
                msgCenter.send('Ton message est vide.')
                return;
            }
            
            //re init the comment form
            img.parent().remove();
            gui.comment_content.val('');
            
            gui.comment_loading.addClass('show');
            
            // Upload image if needed
            if(imgSrc && srcType == "base64") {
                var postdata = {'imgData64': imgSrc};
                if(fbapi.user) postdata.fbComment = true;
                $.ajax({
                    'type' : 'POST',
                    'url' : config.restUploadPath+'create_drawing', 
                    'dataType' : 'json',
                    'data' : postdata, 
                    success : function(data){
                        if(data.success) {
                            imgSrc = data.path;
                            gui.postComment(imgSrc, msg);
                        }
                        else {
                            gui.comment_loading.removeClass('show');
                            if(data.errorMessage) msgCenter.send(data.errorMessage);
                        }
                    },
                    error : function(res) {
                        gui.comment_loading.removeClass('show');
                        msgCenter.send("Erreur de téléchargement");
                    }
                });
            }
            else gui.postComment(imgSrc, msg);
        });
    }
});