/*
 * Couche de services HTTP (worker).
 *
 * @author Olivier Neuhaus
 * @version 1.0 / 20-SEP-2013
 */

//var BASE_URL = "http://localhost:8081/";
var BASE_URL = "https://paccauds.emf-informatique.ch/151/server/";

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
        data: {
            "action": "createUser",
            "username": username,
            "password": passwd
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
        data: {
            "action": "loginUser",
            "username": username,
            "password": passwd
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
    console.log("get User Projet méthode ajax");
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
        data: {
            "action": "logoutUser",
            "username": userConnected
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}



function createTask(projetSelectionner, successCallback, errorCallback) {
    console.log("----------------")
    console.log("Create task méthode ajax :" + projetSelectionner);
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL + "tache.php",
        data: {
            "action": "createTask",
            "projet": projetSelectionner
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function moveTask(blockValue, pkTacheCreeValue, userPK, successCallback, errorCallback) {
    console.log("----------------")
    console.log("moveTask task méthode ajax");
    console.log(blockValue);
    console.log(pkTacheCreeValue);
    $.ajax({
        type: "PUT",
        dataType: "JSON",
        url: BASE_URL + "tache.php",
        data: {
            "action": "moveTask",
            "blockNewLocation": blockValue,
            "tacheMove": pkTacheCreeValue,
            "userPK": userPK,
        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}

function modifyTask(pkTask, nomTask, successCallback, errorCallback) {
    console.log("----------------")
    console.log("modifyTask task méthode ajax");
    console.log(pkTask);
    console.log(nomTask);

    $.ajax({
        type: "PUT",
        dataType: "JSON",
        url: BASE_URL + "tache.php",
        data: {
            "action": "modifyTask",
            "pkTask": pkTask,
            "nomTask": nomTask,

        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}



function getTasksProjetAJax(projetPK, successCallback, errorCallback) {
    console.log("----------------")
    console.log("get tache Projet méthode ajax :" + projetPK);
    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: BASE_URL + `tache.php?action=getTasksProjet&projetPK=${projetPK}`,
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}




function createUserProjetAjax(pkUser, projectName, successCallback, errorCallback) {
    console.log("----------------")
    console.log("Création méthode ajax");
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: BASE_URL + "projet.php",
        data: {
            "action": "createUserProjet",
            "pkUser": pkUser,
            "projectName": projectName, // Utilisez le même nom de paramètre ici

        },
        xhrFields: {
            withCredentials: true
        },
        success: successCallback,
        error: errorCallback
    });
}






