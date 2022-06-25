$(document).ready(function() {
    $('#submit').click(function(){
        let email = $('#emailUser').val();
        let pass = $('#passwordUser').val();
        let pseudo = $('#pseudo').val();
        let bdu = $('#birthdateUser').val();
        let passConf = $('#passwordUserConfirmation').val();

        let emailOK = false;
        let passOK = false;
        let pseudoOK =false;
        let bduOK = false;
        let passConfOK = false;

        $("#span").remove();
        $("#span2").remove();
        $("#span3").remove();
        $("#span4").remove();
        $("#span5").remove();

        //verif mail
        if(IsEmail(email)==false){
            $("#emailUser").after("<span class='text-danger' id='span'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Email incorrect</span>");
        }else{ emailOK=true;}

        //verif mdp
        if(IsMdp(pass)==false){
            $("#passwordUser").after("<span class='text-danger' id='span2'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Mot de passe incorrect</span>");
        }else{ passOK=true;}

        //verif pseudo
        if(IsNull(pseudo)==false){
            $("#pseudo").after("<span class='text-danger' id='span3'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Pseudo incorrect incorrect</span>");
        }else{ pseudoOK=true;}

        //verif birthdateUser
        if(IsNull(bdu)==false){
            $("#birthdateUser").after("<span class='text-danger' id='span4'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> date incorrect incorrect</span>");
        }else{ bduOK=true;}

        //confirmation mdp
        if(IsConf(pass, passConf)==false){
            $("#passwordUserConfirmation").after("<span class='text-danger' id='span5'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> les mots de passe ne corresponde pas</span>");
        }else{ passConOKf=true;}


        if ((emailOK===true)&&(passOK===true)&&(pseudoOK===true)&&(bduOK===true)&&(passConOKf===true)){
            return true;
        }
        else{ return false;}
    });
});

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
        return false;
    }else{
        return true;
    }
}

function IsMdp(pass) {
    var regex = /^(.{8,})+(?=.*\d)+(?=.*[a-z])+$/;
    var chifre = /^(?=.*\d)+$/;
    var nbcaractere = /^(.{8,})+$/;
    var min = /^(?=.*[a-z])+$/;
    var MAJ = /^(?=.*[A-Z])+$/;
    if(!nbcaractere.test(pass)) {
        return false;
    }else{
        return true;
    }
}

function IsNull(verif) {
    if(verif=='') {
        return false;
    }else{
        return true;
    }
}

function IsConf(pass, passConf) {
    if(pass==passConf) {
        return true;
    }else{
        return false;
    }
}