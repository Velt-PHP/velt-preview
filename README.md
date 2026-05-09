# Sous-module 06 - Preview API

## Mission

Ce sous-module connecte le monde Web et le monde mobile preview. Il gere les sessions de preview, expose les endpoints JSON et fournit les donnees necessaires au QR code.

Le but du Module 1 n'est pas de faire un Expo Go complet, mais de prouver que Velt peut rendre une meme page en Web et en JSON mobile.

Preview est un module d'integration. Il doit donc etre plus strict sur ses contrats : format JSON stable, erreurs propres, session preview testable et aucune dependance cachee a une implementation UI ou HTTP non documentee.

## Perimetre

Inclus :

- session de preview ;
- mapping session vers page Velt ;
- endpoint `GET /api/preview/{id}` ;
- endpoint `GET /api/session/{id}` ;
- payload QR code ;
- stockage fichier simple pour le MVP ;
- schema JSON preview versionne ;
- erreurs 404/410/500 normalisees.

Exclus :

- WebSocket ;
- hot reload ;
- rendu natif complet ;
- app mobile officielle complete.

## Comment tester sans client mobile officiel

Le Module 1 n'a pas besoin d'une vraie app mobile pour valider Preview.

- Creer une page Velt fake ou une implementation `JsonableInterface` fake.
- Creer une session preview dans un store fichier temporaire.
- Appeler le controller ou handler preview avec une request fake.
- Verifier que le JSON contient `screen`, `schemaVersion`, `components` et `meta`.
- Verifier les cas d'erreur : session inconnue, page introuvable, JSON invalide.
- Verifier que le payload QR-ready contient une URL HTTP exploitable et l'identifiant de session.

Le test bout-en-bout avec le vrai UI et le vrai HTTP appartient au sous-module 07. Les tests unitaires de Preview doivent rester rapides et isolables.

## Issues

- [Issue 01 - Creer PreviewSession Store](issues/01-creer-preview-session-store.md)
- [Issue 02 - Ajouter endpoints preview](issues/02-ajouter-endpoints-preview.md)
- [Issue 03 - Integrer payload QR code CLI](issues/03-integrer-payload-qr-code-cli.md)
- [Issue 04 - Valider le flux preview de bout en bout](issues/04-valider-flux-preview-bout-en-bout.md)
- [Issue 05 - Stabiliser contrat JSON preview et erreurs](issues/05-stabiliser-contrat-json-preview-erreurs.md)
