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

gui.openControler = function(e) {
    gui.controler.css({'left':e.offsetX, 'top':e.offsetY});
    gui.controler.addClass('show');
}
gui.hideControler = function() {
    gui.controler.removeClass('show');
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
    
    $('#controler img').each(function(id) {
        var lis = $('#controler ul li');
        $(this).mouseenter({'id':id}, function(e) {
            lis.eq(e.data.id).addClass('hover');
        });
        $(this).mouseleave({'id':id}, function(e) {
            lis.eq(e.data.id).removeClass('hover');
        });
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


//eval(function(B,D,A,G,E,F){function C(A){return A<62?String.fromCharCode(A+=A<26?65:A<52?71:-4):A<63?'_':A<64?'$':C(A>>6)+C(A&63)}while(A>0)E[C(G--)]=D[--A];return B.replace(/[\w\$]+/g,function(A){return E[A]==F[A]?A:E[A]})}('Q 8=(4(){Q D={},A={},B=Ej,J=k;D.R=K(\'<W N="8"><BU></BU></W>\');D.h=D.R.5("BU");A.R=K(\'<W N="Ds"><Bt></Bt><BU></BU></W>\');A.h=A.R.5("BU");A.Bf=o;4 BM(K){K.BY("B0");}4 DI(K){K.9("B0");}4 DN(K){K.CE();L(D.h.5("BF").v==H){D.R.Bi();}}4 Bu(J,K){K=r(K)?H:D3.abs(K);Q A=Cs(4(){DI(J);},K),B=Cs(4(){DN(J);J=k;},K+C5);t[A,B];}4 DM(K){Cs(4(){BM(K);K=k;},BL);}Q E={BJ:A.R,Be:H,Bd:H,w:o};A.R.5("Bt").mousedown(4(J){L(!E.w){E.Be=J.Ca;E.Bd=J.Cb;E.w=j;E.BJ.BY("w");K(Co).bind("D7",C);}J.Cf();});Q C=4(K){L(E.w){Q J=K.Ca-E.Be,A=K.Cb-E.Bd,B={f:E.BJ.Da().f,y:DW(E.BJ.S("y"))};E.BJ.S({f:(B.f+J),y:(B.y-A)});E.Be=K.Ca;E.Bd=K.Cb;}};K(Co).mouseup(4(){L(E.w){E.w=o;E.BJ.9("w");K(Co).Bj("D7",C);}});Q F=T 4 BA(){},Ed={};F.BI=4(B,A){L(D.h.5("BF").v==H){D.R.D8("#i");}Q J=K("<BF></BF>");J.BC(B);D.h.Db(J);DM(J);L(A===H||A==="fixed"){t J;}A=r(A)?3000:A;a.EK(J,A);t J;};F.getList=4(){t D.h;};F.getMax=4(){t B;};F.EK=4(C,J){L(C.parents("#Ds").v===BL){C.CE();t;}J=r(J)?H:J;Q A=Bu(C,J);L(MseConfig.mobile){C.hover(4(){EC(A[H]);EC(A[BL]);},4(){A=Bu(C);});}D.h.5("BF").DG(4(J){L(J>=B){Bu(K(a));}});};F.getStaticBox=4(){t A.R;};F.EY=4(B,J){A.h.CC(" ");L(!B||B==""){B="Notifications";}A.R.5("Bt").CC(B);A.R.D8("#i");Q K=A.R.BP(H);K.CW.C0("f");K.CW.C0("y");K.CW.C0("n");L(EO J=="EZ"){L(!r(J.n)){A.R.S("n",J.n);}L(!r(J.y)){A.R.S("y",J.y);}L(!r(J.f)){A.R.S("f",J.f);}L(!r(J.CI)){A.R.S("CI",J.CI);}}A.Bf=j;};F.closeStaticBox=4(){A.h.CC(" ");A.R.Bi();A.Bf=o;};F.sendToStatic=4(B){L(!A.Bf){a.EY();}Q J=K("<BF></BF>");J.BC(B);A.h.Db(J);t J;};t F;})(),D9=(4(){Q 3=4(J,K){a.BG[J].push(K);},Ba=4(A,J){Q K=a.BG[A];CD(Q B=H;B<K.v;++B){K[B].invoke(J);}},BK=4(CB){L(!(CB DB Array)){t;}CD(Q Bx=H;Bx<CB.v;++Bx){Q 6=CB[Bx];L(a["DY"+6]){2.Y("Fail to define the setter 4 of "+6);L(!a.BG[6]){a.BG[6]=[];}continue;}L(!a.BG[6]){a.BG[6]=[];}eval("a.DY"+6+" = 4(s) {a."+6+" = s; a.Ba(\'"+6+"\', s);}");}};t{DE:4(J,K){L(!(J DB Object)){t;}L(J.Ba||J.3||J.BK){2.p("Model has his own 3, Ba and/or BK method");t;}J.BG={};J.3=3;J.Ba=Ba;J.BK=BK;J.BK(K);}};}()),P={};P.Bk=4(A,B,C,J){a.q=K("<W Br=\'EE\'></W>");a.Bo=K("<W Br=\'Bo\'></W>");a.Bp=K("<W Br=\'ctrlbtn\'></W>");a.B$=K("<Dq Br=\'background\' U=\'./UI/EE/slider_back.png\'/>");a.q.BC(a.B$).BC(a.Bo).BC(a.Bp);L(!r(A)){a.q.S("n",A);}a.n=a.q.n()-a.Bp.n();a.Dt=r(B)?C7:B;a.Cj=a.n/(a.Dt-BL);a.s=H;a.CF=o;a.Dy(C);a.EV=T 7(a.Dv,a);a.Dz=T 7(a.D1,a);a.D5=T 7(a.Dr,a);D9.DE(a,["s"]);a.3("s",a.D5);L(r(J)){J=H;}a.C8(J);a.Bp.B9().B9("DT","EP",a.EV,j);a.B$.B9().B9("DT","EP",a.Dz,j);};P.Bk.C1={constructor:P.Bk,Dy:4(K){L(a.q&&(K DB jQuery)){K.BC(a.q);a.q.S({Bn:(K.u()-a.q.u())/I});t a.q;}b{t k;}},Dr:4(J){Q K=J*a.Cj-El;L(K<H){K=H;}a.Bp.S("f",K);a.Bo.S("n",K);},Dv:4(K){L(K.e=="gestureStart"){a.EU(K);}b{L(K.e=="ET"){a.Cw(K);}b{L(K.e=="Dd"){a.CL(K);}}}},D1:4(K){L(K.e=="ET"){a.Cw(K);}b{L(K.e=="Dd"){a.CL(K);}}},EU:4(K){a.CF=j;},Cw:4(K){L(a.CF){Q A=K.windowX-a.B$.Da().f;L(A>a.n){A=a.n;}b{L(A<H){A=H;}}Q J=D3.ceil(A/a.Cj);a.C8(J);}},CL:4(K){a.CF=o;}};P.M={};P.M.d=k;P.M.checkConnect=4(){O.EJ(4(A){L(A.Bq==="C$"){Q J=A.authResponse.userID;O.V("/BQ",4(A){K.c("../z/BE.X",{CV:A.N},4(B){L(B.match("OK")){P.M.d=A;Cn{Q C=P.0.5(".x").5("#C9");C.BH("U","Cq://DC.B7.Bm/"+J+"/DA");}Cy(K){}P.M.Cx();}});});}b{L(A.Bq==="Ea"){P.M.d=o;}b{P.M.d=o;}}});};P.M.B1=4(K){P.M.BR=K;O.login(4(K){L(K.Bq=="C$"){O.V("/BQ",4(J){Q K=P.0.5(".x").5("#C9");K.BH("U","Cq://DC.B7.Bm/"+J.N+"/DA");P.M.d=J;L(EO P.M.BR=="4"){P.M.BR.call(CG);}P.M.BR=o;});}b{L(K.Bq==="Ea"){P.M.BR=o;}b{P.M.BR=o;}}},{scope:"publish_stream,read_stream,email,user_birthday,user_photos,photo_upload"});};P.M.Cx=4(){L(!P.M.d){t;}K(".ER").DG(4(){Q A=K(a),J=A.BT("Dx"),B="SELECT%Dn%20FROM%20like%20WHERE%20object_id%D4"+J+"%20AND%Dn%D4"+P.M.d.N,C="/fql?Eg="+B;2.Y(C);O.V(C,"BP",4(K){L(!K||!K.BT){t;}b{L(K.BT.v>H){A.BV("BM\'Bz C3");}b{L(K.p){2.Y("B3: "+K.p.1+"");}}}});});};P.M.BX=4(){O.EJ(4(J){L(J.Bq==="C$"){O.V("/BQ/og.Cg","c",{EZ:Dp.B8},4(J){L(!J||J.p){L(J.p.code==3501){8.BI("Bw Dl deja DP C2");t;}L(Ct("Cu Cp Ei\'Ck produite lors Bv CP\'CU. Ee\\xe9essayer ?")){P.M.B1(P.M.BX);}}b{Q A=K("<G>Bw avez Dl DP C2 EI Cm. </G>");L(P.M.d){A.BC(\'<BN B8="\'+P.M.d.EQ+\'">EA.</BN>\');}8.BI(A);}});}b{L(Ct("Il faut \\xeatre B1\\Bh \\xe0 Cm pour poster un BX. Bw connecter ?")){P.M.B1(P.M.BX);}}});};P.M.Dh=4(){L(!P.M.d){t;}Q A=K(a),J=A.BT("Dx"),B=(A.BV()!="BM\'Bz C3");L(B){O.V("/"+J+"/Cg","c",4(K){L(K===j){A.BV("BM\'Bz C3");}b{L(K.p){2.Y("B3: "+K.p.1+"");}}});}b{O.V("/"+J+"/Cg","DELETE",4(K){L(K===j){A.BV("BM\'Bz");}b{L(K.p){2.Y("B3: "+K.p.1+"");}}});}};P.M.c=4(A,E,J,C,D){L(A){Q B={CA:A};L(E){B.1=E;}O.V("BQ/photos","CY",B,4(A){L(!A.N){t D(A);}O.V(A.N,4(B){L(!B.Dc){t D(B);}E=B.CX===undefined?"":B.CX;Q A={e:"c",Bc:B.Dc,1:E,EF:B.N,BZ:J,CV:B.from.N};K.c("../z/BE.X",A,C);});});}b{L(E){O.V("/BQ/feed","CY",{1:E},4(B){L(!B.N){t D(B);}Q A={e:"c",Bc:"Bg",1:E,EF:B.N,BZ:J,CV:B.N.split("J")[H]};K.c("../z/BE.X",A,C);});}}};P.M.postOpenGraph=4(A,J){K.CR({async:j,e:"CY",CA:"../z/BE.X",BT:{D2:A,BV:J,e:"openGraph"},EM:4(E,J,C){L(!E||E==""){2.p("p while sending CR request CD B7 c 0.");t;}Q BA=B6.CO(E),K=BA.DQ!="Bg"?BA.DQ:o,D=BA.ES!="Bg"?BA.ES:o,B=DW(BA.DZ),A="Di://DU.CN.Bm/chapiters/index.X?bid=ch"+B;L(K){A+="&CK="+K;}L(D){A+="&1="+D;}O.V("/BQ/CN:0","c",{DZ:A},4(K){L(!K||K.p){C4("B3 occured");}b{C4("Publish D0 Voddoo Connection ! ID = "+K.N);}});},p:4(J,K,A){}});};P.B4=4(){P.0.BY("g");L(P.M.d&&P.Cr.BH("U")==Dp.B8){P.Cr.BH("U","Cq://DC.B7.Bm/"+P.M.d.N+"/DA");}L(P.BD.5(".Dw").v==H){P.CH(H);}};P.CH=4(J){J=r(J)?P.BD.5(".Dw").v:J;K.CR({e:"GET",CA:"../z/fb_get_comments.X",BT:{start:J},EM:4(C,J,A){L(C.B2()=="Dm"){Q B=K("<Bs>Echec Bv Eh\\xe9cup\\xe9rer les EG</Bs>");P.BD.5(".B_").DJ(B);B.Dk(C5).D6(Bb,4(){B.CE();});}b{L(C.B2()==""){P.BD.5(".B_").BV("Plus Ef\'anciens EG").Bj("m");}b{P.BD.5(".B_").DJ(C);}}}});};P.Cz=4(){P.0.9("g");};P.Cc=4(A,E){Q J=B6.stringify(Z.i.getProgress());4 C(A){Cn{Q B=B6.CO(A),E=B.posted;CT=K(".DK");CT.CC(B.allHtml);K("#0 .By").scrollTop(CT.BZ().Bn);K("#Cl").l();Q C=k;L(P.M.d&&E.fbpostid!="H"){C=K(\'<G>EL 1 BN EW \\DO\\Bh c\\Bh ici et EI Cm. <BN B8="\'+P.M.d.EQ+\'" BJ="_blank">EA.</BN></G>\');}b{C=K("<G>EL 1 BN EW \\DO\\Bh c\\Bh.</G>");}8.BI(C);}Cy(J){D(A,J);}}4 D(){2.Y("Dm WHILE POSTING COMMENT : ");2.Y(arguments);K("#Cl").l();8.BI("Cu Cp Ck D$. D_ Bv CP\'CU Df la recup\\xe9ration CM Ec.");}L(P.M.d){t P.M.c(A,E,J,C,D);}L(A){Q B={CA:imageUrl};L(E){B.1=E;}B={e:"c",Bc:A,1:E,BZ:J};K.c("../z/BE.X",B,C);}b{L(E){B={e:"c",Bc:"Bg",1:E,BZ:J};K.c("../z/BE.X",B,C);}}};P.CS=4(C,A,D){Q J=K("#$");J.S({f:-A/I,Bn:-D/I,n:A,u:D});J.BY("g").g();Q B=J.Eb("DS").BP(H);B.n=A;B.u=D;B.getContext("2d").putImageData(C,H,H);K("#$ #edit").Bj("m").m(4(){P.Dj.showWithImg(C,A,D);K("#$").l(Bb,4(){K(a).9("g");});});};P.BW=4(J){L(J){J.Ch();}P.BB.9("g");P.BB.Bi();P.Bl.BP(H).reset();P.0.Bj("m",P.BW);K("By").Bj("m",P.BW);};P.C6=4(K,J){L(J!="CZ"&&J!="Ci"){J="Ci";}L(P._.CJ().v==H){P.BO.Cv(P._);}P._.l();P._.BH("U",K).Cd("e",J).B0(500);};P.DX=4(J){Q B=J.BZ;L(!B||B==""||B==H){t{Be:H,Bd:H};}switch(B.e){ED"C2":Q A=B.CX;L(Do[A]){t Do[A].EX(J);}De;ED"obj":Q K=B.N;L(Du[K]){t Du[K].EX(J);}De;}};P.attachComments=4(J){L(!Z.Comment){t;}CD(Q A D0 J){Q K=J[A];P.DX(K);}};K(CG).load(4(){P.EN=K("#EN");P.0=K("#0");P.BD=K("#0 .By .DK");P.DR=K("#0 .x #camera");P.Cr=K("#0 .x #C9");P.BO=K("#0 .x #user_draw");P.BB=K("#0 .x #Ce");P.Bl=K("#0 .x #Ce #imageuploadform");P._=K("#0 .x #comment_image").Bi();P.Dg=K("#Dg");K("#$").l();P.Dj.Cx();K("#comment_btn").m(P.B4);K("#0 .CQ").m(P.Cz);P.DR.m(4(){P.Cz();Z.i.DH(T 7(P.CS,CG));});P.BD.5(".B_").m(4(){P.CH();});P.BO.m(4(J){J.Cf();J.Ch();L(P.BB.CJ().v==H){P.BO.Cv(P.BB);}P.BB.BY("g");P.0.m(P.BW);K("By").m(P.BW);});P.Bl.5().m(4(K){L(!P.BB.hasClass("g")){K.Cf();}K.Ch();});P.Bl.ajaxForm(4(A){A=A.B2();L(A.indexOf(" ")!=-BL){Q J=K(\'<Bs Br="C4">\'+A+"</Bs>");J.S({"Bo-u":P.BO.CJ().u()+"px",n:"50px",overflow:"Bf"});P.BO.Cv(J);J.B0(C7).Dk(C5).D6(4(){K(a).CE();});}b{P.C6("Di://DU.CN.Bm/user_draws/"+A,"Ci");P.BW();}});K("#Ce form #upload_btn").m(4(){P.Bl.submit();});K("#$ #recapture").m(4(J){K("#$").l(Bb,4(){K(a).9("g");});Z.i.DH(T 7(P.CS,CG));});K("#$ #CQ").m(4(J){K("#$").l(Bb,4(){K(a).9("g");});P.B4();});K("#$ #Ct").m(4(J){K("#$").l(Bb,4(){K(a).9("g");});Q A=K("#$").Eb("DS").BP(H).toDataURL();P.B4();P.C6(A,"CZ");});K("#M-custom-BX").m(P.M.BX);K("#share").m(4(){Q B=P._.BH("U"),J=P._.Cd("e");B=(B.B2()=="")?o:B;Q C=K("#DF").DV();C=C!=""?C:o;L(!B&&C==="Bg"){8.BI("Bw devez envoyer au moins CM texte Df une CK.");t;}P._.BH("U","").Cd("e","").Bi();K("#DF").DV("");K("#Cl").g();L(B&&J=="CZ"){Q A={D2:B};L(P.M.d){A.fbComment=j;}K.c("../z/BE.X",A,4(J){Cn{B=B6.CO(J).Bc;}Cy(K){2.Y("Upload d CK p");8.BI("Cu Cp Ck D$. D_ Bv CP\'CU CM Ec.");t;}P.Cc(B,C);});}b{P.Cc(B,C);}});K(".ER").live("m",P.M.Dh);Q J=K("Dq.#newComment");J.S({Bn:K("#i").u()/I-J.u()/I,f:K("#i").n()/I-J.n()/I});J.BP(H).addEventListener("webkitAnimationEnd",4(){J.9("run");J.S({Bn:K("#i").u()/I-J.u()/I,f:K("#i").n()/I-J.n()/I});});P.BS=K("#preference");P.C_=T P.Bk(DD,C7,P.BS.5("G:first"),50);P.B5=T P.Bk(DD,16,P.BS.5("G:eq(BL)"),Ek);P.C_.q.S("f",EB);P.B5.q.S("f",EB);P.C_.3("s",T 7(Z.U.setVolume,Z.U));Z.EH.C1.3("DL",T 7(4(K){P.B5.C8(K);},k));P.B5.3("s",T 7(4(K){Z.EH.C1.DL=K;},k));K("#preference_btn").m(4(){P.BS.BY("g");});P.BS.5(".CQ").m(4(){P.BS.9("g");});});','M|p|0|2|_|$|if|fb|id|FB|gui|var|box|css|new|src|api|div|php|log|mse|this|else|post|user|type|left|show|list|root|true|null|hide|click|width|false|error|jqObj|isNaN|value|return|height|length|moving|header|bottom|fb_api|comment|message|console|observe|function|children|variable|Callback|msgCenter|removeClass|commentImage|capture_result|F|uploadContainer|append|userComments|fb_ajax_connexion|li|_mmvclisteners|prop|send|target|addObservableVars|1|J|a|userDraw|get|me|callback|pref|data|ul|text|closeUpload|like|addClass|position|notify|400|imgUrl|y|x|visible|empty|xe9|detach|unbind|Slider|uploadForm|com|top|line|btn|status|class|h5|h1|L|de|Vous|i|body|aime|fadeIn|connect|trim|Error|openComment|speedctrl|JSON|facebook|href|mseInteraction|renew_comments|back|url|vars|html|for|remove|ondrag|window|updateUsersComments|right|parent|image|endDrag|du|encrenomade|parse|l|close|ajax|editImage|$comments|envoie|fbUserID|style|name|POST|base64|pageX|pageY|postComment|attr|upload_container|preventDefault|likes|stopPropagation|path|step|est|loader|Facebook|try|document|erreur|https|profilPhoto|setTimeout|confirm|Une|after|dragging|init|catch|closeComment|removeProperty|prototype|page|plus|alert|1000|setCommentImage|100|setvalue|profilphoto|audioctrl|connected|picture|instanceof|graph|200|makeModel|comment_content|each|startCapture|G|before|users_comments|speedLevel|H|K|xe9t|cette|imgPath|capture|canvas|addListener|testfb|val|parseInt|attachAComment|set|chapter|offset|prepend|source|gestureEnd|break|ou|menu|commentLike|http|scriber|delay|aimez|ERROR|20user_id|pages|location|img|moveBtn|msgCenterStatic|level|objs|dragStartHandler|one_comment|postid|appendTo|draggingHandlerCB|in|draggingHandler|imgData64|Math|3D|moveBtnCB|fadeOut|mousemove|prependTo|mmvc|Lors|survenue|Voir|70|clearTimeout|case|slider|fbID|commentaires|ArticleLayer|sur|getLoginStatus|closeMessage|Votre|success|center|typeof|gestureSingle|link|comment_like|txtMessage|gestureUpdate|startDrag|dragStartHandlerCB|bien|addComment|showStaticBox|object|not_authorized|find|commentaire|I|R|d|q|r|s|5|8|9'.split('|'),289,293,{},{}))