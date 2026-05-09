# Issue 05 - Stabiliser contrat JSON preview et erreurs

## Labels

`module:1-foundations`, `area:preview`, `area:contracts`, `type:architecture`, `priority:p0`, `status:ready`

## Objectif

Definir un contrat JSON stable pour la preview mobile et normaliser les erreurs.

## Travail attendu

- Definir les champs obligatoires : `schemaVersion`, `screen`, `components`, `meta`.
- Definir le format d'erreur JSON.
- Distinguer session inconnue, session expiree, page introuvable et erreur interne.
- Documenter les status HTTP attendus : 200, 404, 410, 500.
- Aligner le contrat avec `JsonRenderer`.

## Exemple cible

```json
{
  "schemaVersion": "1.0",
  "screen": "Login",
  "components": [],
  "meta": {
    "source": "auth.login"
  }
}
```

## Criteres d'acceptation

- Une session valide retourne un JSON stable.
- Une session inconnue retourne une erreur JSON propre.
- Le client mobile peut distinguer erreur utilisateur et erreur serveur.
- Le contrat est documente dans le README Preview.

## Definition of Done

- Schema documente.
- Tests erreurs ajoutes.
- Integration avec JsonRenderer decrite.

