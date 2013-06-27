function hideDialog(dialog) {
    dialog.removeClass('show');
    var name = dialog.prop('id');
    // if(name == "signup_dialog" || name == "login_dialog" || name == "change_pass_dialog" || name == "link_fb_dialog" || name == "update_dialog") 
        $('#conn li').removeClass('inactive');
}

function showSignup() {
    $('.dialog').removeClass('show');
    $('#signup_dialog').addClass('show');
    var $this = $('#open_signup');
    $this.siblings(':not(.text_sep_vertical)').addClass('inactive');
    $this.removeClass('inactive');
    addCountries($('#signupPays'));
}
function showLogin() {
    $('.dialog').removeClass('show');
    $('#login_dialog').addClass('show');
    var $this = $('#open_login');
    $this.siblings(':not(.text_sep_vertical)').addClass('inactive');
    $this.removeClass('inactive');
}
function showChPass() {
    $('.dialog').removeClass('show');
    $('#change_pass_dialog').addClass('show');
    $('#change_pass_dialog').find('cite').text("").removeClass('alert');
    var $this = $('#open_login');
    $this.siblings(':not(.text_sep_vertical)').addClass('inactive');
    $this.removeClass('inactive');
}
function showLinkFb() {
    $('.dialog').removeClass('show');
    $('#link_fb_dialog').addClass('show');
    $('#link_fb_dialog').find('cite').text("").removeClass('alert');
    var $this = $('#open_login');
    $this.siblings(':not(.text_sep_vertical)').addClass('inactive');
    $this.removeClass('inactive');
}
function showUpdate() {
    $('.dialog').removeClass('show');
    $('#update_dialog').addClass('show');
    var $this = $('#user_id');
    $this.siblings(':not(.text_sep_vertical)').addClass('inactive');
    $this.removeClass('inactive');
    addCountries($('#updatePays'));
}
function addCountries(select) {
    if(select.children().length < 2 && config.countries) {
        for (var id in config.countries) {
            select.append('<option value="'+id+'">'+config.countries[id]+'</option>');
        }
    }
}
function monthChanged() {
    var m = parseInt($('#signupbMonth').val());
    var d = parseInt($('#signupbDay').val());
    var day = "";
    var smallList = [4, 6, 9, 11];
    var nb = 30;
    if(m == 2)
        var nb = 28;
    else if($.inArray(m, smallList) != -1)
        var nb = 30;
    else nb = 31;
    
    for(var i = 1; i <= nb; ++i) {
        day += "<option value='"+i+"'>"+i+"</option>";
    }
    $('#signupbDay').html(day);
    if(d <= nb) $('#signupbDay').val(d);
}
function updateMonthChanged() {
    var m = parseInt($('#updatebMonth').val());
    var d = parseInt($('#updatebDay').val());
    var day = "";
    var smallList = [4, 6, 9, 11];
    var nb = 30;
    if(m == 2)
        var nb = 28;
    else if($.inArray(m, smallList) != -1)
        var nb = 30;
    else nb = 31;
    
    for(var i = 1; i <= nb; ++i) {
        day += "<option value='"+i+"'>"+i+"</option>";
    }
    $('#updatebDay').html(day);
    if(d <= nb) $('#updatebDay').val(d);
}

