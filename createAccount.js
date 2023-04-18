function checkPass() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var message = document.getElementById("message");
    var bouton = document.getElementById("submit");
    if(password != confirmPassword) {
        message.innerHTML = "Les mots de passe sont différents !";
        bouton.disabled = true;
    } else {
        message.innerHTML = "";
        bouton.disabled = false;
    }
}