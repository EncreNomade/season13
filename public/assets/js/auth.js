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


(function () {

var regs = {
    'date': /^\d{2}\/\d{2}\/\d{4}$/,
    'mail': /^[\w\.\_\-]+@[\w\.\_\-]+$/,
    'telephone' : /^[\d]+$/,
    'errcode': /\d{4}/g,
    'codpos': /^[\d]+$/
}

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

    var options = {
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
                        $('#signupMail').siblings('label').addClass('alert');
                    else if(data.errorType == 'pseudo') 
                        $('#signupId').siblings('label').addClass('alert');
                }
                if(data.errorMessage) alert('Erreur d\'inscription: '+ data.errorMessage);
                $('input[type=submit]').removeAttr('disabled');
            }
        },
        error :     function(XMLHttpRequest, textStatus, errorThrown) {
            alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
            $('input[type=submit]').removeAttr('disabled');
        }
    };
    // Prepare ajax form
    $('#signupForm').ajaxForm(options);
    $('#signupBtn').click(function(e) {
        $('#signupForm').find('cite, label').removeClass('alert');

        // Check fields
        var name = $('#signupId').val();
        var pass = $('#signupPass').val();
        var conf = $('#signupConf').val();
        var sex = $('#signupSex').val();
        var bDay = $('#signupbDay').val()+"/"+$('#signupbMonth').val()+"/"+$('#signupbYear').val();
        $('#signupBirthday').val(bDay);
        var mail = $('#signupMail').val();
        var pays = $('#signupPays').val();
        var codpos = $('#signupCP').val();
        var tel = $('#signupPortable').val();
        var notif = $('#signupNotif').val();

        var valid = true;
        if(name == "") {$('#signupId').siblings('cite').addClass('alert');valid = false;}
        if(pass == "") {$('#signupPass').siblings('cite').addClass('alert');valid = false;}
        else if(pass.length < 6) {$('#signupPass').siblings('cite').addClass('alert');valid = false;}
        if(conf == "" || conf != pass) {$('#signupConf').siblings('cite').addClass('alert');valid = false;}
        if(!regs.mail.test(mail)) {$('#signupMail').siblings('label').addClass('alert');valid = false;}
        if( (tel != "" && !regs.telephone.test(tel))/* || (tel == "" && notif == "sms")*/ ) {
            $('#signupPortable').siblings('cite').addClass('alert');
            valid = false;
        }
        if( codpos != "" && !regs.codpos.test(codpos) ) {
            $('#signupCP').siblings('label').addClass('alert');
            valid = false;
        }
        
        if(!valid) e.preventDefault();
        
        $('input[type=submit]', this).attr('disabled', 'disabled');
        $('#signupForm').each(function() {
            fuel_set_csrf_token(this);
        });
    });
    
    // Facebook signup
    $('#signupForm .fb_btn').click(function(){    
        FB.login(function(response) {
            if (response.status == 'connected') {                
                var fbToken = response.authResponse.accessToken;
                FB.api('me', function(u){
                    $('#signupId').val(u.username);
                    $('#signupSex').val(u.gender == 'male' ? 'm' : 'f');
                    var bDay = u.birthday.split('/'); // month/day/year
                    $('#signupbDay').val(bDay[1]);
                    $('#signupbMonth').val(bDay[0]);
                    $('#signupbYear').val(bDay[2]);
                    $('#signupMail').attr('readonly', 'readonly').val(u.email);
                    
                    $('#signup_fbToken').val(fbToken); // signal to server, it's a FB user !
                    
                    alert('Complète ton formulaire d\'inscription pour t\'inscrire');
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
    
    // Facebook login
    function fb_logged(response) {
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
                        showLinkFb();
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
    }
    $('#loginForm .fb_btn').click(function(){
        fbapi.connect(fb_logged);
    });
    
    
    var options = {
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
    };
    // Prepare ajax form
    $('#linkFbForm').ajaxForm(options);
    $('#linkfbBtn').click(function(e) {
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
    });
    
    
    
    $('#loginForm').submit(function(e) {
        // Stop full page load
        e.preventDefault();

        // Check fields
        var name = $('#loginId').val();
        var pass = $('#loginPass').val();

        var valid = true;
        if(name == "") {$('#loginId').siblings('label').addClass('alert');valid = false;}
        if(pass == "") {$('#loginPass').siblings('label').addClass('alert');valid = false;}
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
    
    
    
    var options = {
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
    };
    // Prepare ajax form
    $('#chPassForm').ajaxForm(options);
    $('#chPassBtn').click(function(e) {
        $('#chPassForm').find('cite, label').removeClass('alert');
        
        $('input[type=submit]', this).attr('disabled', 'disabled');
        fuel_set_csrf_token($('#chPassForm').get(0));
    });
    
    
    
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
        if( codpos != "" && !regs.codpos.test(codpos) ) {
            $('#updateCP').siblings('label').addClass('alert');
            valid = false;
        }
        if( (tel != "" && !regs.telephone.test(tel))/* || (tel == "" && notif == "sms")*/ ) {
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

})();