window.auth = {

    regs : {
        'date': /^\d{2}\/\d{2}\/\d{4}$/,
        'mail': /^[\w\.\_\-]+@[\w\.\_\-]+$/,
        'telephone' : /^[\d]+$/,
        'errcode': /\d{4}/g,
        'codpos': /^[\d]+$/
    },
    
    linkfb_options : {
        type :      'POST',
        dataType :  'json',
        success :   function(data, textStatus, XMLHttpRequest) {
            if(data.valid) {
                alert("Félicitation, désormais tu peux te connecter avec ton compte Facebook.");
                document.location.reload();
                return;
            }
            
            switch (data.errorCode) {
            // Authentification errors
            case 1:
                $('#linkfbPass').siblings('label').addClass('alert');
                $('#linkfbId').siblings('label').addClass('alert');
                break;
            case 2:
                $('#linkfbId').siblings('label').addClass('alert');
                break;
            case 3:
                $('#linkfbPass').siblings('label').addClass('alert');
                break;
                
            // Facebook errors
            case 10:
            case 11:
            case 13:
                alert(data.errorMessage);
                document.location.reload();
                break;
            default:
                alert("Désolé, une erreur inconnue s'est produite, veuilles recharger la page et réessayer");
                break;
            }
        
            $('input[type=submit]').removeAttr('disabled');
        },
        error :     function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Désolé, une erreur inconnue s'est produite, tu peux nous contacter: contact@encrenomade.com");
            $('input[type=submit]').removeAttr('disabled');
        }
    },
    linkfb_action : function(e) {
        $('#linkFbForm').find('cite, label').removeClass('alert');

        // Check fields
        var name = $('#linkfbId').val();
        var pass = $('#linkfbPass').val();

        var valid = true;
        if(name == "") {$('#linkfbId').siblings('label').addClass('alert');valid = false;}
        if(pass == "") {$('#linkfbPass').siblings('label').addClass('alert');valid = false;}
        if(!valid) {
            // Stop full page load
            e.preventDefault();
            return;
        }
        
        $('#linkfbToken').prop('value', fbapi.token);
        
        $('input[type=submit]', this).attr('disabled', 'disabled');
        fuel_set_csrf_token($('#linkFbForm').get(0));
    },
    
    
    chPass_options : {
        type :      'POST',
        dataType :  'json',
        success :   function(data, textStatus, XMLHttpRequest) {
            if (data.valid)
            {
                $('#chpass_mail').siblings('cite').text("Ton nouveau mot de passe a été envoyé.");
                alert("Ton nouveau mot de passe a été envoyé.");
                hideDialog($('#change_pass_dialog'));
                $('input[type=submit]').removeAttr('disabled');
            }
            else
            {
                $('#chpass_mail').siblings('cite').text(data.errorMessage).addClass('alert');
                $('input[type=submit]').removeAttr('disabled');
            }
        },
        error :     function(XMLHttpRequest, textStatus, errorThrown) {
            $('#chpass_mail').siblings('cite').text("Désolé, une erreur inconnue s'est produite, tu peux nous contacter: contact@encrenomade.com").addClass('alert');
            $('input[type=submit]').removeAttr('disabled');
        }
    },
    chPass_action : function(e) {
        $('#chPassForm').find('cite, label').removeClass('alert');
        
        $('input[type=submit]', this).attr('disabled', 'disabled');
        fuel_set_csrf_token($('#chPassForm').get(0));
    },
    
    
    
    
    initFbSingupBtn : function(btn, form) {
        if(!form || form.length <= 0 || !btn || btn.length <= 0) return;
        var presignupfb = function() {
            FB.api('me', function(u){
                form.find('#signupId').val(u.username);
                form.find('#signupSex').val(u.gender == 'male' ? 'm' : 'f');
                var bDay = u.birthday.split('/'); // month/day/year
                form.find('#signupbDay').val(bDay[1]);
                form.find('#signupbMonth').val(bDay[0]);
                form.find('#signupbYear').val(bDay[2]);
                form.find('#signupMail').attr('readonly', 'readonly').val(u.email);
            
                form.find('#signup_fbToken').val(fbToken); // signal to server, it's a FB user !
            
                alert('Complète ton formulaire d\'inscription pour t\'inscrire');
            });
        };
        btn.click(function(){
            FB.login(function(response) {
                if (response.status == 'connected') {                
                    var fbToken = response.authResponse.accessToken;
                    
                    $.ajax({
                        url: config.publicRoot + 'base/signup_fb',
                        type: 'POST',
                        dataType: 'json',
                        data: {'fbToken':fbToken},
                        success: function(data, textStatus, XMLHttpRequest)
                        {
                            if (data.valid)
                            {
                                document.location.reload();
                            }
                            else
                            {
                                if(!data.errorCode){
                                    alert('Désolé, une erreur inconnue s\'est produite, veuilles recharger la page et réessayer');
                                    return;
                                }
                                
                                switch (data.errorCode) {
                                case 4:
                                    alert('Désolé, l\'adresse mail lié à votre compte Facebook existe déjà, veuilles t\'inscrire avec le formulaire.');
                                    break;
                                case 5:
                                    alert('Désolé, le pseudo existe déjà, veuilles t\'inscrire avec le formulaire.');
                                    break;
                                case 6:
                                    alert('Désolé, une erreur s\'est produite lorsque la création du compte, veuilles recharger la page et réessayer.');
                                    break;
                                case 14:
                                case 15:
                                    alert('Désolé, une erreur de connexion Facebook s\'est produite, veuilles recharger la page et réessayer.');
                                    break;
                                default:
                                    alert('Désolé, une erreur inconnue s\'est produite, veuilles recharger la page et réessayer');
                                }
                            }
                        },
                        error: function() {
                            alert('Désolé, une erreur inconnue s\'est produite, veuilles recharger la page et réessayer');
                        }
                    });
                } 
                else if (response.status === 'not_authorized'){
                    alert('Ton compte Facebook ne te permet pas de rejoindre notre site');
                }
                else { // fail
                    alert('Désolé, une erreur inconnue s\'est produite, veuilles recharger la page et réessayer');
                }
            }, {scope:'publish_stream,read_stream,email,user_birthday,user_photos,photo_upload'});       
        });
    },
    
    initSignupForm : function(form) {
        if(!form || form.length <= 0) return;
        form.ajaxForm({
            type :      'POST',
            dataType :  'json',
            success :   function(data, textStatus, XMLHttpRequest) {
                // now, we get two important pieces of data back from our rest controller
                // data.valid = true/false
                // data.redirect = the page we redirect to on successful login
                if (data.valid)
                {
                    //document.location.href = data.redirect;
                    document.location.reload();
                }
                else
                {
                    if(data.errorType) {
                        if(data.errorType == 'mail') 
                            form.find('#signupMail').siblings('label').addClass('alert');
                        else if(data.errorType == 'pseudo') 
                            form.find('#signupId').siblings('label').addClass('alert');
                    }
                    if(data.errorMessage) alert('Erreur d\'inscription: '+ data.errorMessage);
                    $('input[type=submit]').removeAttr('disabled');
                }
            },
            error :     function(XMLHttpRequest, textStatus, errorThrown) {
                alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
                $('input[type=submit]').removeAttr('disabled');
            }
        });
        
        form.find('#signupBtn').click(function(e) {
            form.find('cite, label').removeClass('alert');
    
            // Check fields
            var name = form.find('#signupId').val();
            var pass = form.find('#signupPass').val();
            var conf = form.find('#signupConf').val();
            var sex = form.find('#signupSex').val();
            var bDay = form.find('#signupbDay').val()+"/"+form.find('#signupbMonth').val()+"/"+form.find('#signupbYear').val();
            form.find('#signupBirthday').val(bDay);
            var mail = form.find('#signupMail').val();
            var pays = form.find('#signupPays').val();
            var codpos = form.find('#signupCP').val();
            var tel = form.find('#signupPortable').val();
            var notif = form.find('#signupNotif').val();
    
            var valid = true;
            if(name == "") {
                form.find('#signupId').siblings('cite').addClass('alert');
                valid = false;
            }
            if(pass == "") {
                form.find('#signupPass').siblings('cite').addClass('alert');
                valid = false;
            }
            else if(pass.length < 6) {
                form.find('#signupPass').siblings('cite').addClass('alert');
                valid = false;
            }
            if(conf == "" || conf != pass) {
                form.find('#signupConf').siblings('cite').addClass('alert');
                valid = false;
            }
            if(!auth.regs.mail.test(mail)) {
                form.find('#signupMail').siblings('label').addClass('alert');
                valid = false;
            }
            if( (tel != "" && !auth.regs.telephone.test(tel))/* || (tel == "" && notif == "sms")*/ ) {
                form.find('#signupPortable').siblings('cite').addClass('alert');
                valid = false;
            }
            if( codpos != "" && !auth.regs.codpos.test(codpos) ) {
                form.find('#signupCP').siblings('label').addClass('alert');
                valid = false;
            }
            
            if(!valid) e.preventDefault();
            
            $('input[type=submit]', this).attr('disabled', 'disabled');
            fuel_set_csrf_token(form.get(0));
        });
    },
    
    
    initFbLoginBtn : function(btn) {
        if(!btn || btn.length <= 0) return;
        btn.click(function(){
            fbapi.connect(function(response) {
                if(response.status === 'not_authorized') {
                    alert('Ton compte Facebook ne te permet pas de rejoindre notre site');
                    return;
                }
            
                var token = fbapi.token;
                
                $.ajax({
                    url: config.publicRoot + 'base/login_fb',
                    type: 'POST',
                    dataType: 'json',
                    data: {'fb_token':token},
                    success: function(data, textStatus, XMLHttpRequest)
                    {
                        // now, we get two important pieces of data back from our rest controller
                        // data.valid = true/false
                        // data.redirect = the page we redirect to on successful login
                        if (data.valid)
                        {
                            //document.location.href = data.redirect;
                            document.location.reload();
                        }
                        else
                        {
                            switch (data.errorCode) {
                            case 10:
                            case 11:
                                break;
                            case 12:
                                if(showLinkFb) showLinkFb();
                                data.errorMessage = "";
                                break;
                            }
                            if(data.errorMessage && data.errorMessage != "") 
                                alert('Erreur de connexion: '+ data.errorMessage);
                            $('input[type=submit]').removeAttr('disabled');
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown)
                    {
                        alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
                        $('input[type=submit]').removeAttr('disabled');
                    }
                });
            });
        });
    },
    
    initLoginForm : function(form) {
        if(!form || form.length <= 0) return;
        form.submit(function(e) {
            // Stop full page load
            e.preventDefault();
            
            // Check fields
            var name = form.find('#loginId').val();
            var pass = form.find('#loginPass').val();
    
            var valid = true;
            if(name == "") {
                form.find('#loginId').siblings('label').addClass('alert');
                valid = false;
            }
            if(pass == "") {
                form.find('#loginPass').siblings('label').addClass('alert');
                valid = false;
            }
            if(!valid) return;
            
            $('input[type=submit]', this).attr('disabled', 'disabled');
    
            // Request
            var data = {
                'identifiant': name,
                'password': pass,
            };
    
            // Send
            $.ajax({
                url: config.publicRoot + 'base/login_normal',
                dataType: 'json',
                type: 'POST',
                data: data,
                success: function(data, textStatus, XMLHttpRequest)
                {
                    // now, we get two important pieces of data back from our rest controller
                    // data.valid = true/false
                    // data.redirect = the page we redirect to on successful login
                    if (data.valid)
                    {
                        //document.location.href = data.redirect;
                        document.location.reload();
                    }
                    else
                    {
                        if(data.errorMessage) alert('Erreur de connexion: '+ data.errorMessage);
                        $('input[type=submit]').removeAttr('disabled');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
                    $('input[type=submit]').removeAttr('disabled');
                }
            });
        });
    }

};


(function (auth) {

function defaultHide() {
    hideDialog($(this).parents('.dialog'));
}

function init() {
    $('#open_signup').click(showSignup);
    $('#toSignup').click(showSignup);
    $('#open_login').click(showLogin);
    $('#toLogin').click(showLogin);
    $('#dialog_mask').click(hideDialog);
    $('#user_id').click(showUpdate);
    
    $('#signupbMonth').change(monthChanged);
    $('#updatebMonth').change(updateMonthChanged);
    
    $('.dialog .close').unbind('click', defaultHide).click(defaultHide);
    
    // Extra code for popup dialog alert
    $('.flash-close').click(function() {
        var alert = $(this).parent('.flash-alert');
        alert.fadeOut(500);
        setTimeout(function() {
            alert.remove();
        }, 500);
    });

    auth.initSignupForm($('#signupForm'));
    auth.initFbSingupBtn($('#signupForm .fb_btn'), $('#signupForm'));
    
    auth.initLoginForm($('#loginForm'));
    auth.initFbLoginBtn($('#loginForm .fb_btn'));
    
    
    $('#linkFbForm').ajaxForm(auth.linkfb_options);
    $('#linkfbBtn').click(auth.linkfb_action);
    
    
    $('#chPassForm').ajaxForm(auth.chPass_options);
    $('#chPassBtn').click(auth.chPass_action);
    
    
    
    var options = {
        type :      'POST',
        dataType :  'json',
        success :   function(data, textStatus, XMLHttpRequest) {
            if (data.valid)
            {
                //document.location.href = data.redirect;
                document.location.reload();
            }
            else
            {
                if(data.errorType) {
                    if(data.errorType == 'password') 
                        $('#updateOldPass').siblings('label').addClass('alert');
                }
                if(data.errorMessage) alert('Erreur de la mise à jour: '+ data.errorMessage);
                $('input[type=submit]').removeAttr('disabled');
            }
        },
        error :     function(XMLHttpRequest, textStatus, errorThrown) {
            alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
            $('input[type=submit]').removeAttr('disabled');
        }
    };
    // Prepare ajax form
    $('#updateForm').ajaxForm(options);
    $('#updateBtn').click(function(e) {
        $('#updateForm').find('cite, label').removeClass('alert');

        // Check fields
        var pass = $('#updatePass').val();
        var conf = $('#updateConf').val();
        var sex = $('#updateSex').val();
        var bDay = $('#updatebDay').val()+"/"+$('#updatebMonth').val()+"/"+$('#updatebYear').val();
        $('#updateBirthday').val(bDay);
        var pays = $('#updatePays').val();
        var codpos = $('#updateCP').val();
        var tel = $('#updatePortable').val();
        var notif = $('#updateNotif').val();
        var oldPass = $('#updateOldPass').val();

        var valid = true;
        if(pass != "" && pass.length < 6) {$('#updatePass').siblings('cite').addClass('alert');valid = false;}
        if(conf != "" && conf != pass) {$('#updateConf').siblings('cite').addClass('alert');valid = false;}
        if( codpos != "" && !auth.regs.codpos.test(codpos) ) {
            $('#updateCP').siblings('label').addClass('alert');
            valid = false;
        }
        if( (tel != "" && !auth.regs.telephone.test(tel))/* || (tel == "" && notif == "sms")*/ ) {
            $('#updatePortable').siblings('cite').addClass('alert');
            valid = false;
        }
        if(oldPass == "") {
            $('#updateOldPass').siblings('cite').addClass('alert');valid = false;
        }
        
        if(!valid) e.preventDefault();
        
        $('input[type=submit]', this).attr('disabled', 'disabled');
        fuel_set_csrf_token($('#updateForm').get(0));
    });
    
    
    $('#logout').click(function(e) {
        // Send
        $.ajax({
            url: config.publicRoot + 'base/logout',
            dataType: 'json',
            type: 'GET',
            success: function(data, textStatus, XMLHttpRequest)
            {
                if (data.valid)
                {
                    //document.location.href = data.redirect;
                    document.location.reload();
                }
                else
                {
                    if(data.errorMessage) alert('Erreur de déconnexion: '+ data.errorMessage);
                    $('input[type=submit]').removeAttr('disabled');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
                $('input[type=submit]').removeAttr('disabled');
            }
        });
    });
};

$(document).ready(init);

})(window.auth);


