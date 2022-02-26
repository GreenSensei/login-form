function promptLogin( )
{
    var login = document.getElementById("email").value;
    if(login != ''){
        alert("Login is incorrect");
        document.getElementById('pwdText').value = "";
        return false;
    }
    else{
        alert("Password is correct, you are allowed to enter the site");
        // Enter Site Code Here
    }
}