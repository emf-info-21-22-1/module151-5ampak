/*
 * Bean "Joueur".
 *
 * @author Neuhaus Olivier
 * @project Exercice 5
 * @version 1.0 / 13-SEP-2013
 */

var Joueur = function() {
};

/**
 * Setter pour le nom
 * @param String nom
 * @returns {undefined}
 */
Joueur.prototype.setNom = function(nom) {
  this.nom = nom;
};

/**
 * Setter pour le pk de l'équipe
 * @param Integer pk
 */
Joueur.prototype.setPk = function(pk) {
  this.pk = pk;
};

/**
 * Retourne la pk de l'équipe
 * @returns La pk de l'équipe
 */
Joueur.prototype.getPk = function () {
  return this.pk;
};


/**
 * Setter pour le nombre de points du joueur
 * @param int points
 * @returns {undefined}
 */
Joueur.prototype.setPoints = function(points) {
  this.points = points;
};

/**
 * Retourne le pays en format texte
 * @returns Le pays en format texte
 */
Joueur.prototype.toString = function () {
  return this.nom;
};

/**
 * Retourne le nombre de points du joueur
 * @returns Le nombre de points du joueur
 */
Joueur.prototype.getPoints = function () {
  return this.points;
};