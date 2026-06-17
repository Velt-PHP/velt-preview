# Sous-module 06 - Preview API

## Gestion des dépendances

Les dépendances sont **centralisées** au niveau du dossier `velt-preview` :

```bash
cd velt-preview
composer install
```

Un seul `composer.json` gère toutes les dépendances des 7 sous-modules.

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
- erreurs 404/410/500 normalisees ;
- **parser Velt pour fichiers .velt** ;
- **structure AST pour les composants** ;
- **VeltView avec fromSession() et toJson()** ;
- **génération d'image QR code (SVG)**.

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

## Architecture des nouveaux modules

### velt-ast
Structure de l'AST (Abstract Syntax Tree) pour les composants Velt :
- `NodeInterface` - Interface de base pour tous les nœuds
- `VStack`, `HStack` - Conteneurs vertical/horizontal
- `Text`, `Button`, `Input` - Composants de base
- `Container` - Conteneur générique
- `AST` - Racine de l'arbre avec méthode `toArray()`

### velt-parser
Parser pour les fichiers `.velt` :
- `VeltParser` - Transforme le contenu d'un fichier .velt en AST
- Supporte l'indentation pour la structure hiérarchique
- Parse les props au format `key="value"`

### velt-view
Couche de chargement et rendu des vues :
- `VeltView` - Classe principale avec `fromSession()` et `toJson()`
- `VeltPageRepository` - Repository implémentant `PageRepositoryInterface`
- Charge les fichiers `.velt` depuis le système de fichiers

### Format des fichiers .velt

```velt
VStack class="flex-1 p-4"
  Text value="Se connecter" class="text-2xl font-bold mb-4"
  Input name="email" label="Email" type="email" class="mb-4"
  Input name="password" label="Mot de passe" type="password" class="mb-4"
  Button text="Connexion" class="bg-blue-500 text-white"
```

### Flux complet

```
fichier .velt → VeltParser → AST → VeltView::toJson() → JSON → API Preview
```

### Génération QR code

Le module Preview utilise la librairie `bacon/bacon-qr-code` pour générer des images QR code au format SVG :

- **CLI** : `php bin/velt preview auth.login` génère un fichier SVG
- **Service** : `preview.qr_generator` disponible dans le container
- **Formats** : SVG par défaut (extension PNG disponible si GD/Imagick installé)
- **Stockage** : `storage/qrcodes/{session_id}.svg`

## Issues

- [Issue 01 - Creer PreviewSession Store](issues/01-creer-preview-session-store.md)
- [Issue 02 - Ajouter endpoints preview](issues/02-ajouter-endpoints-preview.md)
- [Issue 03 - Integrer payload QR code CLI](issues/03-integrer-payload-qr-code-cli.md)
- [Issue 04 - Valider le flux preview de bout en bout](issues/04-valider-flux-preview-bout-en-bout.md)
- [Issue 05 - Stabiliser contrat JSON preview et erreurs](issues/05-stabiliser-contrat-json-preview-erreurs.md)
