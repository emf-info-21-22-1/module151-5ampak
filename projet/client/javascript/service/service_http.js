/*
 * Couche de services HTTP (worker).
 *
 * @author Olivier Neuhaus
 * @version 1.0 / 20-SEP-2013
 */

var BASE_URL = "http://localhost:8081/";


/**
 * Fonction permettant de créer un utilisateur.
 * @param {string} username Nom d'utilisateur de l'utilisateur.
 * @param {string} passwd Mot de passe de l'utilisateur.
 * @param {function} successCallback Fonction de callback en cas de succès de la requête.
 * @param {function} errorCallback Fonction de callback en cas d'erreur de la requête.
 */
function createUserAjax(username, passwd, successCallback, errorCallback) {
    console.log("----------------")
    console.log("Création méthode ajax");
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL + "login.php",
        data:{
            "action":"createUser",
            "username":username,
            "password":passwd
        },  
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}


/**
 * Fonction permettant de créer un utilisateur.
 * @param {string} username Nom d'utilisateur de l'utilisateur.
 * @param {string} passwd Mot de passe de l'utilisateur.
 * @param {function} successCallback Fonction de callback en cas de succès de la requête.
 * @param {function} errorCallback Fonction de callback en cas d'erreur de la requête.
 */
function connexionUserAjax(username, passwd, successCallback, errorCallback) {
    console.log("----------------")
    console.log("Login méthode ajax");
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL + "connexion.php",
        data:{
            "action":"loginUser",
            "username":username,
            "password":passwd
        },  
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}


/**
 * Fonction permettant de créer un utilisateur.
 * @param {string} UserConnected Nom d'utilisateur de l'utilisateur.
 * @param {string} pkUserConnected pk de l'utilisateur.
 * @param {function} successCallback Fonction de callback en cas de succès de la requête.
 * @param {function} errorCallback Fonction de callback en cas d'erreur de la requête.
 */
function getUserProjet(userConnected, pkUserConnected, successCallback, errorCallback) {
    console.log("----------------")
    console.log("Login méthode ajax");
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: BASE_URL + `projet.php?action=getProjetUser&username=${userConnected}&pkuser=${pkUserConnected}`,
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}


function logout(userConnected, successCallback, errorCallback) {
    console.log("----------------")
    console.log("Login méthode ajax");
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL + "connexion.php",
        data:{
            "action":"logoutUser",
            "username":userConnected
        },  
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}





