# SQL Avancé - TP

## Verrous

Un modérateur s'apprête à modérer une annonce. Pour sécuriser l'édition et empêcher un autre modérateur de faire des modifications parallèles, nous devons bloquer les tables adéquates en écriture jusqu'à ce que la modération soit terminée.

Créons une table permettant de surveillé l'état de modération d'une annonce !

Créer une table *add_moderation_locking_status*

Elle prendrait : 
* id (primary key)
* ad_id
* status ou moderating (1 ou 0) 1 = bloqué
* user_id
* created_at

Imaginons un contexte ou un modérateur veut modifier une annonce de recherche. Au click sur un bouton "éditer" une requête partirait en base de données pour vérifier l'état de la modération de l'annonce sélectionné grâce à la table précédemment créée.  

Si l'annonce est en état "moderating" à true, le modérateur sera redirigé sur une autre page. 

Dans le cas où le champ serait à false, il rentrerait sur un formulaire de modification. On refait un insert dans la table avec un "moderating" à true .
À la soumission du formulaire, on recherche la ligne en base qui possède l'id de l'annonce, et change son état à false.

Le modérateur quitte la page sans avoir effectué une action. On capture l'événément avec Javascript ( onBeforeUnload ) de façon à déclencher un appel à une route PHP qui effacera la ligne de verrou. 

Si le modérateur est inactif un timer déclenchera un appel à une route PHP qui effacera la ligne de verrou.

[To Be Continued... Requêtes préparées](./12-Requetes-Preparees.md)