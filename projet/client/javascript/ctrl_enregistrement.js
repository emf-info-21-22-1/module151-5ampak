//variable
var loginValueUsername;
var loginValuePassword;
var loginValuePasswordVerif;

//Load http
$.getScript("javascript/service/service_http.js", function() {
    console.log("servicesHttp.js chargé !");
});


$(document).ready(function() {
    $("#submit").click(function(event) {
        event.preventDefault(); // pour afficher les echos / permission
        
        //injection sql ?
        // get data
        console.log("Button register pressed");
        
        loginValueUsername = $("#username").val();
        console.log("Username:", loginValueUsername);

        loginValuePassword = $("#password").val();
        console.log("Password:", loginValuePassword);

        loginValuePasswordVerif = $("#passwordVerif").val();
        console.log("Password verif:", loginValuePasswordVerif);
        

        //check same password
        checkSamePassword(loginValuePassword,loginValuePasswordVerif);
    });
});


function checkSamePassword(password, passwordVerif) {
    if (password !== passwordVerif) {
        alert("Passwords do not match. Please verify your password.");
    } else{
        createUser(loginValueUsername,loginValuePassword);
    }
}

function createUser(username, password){
    console.log("Création d'un utilisateur : " + username + " " + password);
    //Create user http
    
    createUserAjax(username, password, function(response) {
        // Callback de succès
       alert("Utilisateur crée avec succès !");
    }, function(error) {
        // Callback d'erreur
        alert("User already exist !");
    });
  
}

