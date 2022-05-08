function checkLogin(form) {

    var reg = document.getElementById("regNum").value;

    re = /[it|IT|AD|ad|iT|It][0-9]{7}|[Admin|admin|ADMIN]$/;
    re1 = /[it|IT|AD|ad|iT|It][0-9]{8}|[Admin|admin|ADMIN]$/;

    if(!re.test(reg)&&!re1.test(reg)) {
        showErrorMsg("Your Entered Wrong Registration No. !");
        return false;
    }

    return true;

}