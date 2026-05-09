# Issue 03 - Integrer payload QR code CLI

## Labels

`module:1-foundations`, `area:preview`, `area:cli`, `type:feature`, `priority:p1`, `status:ready`

## Objectif

Preparer l'integration entre la commande `php velt preview` et les sessions de preview.

## Commande cible

```bash
php bin/velt preview auth.login
```

## Sortie attendue

```text
Preview session created:
ID: fgh123
URL: http://127.0.0.1:8000/api/preview/fgh123
QR payload: http://127.0.0.1:8000/api/preview/fgh123
```

## Travail attendu

- Creer un service `PreviewUrlGenerator`.
- Generer une session pour une vue demandee.
- Retourner une URL scannable.
- Preparer un champ `qrPayload`.
- Documenter qu'une vraie image QR peut etre ajoutee plus tard via une librairie dediee.

## Contraintes

- Ne pas imposer une dependance QR lourde dans le Module 1.
- Ne pas demarrer automatiquement le serveur si `serve` n'est pas lance.
- La commande doit expliquer l'URL a utiliser.

## Criteres d'acceptation

- `preview auth.login` cree une session.
- La sortie contient l'URL preview.
- Le payload est compatible avec une app mobile qui scanne un QR code.
- Les erreurs de vue inconnue sont lisibles.

## Definition of Done

- Service de generation implemente.
- Integration CLI documentee.
- Tests sur generation d'URL et creation de session.

