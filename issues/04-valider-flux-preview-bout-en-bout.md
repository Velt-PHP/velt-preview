# Issue 04 - Valider le flux preview de bout en bout

## Labels

`module:1-foundations`, `area:preview`, `area:http`, `area:ui`, `type:tests`, `priority:p0`, `status:ready`

## Objectif

Prouver que la preview fonctionne reellement en connectant session, routing HTTP, chargement de page UI et rendu JSON.

## Pourquoi cette issue est obligatoire

Le module preview est un module d'integration. Il ne suffit pas de tester chaque classe separement. Il faut un test qui montre le flux complet attendu par le MVP.

## Scenario attendu

1. Une page Velt `auth.login` existe.
2. Une session preview est creee pour cette page.
3. Une requete GET arrive sur `/api/preview/{id}`.
4. Le controller retrouve la session.
5. Le `ViewFactory` charge la page.
6. Le `JsonRenderer` transforme la page.
7. La response JSON contient `screen`, `schemaVersion` et `components`.

## Contraintes

- Ne pas utiliser de WebSocket dans le Module 1.
- Ne pas exiger une vraie application mobile.
- Ne pas dependre d'un serveur HTTP externe dans les tests.

## Criteres d'acceptation

- Le test de bout en bout retourne un status 200.
- Le JSON contient le nom de la page.
- Le JSON contient au moins un composant.
- Une session inconnue retourne 404.
- Une vue introuvable retourne une erreur JSON claire.

## Definition of Done

- Test integration preview ajoute.
- Documentation du flux preview mise a jour.
- Exemple de payload JSON fourni.

