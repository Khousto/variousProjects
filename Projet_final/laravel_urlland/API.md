Ce document décrit l'ensemble des routes exposées par l'API.

# Users (Utilisateurs)

## ![](./public/IMG/get.svg) /users

Retourne la liste de tous les utilisateurs

### Appel

Aucun paramètre

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, nickname, email, password, logo, is_admin)

## ![](./public/IMG/get.svg) /users/{id}

Retourne un utilisateur 

### Appel

id : identifiant de l'utilisateur

### Réponse

200 : [JSON] Retourne un objet (id, nickname, email, password, logo, is_admin)

## ![](./public/IMG/get.svg) /deconnexion

Permet la déconnexion de l'utilisateur

### Appel

Aucun paramètre

### Réponse

200 : [TEXT] Retourne "deconnexion" si la déconnexion est réussie et supprime la valeur stokée dans $SESSION['id']

## ![](./public/IMG/get.svg) /user/isadmin

Permet de vérifier si l'utilisateur connecté est administrateur du site ou non (à partir de la valeur stokée dans $SESSION['id'])

### Appel

Aucun paramètre

### Réponse

200 : [TEXT] Retourne "is admin" si l'utilisateur est enregistré en tant qu'administrateur du site
400 : [TEXT] Retourne "is not admin" si l'utilisateur n'est pas enregistré en tant qu'administrateur du site

## ![](./public/IMG/put.svg) /user/{id}

Permet à un utilisateur de modifier ses informations

### Appel

id : identifiant de l'utilisateur
nickname : surnom de l'utilisateur
email : email de l'utilisateur
password : mot de passe de l'utilisateur
logo : logo de l'utilisateur

### Réponse

200 : [TEXT]  Retourne "modified user" si l'utilisateur a modifié son compte sans modifier son mot de passe
200 : [TEXT]  Retourne "complete modified user" si l'utilisateur a modifié son compte y compris son mot de passe

## ![](./public/IMG/put.svg) /admin/user

Permet à un administrateur de modifier les informations d'un utilisateur

### Appel

id : identifiant de l'utilisateur
nickname : surnom de l'utilisateur
email : email de l'utilisateur
password : mot de passe de l'utilisateur
logo : logo de l'utilisateur
is_admin : le status de l'utilisateur

### Réponse

200 : [JSON] Retourne un objet (id, nickname, email, password, logo, is_admin) si les données de l'utilisateur ont été mises à jour (excepté le mot de passe et le status)
200 : [JSON] Retourne un objet (id, nickname, email, password, logo, is_admin) si les données de l'utilisateur ont été mises à jour (excepté le mot de passe)
200 : [JSON] Retourne un objet (id, nickname, email, password, logo, is_admin) si les données de l'utilisateur ont été mises à jour (excepté le status)
200 : [JSON] Retourne un objet (id, nickname, email, password, logo, is_admin) si les données de l'utilisateur ont été mises à jour (y compris le mot de passe et le status)

## ![](./public/IMG/post.svg) /admin/user

Permet à un administrateur d'ajouter un utilisateur

### Appel

nickname : surnom de l'utilisateur
email : email de l'utilisateur
password : mot de passe de l'utilisateur

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, nickname, email, password, logo, is_admin) si les données de l'utilisateur ont été ajoutées

## ![](./public/IMG/post.svg) /connexion

Permet la connexion d'un utilisateur s'il est enregistré dans la base de données

### Appel

Aucun paramètre

### Réponse

200 : [JSON] Retourne un objet (id, nickname, email, password, logo, is_admin) si la connexion d'un administrateur est réussie
200 : [TEXT] Retourne "ok" si l'email de l'utilisateur est référencé mais si le mot de passe saisi est incorrect
404 : [TEXT] Retourne "unknown user" si l'email n'est pas référencé dans la base de données

## ![](./public/IMG/post.svg) /register/user

Permet à un utilisateur de s'inscrire au site

### Appel

nickname : surnom de l'utilisateur
email : email de l'utilisateur
password : mot de passe de l'utilisateur
passwordV2 : confirmation du mot de passe 

### Réponse

200 : [JSON] Retourne true si les données de l'utilisateur ont été ajoutées après vérification de la cohérence du mot de passe et de sa confirmation
200 : [JSON] Retourne false si les données de l'utilisateur n'ont pas été ajoutées après vérification de la cohérence du mot de passe et de sa confirmation

## ![](./public/IMG/post.svg) /user/number/connexion/{id}

Permet de compter le nombre de connexions d'un utilisateur

### Appel

id : identifiant de l'utilisateur

### Réponse

200 : [JSON] Retourne un objet (id, nickname, email, password, logo, is_admin) si le nombre de connexion a été mise à jour

## ![](./public/IMG/delete.svg) /user/{id}

Supprime un utilisateur ainsi que toutes ses publications et tous ses commentaires

### Appel

id : identifiant de l'utilisateur

### Réponse

200 : [JSON] Retourne true

# Posts (Publications)

## ![](./public/IMG/get.svg) /posts

Retourne la liste de toutes les publications classées par dates antéchronologiques

### Appel

Aucun paramètre

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, title, content, category, nb_like, id_user, created_at, updated_at)

## ![](./public/IMG/get.svg) /post/{id}

