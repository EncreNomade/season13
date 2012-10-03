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


(function () {

var regs = {
    'date': /^\d{2}\/\d{2}\/\d{4}$/,
    'mail': /^[\w\.\_\-]+@[\w\.\_\-]+$/,
    'telephone' : /^[\d]+$/,
    'errcode': /\d{4}/g
}

function init() {
    $('.main_container').css('height', $('body').height() - $('header').outerHeight() - $('footer').outerHeight());
    
    $('#open_signup').click(showSignup);
    $('#toSignup').click(showSignup);
    $('#open_login').click(showLogin);
    $('#toLogin').click(showLogin);
    $('#dialog_mask').click(hideDialog);
    
    $('#signupbMonth').change(monthChanged);
    
    $('.dialog .close').click(function() {
        hideDialog();
    });

    $('#signupBtn').click(function(e) {
        // Stop full page reload
        e.preventDefault();
        
        $('#signup_dialog cite').removeClass('alert');

        // Check fields
        var name = $('#signupId').val();
        var pass = $('#signupPass').val();
        var conf = $('#signupConf').val();
        var sex = $('#signupSex').val();
        var bDay = $('#signupbDay').val()+"/"+$('#signupbMonth').val()+"/"+$('#signupbYear').val();
        var mail = $('#signupMail').val();
        var tel = $('#signupPortable').val();
        var notif = $('#signupNotif').val();

        var valid = true;
        if(name == "") {$('#signupId').siblings('cite').addClass('alert');valid = false;}
        if(pass == "") {$('#signupPass').siblings('cite').addClass('alert');valid = false;}
        if(conf == "" || conf != pass) {$('#signupConf').siblings('cite').addClass('alert');valid = false;}
        if(!regs.mail.test(mail)) {$('#signupMail').siblings('cite').addClass('alert');valid = false;}
        if( (tel != "" && !regs.telephone.test(tel)) || (tel == "" && notif == "sms") ) {
            $('#signupPortable').siblings('cite').addClass('alert');
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
            'portable': tel,
            'notif': notif
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
                    alert('Signup error');
                    $('input[type=submit]').removeAttr('disabled');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Page request error');
                $('input[type=submit]').removeAttr('disabled');
            }
        });
    });
    
    
    $('#loginBtn').click(function(e) {
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
                    alert('Signup error');
                    $('input[type=submit]').removeAttr('disabled');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Page request error');
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
                    alert('Signup error');
                    $('input[type=submit]').removeAttr('disabled');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Page request error');
                $('input[type=submit]').removeAttr('disabled');
            }
        });
    });
};

$(document).ready(init);

})();