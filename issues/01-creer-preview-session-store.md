# Issue 01 - Creer PreviewSession Store

## Labels

`module:1-foundations`, `area:preview`, `type:feature`, `priority:p1`, `status:ready`

## Objectif

Creer un stockage simple des sessions de preview pour associer un identifiant a une page Velt.

## Exemple de session

```json
{
  "id": "fgh123",
  "view": "auth.login",
  "url": "http://127.0.0.1:8000/api/preview/fgh123",
  "createdAt": "2026-05-08T15:00:00+02:00"
}
```

## Travail attendu

- Creer `PreviewSession`.
- Creer `PreviewSessionStore`.
- Stocker les sessions dans un fichier JSON local pour le MVP.
- Ajouter creation, lecture et suppression de session.

## Contraintes

- Pas de Redis ou database obligatoire dans le Module 1.
- Les IDs doivent etre non predictibles mais simples.
- Le store doit etre testable avec un dossier temporaire.

## Criteres d'acceptation

- Une session peut etre creee pour une vue.
- Une session peut etre retrouvee par ID.
- Une session inconnue retourne null ou lance une exception documentee.
- Le fichier JSON reste lisible.

## Definition of Done

- Store implemente.
- Tests filesystem.
- Documentation du format de session.