Retourne une publication 

### Appel

id : identifiant de la publication

### Réponse

200 : [JSON] Retourne un objet (id, title, content, category, nb_like, id_user, created_at, updated_at)

## ![](./public/IMG/get.svg) /user/{id}/posts

Retourne toutes les publications d'un utilisateur 

### Appel

id : identifiant de l'utilisateur

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, title, content, category, nb_like, id_user, created_at, updated_at)

## ![](./public/IMG/get.svg) /select/posts

Retourne la liste de toutes les publications classées par dates antéchronologiques correspondantes à la recherche dans la barre de recherche (sur le titre ou le contenu)

### Appel

search : mot renseigné dans la barre de recherche

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, title, content, category, nb_like, id_user, created_at, updated_at)

## ![](./public/IMG/get.svg) /stats/postsByCategory

Retourne la liste de toutes les publications classés par catégorie

### Appel

Aucun paramètre

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, title, content, category, nb_like, id_user, created_at, updated_at)


## ![](./public/IMG/get.svg) /stats/postsByUser

Retourne la liste de toutes les publications classés par utilisateur

### Appel

Aucun paramètre

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, title, content, category, nb_like, id_user, created_at, updated_at)

## ![](./public/IMG/get.svg) /stats/numberOf

Retourne le nombre total d'utilisateurs, de publications et de commentaires

### Appel

Aucun paramètre

### Réponse

200 : [JSON] Retourne un tableau associatif avec 3 clés "users", "posts", "comments" correspondant chacune au nombre total d'utilisateurs, de publications et de commentaires

## ![](./public/IMG/get.svg) /stats/numberTotal

Retourne le nombre total d'utilisateurs, de publications et de commentaires

### Appel

Aucun paramètre

### Réponse

200 : [JSON] Retourne un tableau associatif avec 1 clé "total" correspondant au nombre total de connexion sur le site

## ![](./public/IMG/get.svg) /stats/postsByDate

Retourne le nombre total de publications des 3 derniers jours

### Appel

Aucun paramètre

### Réponse

200 : [JSON] Retourne un tableau associatif avec 3 clés "aujourdhui", "hier", "avthier" correspondant au nombre de publications des 3 derniers jours

## ![](./public/IMG/put.svg) /post/{id}

Permet la modification d'une publication

### Appel

id : identifiant de la publication
title : titre de la publication
content : contenu de la publication
category : catégorie de la publication
picture : url de l'image d'illustration de la publication

### Réponse

200 : [JSON] Retourne un objet (id, title, content, category, nb_like, id_user, created_at, updated_at)

## ![](./public/IMG/put.svg) /like/{id}

Permet d'ajouter un like à une publication

### Appel

id : identifiant de la publication

### Réponse

200 : [JSON] Retourne un objet (id, title, content, category, nb_like, id_user, created_at, updated_at)


## ![](./public/IMG/post.svg) /post

Permet d'ajouter une publication

### Appel

title : titre de la publication
content : contenu de la publication
category : catégorie de la publication
picture : url de l'image d'illustration de la publication
id_user : l'identifiant de l'utilisateur rédigeant la publication

### Réponse

200 : [JSON] Retourne true

## ![](./public/IMG/delete.svg) /post/{id}

Supprime une publication

### Appel

id : identifiant de la publication

### Réponse

200 : [JSON] Retourne true


# Comments (Commentaires)

## ![](./public/IMG/get.svg) /user/{id}/comments

Retourne la liste de tous les commentaires postés par un utilisateur

### Appel

id : identifiant de l'utilisateur

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, content, id_user, id_post, nb_like, created_at, updated_at)

## ![](./public/IMG/get.svg) /post/{id}/comments

Retourne la liste de tous les commentaires liés à une publication

### Appel

id : identifiant de la publication

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, content, id_user, id_post, nb_like, created_at, updated_at)

## ![](./public/IMG/get.svg) /comment/{id}

Retourne un commentaire à partir de son identifiant

### Appel

id : identifiant du commentaire

### Réponse

200 : [JSON] Retourne un objet (id, content, id_user, id_post, nb_like, created_at, updated_at)


## ![](./public/IMG/put.svg) /comment

Permet de modifier un commentaire

### Appel

id : identifiant du commentaire
content : contenu du commentaire

### Réponse

200 : [JSON] Retourne un tableau d'objets (id, content, id_user, id_post, nb_like, created_at, updated_at)

## ![](./public/IMG/post.svg) /comment

Permet d'ajouter un commentaire

### Appel

content : contenu du commentaire
id_user : identifiant de l'utilisateur ayant rédigé le commentaire
id_post : identifiant de la publication lié au commentaire

### Réponse

200 : [JSON]  Retourne un objet (id, content, id_user, id_post, nb_like, created_at, updated_at) qui a la clé "comment"

## ![](./public/IMG/delete.svg) /comment/{id}

Supprime un commentaire

### Appel

id : identifiant du commentaire

### Réponse

200 : [JSON] Retourne true

## Auteur.rices
* **Clémence Vasseur** _alias_ [@Khousto](https://github.com/khousto)
* **Anaïs Letellier** _alias_ [@anaislet](https://github.com/anaislet)
* **Runyi Wang** _alias_ [@ry97](https://github.com/ry97)
