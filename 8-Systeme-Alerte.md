# SQL Avancé - TP

## Système d'alerte

Dans le cadre de la création d'un système d'alerte de recherche, nous souhaitons informer les utilisateurs lorsque des annonces correspondant à leur recherche apparaissent.
Par exemple : si je publie une annonce d'offre de foncier dans le Rhône, je veux être tenu au courant des annonces de recherche de fonciers qui sont publiés par d'autres utilisateurs dans la même zone.

Des colonnes et relations similaires (voire identiques) existent dans land_offer_ads et land_seek_ads. Et s'il était possible de créer une tâche automatique en PHP pour trouver des correspondances et mettre en contact la demande et l'offre ? 
Vous êtes chargé de trouver les requête SQL qui alimenteront ce système. 

### A - Trouver les demandeurs qui sont dans la même région que des offreurs et proposent des types de production identique

### B - Trouver les demandeurs qui sont dans le même département que des offreurs, et qui demande une surface min/max correspondante à une surface proposée par un offreur 

[To Be Continued... Proximité géographique](./9-Proximite-Geographique.md)