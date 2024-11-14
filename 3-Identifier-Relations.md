# SQL Avancé - TP

## Identifier les relations

Tout d'abord observer le schéma dans MySQL Workbench.
Votre première tâche sera d'identifier toutes les relations sur le diagramme et la migration.

Faites-vous des listes pour chaque entité que vous apercevez, ça vous aidera pour la suite !

J'aimerai que chaque élément de vos listes prennent la forme suivante :

```
Relation [TYPE-RELATION] entre [TABLE-1] et [TABLE-2] sur [TABLE-1.CLÉ-PRIMAIRE] = [TABLE-2.CLÉ-ÉTRANGÈRE]
```

Pour vous aidez un peu, voici ci-dessous la liste des entités à identifier avec pour chacune, un indice sur le nombre de relation à trouver.
Dans ma grande générosité, je vous montre une première relation !

### Ads : (4 relations à trouver)

-   Relation One-To-One entre ads et land_offer_ads sur ads.id = land_offer_ads.ad_id
-   Relation Many-To-One entre ads et users sur ads.user_admin_id = users.id
-   Relation One-to-One entre ads et land_seek_ads sur ads.id = land_seek_ads.ad_id
-   Relation Many-To-One entre ads et users sur ads.user_pp_id = users.id

### Cities : (2 relations à trouver)

-   Relation One-To-Many entre cities et users sur cities.id = users.zip_code_id
-   Relation Many-To-One entre cities et departments sur cities.department_code = departments.code

### Regions : (1 relation à trouver)

-   Relation One-To-Many entre regions et departments sur region.code = departments.region_code

### Departments : (2 relations à trouver)

-   Relation One-To-Many entre regions et departments sur region.code = departments.region_code
-   Relation Many-To-One entre cities et departments sur cities.department_code = departments.code

### Countries : (1 relation à trouver)

-   Relation One-To-Many entre countries et users sur countries.id = users.country_id

### Users : (4 relations à trouver)

-   Relation One-To-Many entre countries et users sur countries.id = users.country_id
-   Relation One-To-Many entre cities et users sur cities.id = users.zip_code_id
-   Relation Many-To-One entre ads et users sur ads.user_pp_id = users.id
-   Relation Many-To-One entre documents et users sur documents.user_id = users.id

### Documents : (1 relation à trouver)

-   Relation Many-To-One entre documents et users sur documents.user_id = users.id

### Production_genres : (1 relation à trouver)

-   Relation One-To-Many entre production_genres et production_genres sur production_genres.parent_id = production_genres.id

### Documentables : (??? relations à trouver 🙂)

-   Relation One-To-Many entre documentables et documentables sur documentables.documentable_id = documentables.id

[To Be Continued... Exercices simples](./4-Exercices-Simples.md)
