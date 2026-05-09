# Issue 02 - Ajouter endpoints preview

## Labels

`module:1-foundations`, `area:preview`, `area:http`, `area:ui`, `type:feature`, `priority:p0`, `status:ready`

## Objectif

Exposer les endpoints MVP qui permettent a une app mobile ou WebView de consommer le rendu JSON d'une page Velt.

## Endpoints cible

```text
GET /api/preview/{id}
GET /api/session/{id}
```

## Travail attendu

- Creer `PreviewController`.
- Lire la session via `PreviewSessionStore`.
- Charger la page Velt associee.
- Utiliser `JsonRenderer` pour produire la reponse.
- Retourner 404 si la session n'existe pas.

## Contraintes

- Ne pas faire de hot reload dans cette issue.
- Ne pas coupler le controller a une implementation concrete du renderer si un contrat existe.
- Le JSON doit etre celui du sous-module UI Rendering.

## Criteres d'acceptation

- `/api/session/{id}` retourne les informations de session.
- `/api/preview/{id}` retourne la page en JSON.
- Une session inconnue retourne une response JSON 404.
- Les tests couvrent succes et erreur.

## Definition of Done

- Controller implemente.
- Routes documentees.
- Tests integration HTTP simples.

