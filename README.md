# glpi-plugin-template

Modèle de plugin GLPI (11 et 12) de parime, avec les contrôles de sécurité communs déjà branchés
([parime/glpi-plugin-security](https://github.com/parime/glpi-plugin-security)).

## Démarrer un plugin

1. **Use this template** sur GitHub, puis cloner le nouveau dépôt.
2. Remplacer `monplugin` / `MONPLUGIN` par la clé du plugin (nom de son dossier dans `plugins/`),
   dans `setup.php`, `hook.php` et `.github/workflows/security.yml`.
3. Dans **Settings > Branches**, protéger la branche principale et rendre obligatoires les jobs
   « security / Règles Semgrep communes (GLPI) » et « security / Contrôles dans un vrai GLPI ».

## Règles de sécurité à garder en tête

Elles sont vérifiées à chaque push par le contrôle commun (détail dans son README) :

- un droit global (`Session::haveRight`) ne dit rien de l'entité d'un enregistrement : utiliser
  `$item->can($id, READ|UPDATE)` ;
- le contenu d'un onglet (`displayTabContentForItem()`) contrôle lui-même le droit :
  `ajax/common.tabs.php` ne consulte pas `getTabNameForItem()` ;
- un document généré (rapport PDF) est créé non récursif, dans l'entité de son objet source, et
  n'est lié qu'à lui ;
- une cible de notification propre au plugin a un identifiant ≥ 1000 ;
- la désinstallation retire tout ce que le plugin a écrit dans les tables du cœur ;
- toute saisie affichée est échappée (`htmlescape()`, Twig sans `|raw`).

Un faux positif se déclare dans `.glpi-security-exceptions`, avec sa justification.
