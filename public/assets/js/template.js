function hideDialog() {
    $('.dialog').removeClass('show');
    $('#conn li').removeClass('inactive');
}
function showSignup() {
    $('.dialog').removeClass('show');
    $('#signup_dialog').addClass('show');
    $('#conn li').removeClass('inactive');
    $('#open_login').addClass('inactive');
}
function showLogin() {
    $('.dialog').removeClass('show');
    $('#login_dialog').addClass('show');
    $('#conn li').removeClass('inactive');
    $('#open_signup').addClass('inactive');
}
function showUpdate() {
    $('.dialog').removeClass('show');
    $('#update_dialog').addClass('show');
    $('#conn li').removeClass('inactive');
    $('#logout').addClass('inactive');
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

function init() {
    $('.main_container').css({
        'top'    : $('header').outerHeight(),
        'height' : $('body').height() - $('header').outerHeight() - $('footer').outerHeight()
    });
    
    $('#open_signup').click(showSignup);
    $('#toSignup').click(showSignup);
    $('#open_login').click(showLogin);
    $('#toLogin').click(showLogin);
    $('#dialog_mask').click(hideDialog);
    $('#user_id').click(showUpdate);
    
    $('#signupbMonth').change(monthChanged);
    $('#updatebMonth').change(updateMonthChanged);
    
    $('.dialog .close').click(function() {
        hideDialog();
    });
    
    $('#cpt_banner, #actu_banner').click(function() {
        window.location = "/story?ep=1&source=banner";
    });
    
    // Facebook like
    $('footer .fb_btn').click(function() {
        fbapi.like();
    });

    $('#signup_dialog form').submit(function(e) {
        // Stop full page reload
        e.preventDefault();
        
        $('#signup_dialog').find('cite, label').removeClass('alert');

        // Check fields
        var name = $('#signupId').val();
        var pass = $('#signupPass').val();
        var conf = $('#signupConf').val();
        var sex = $('#signupSex').val();
        var bDay = $('#signupbDay').val()+"/"+$('#signupbMonth').val()+"/"+$('#signupbYear').val();
        var mail = $('#signupMail').val();
        var pays = $('#signupPays').val();
        var codpos = $('#signupCP').val();
        var tel = $('#signupPortable').val();
        var notif = $('#signupNotif').val();

        var valid = true;
        if(name == "") {$('#signupId').siblings('cite').addClass('alert');valid = false;}
        if(pass == "") {$('#signupPass').siblings('cite').addClass('alert');valid = false;}
        else if(pass.length < 6) {$('#signupPass').siblings('label').addClass('alert');valid = false;}
        if(conf == "" || conf != pass) {$('#signupConf').siblings('cite').addClass('alert');valid = false;}
        if(!regs.mail.test(mail)) {$('#signupMail').siblings('label').addClass('alert');valid = false;}
        // if( (tel != "" && !regs.telephone.test(tel)) || (tel == "" && notif == "sms") ) {
            // $('#signupPortable').siblings('cite').addClass('alert');
            // valid = false;
        // }
        if( codpos != "" && !regs.codpos.test(codpos) ) {
            $('#signupCP').siblings('label').addClass('alert');
            valid = false;
        }
        
        if(!valid) return;
        
        $('input[type=submit]', this).attr('disabled', 'disabled');

        // Request
        var data = {
            'pseudo': name,
            'password': pass,
            'email': mail,
            'sex': sex,
            'birthday': bDay,
            'pays': pays,
            'codpos': codpos,
            'portable': tel,
            'notif': notif,
            'fbToken': $('#signup_fbToken').val()
        };

        // Send
        $.ajax({
            url: './base/signup_normal',
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
                    document.location.href = data.redirect;
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
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
                $('input[type=submit]').removeAttr('disabled');
            }
        });
    });
    
    // Facebook signup
    $('#signup_dialog .fb_btn').click(function(){    
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
                });
            } 
            else if (response.status === 'not_authorized'){
                alert('Ton compte Facebook ne vous permet pas de rejoindre notre site');
            }
            else { // fail
                alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
            }
        }, {scope:'publish_stream,read_stream,email,user_birthday,user_photos,photo_upload'});       
    });
    
    // Facebook login
    $('#login_dialog .fb_btn').click(function(){
        function doFBLogin(accessToken){
            $.ajax({
                url: './base/login_fb',
                type: 'POST',
                dataType: 'json',
                data: {fbToken: accessToken},
                success: function(data, textStatus, XMLHttpRequest)
                {
                    // now, we get two important pieces of data back from our rest controller
                    // data.valid = true/false
                    // data.redirect = the page we redirect to on successful login
                    if (data.valid)
                    {
                        document.location.href = data.redirect;
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
        }
        var token = FB.getAccessToken();
        if(token) doFBLogin(token); // The user is connected with FB && auth to the app
        // Here we could write the other cases...
    });
    
    $('#login_dialog form').submit(function(e) {
        // Stop full page load
        e.preventDefault();

        // Check fields
        var name = $('#loginId').val();
        var pass = $('#loginPass').val();

        var valid = true;
        if(name == "") {$('#loginId').addClass('invalid');valid = false;}
        if(pass == "") {$('#loginPass').addClass('invalid');valid = false;}
        if(!valid) return;
        
        $('input[type=submit]', this).attr('disabled', 'disabled');

        // Request
        var data = {
            'identifiant': name,
            'password': pass,
        };

        // Send
        $.ajax({
            url: './base/login_normal',
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
                    document.location.href = data.redirect;
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
    
    
    $('#update_dialog form').submit(function(e) {
        // Stop full page reload
        e.preventDefault();
        
        $('#update_dialog').find('cite, label').removeClass('alert');

        // Check fields
        var pass = $('#updatePass').val();
        var conf = $('#updateConf').val();
        var sex = $('#updateSex').val();
        var bDay = $('#updatebDay').val()+"/"+$('#updatebMonth').val()+"/"+$('#updatebYear').val();
        var pays = $('#updatePays').val();
        var codpos = $('#updateCP').val();
        var oldPass = $('#updateOldPass').val();

        var valid = true;
        if(pass != "" && pass.length < 6) {$('#updatePass').siblings('label').addClass('alert');valid = false;}
        if(conf != "" && conf != pass) {$('#updateConf').siblings('cite').addClass('alert');valid = false;}
        if( codpos != "" && !regs.codpos.test(codpos) ) {
            $('#updateCP').siblings('label').addClass('alert');
            valid = false;
        }
        if(oldPass == "") {
            $('#updateOldPass').siblings('cite').addClass('alert');valid = false;
        }
        
        if(!valid) return;
        
        $('input[type=submit]', this).attr('disabled', 'disabled');

        // Request
        var data = {
            'oldPass': oldPass,
            'newPass': pass,
            'sex': sex,
            'birthday': bDay,
            'pays': pays,
            'codpos': codpos
        };

        // Send
        $.ajax({
            url: './base/update',
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
                    document.location.href = data.redirect;
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
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Désolé, une erreur inconnue s\'est produite, tu peux nous contacter: contact@encrenomade.com');
                $('input[type=submit]').removeAttr('disabled');
            }
        });
    });
    
    
    $('#logout').click(function(e) {
        // Send
        $.ajax({
            url: './base/logout',
            dataType: 'json',
            type: 'GET',
            success: function(data, textStatus, XMLHttpRequest)
            {
                // now, we get two important pieces of data back from our rest controller
                // data.valid = true/false
                // data.redirect = the page we redirect to on successful login
                if (data.valid)
                {
                    document.location.href = data.redirect;
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


