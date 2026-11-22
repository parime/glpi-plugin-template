# glpi-plugin-template

Modèle de plugin GLPI (11 et 12) de parime, conforme dès le départ à la
**[charte commune des plugins](CHARTE.md)** (licence, traductions, sécurité, structure, logique,
visuel, menus, documentation, publication) et avec les contrôles de sécurité communs déjà branchés
([parime/glpi-plugin-security](https://github.com/parime/glpi-plugin-security)).

> **CHARTE.md est la référence unique de tous les plugins.** Contributeurs et assistants de code la
> lisent avant toute modification d'un plugin.

## Ce que contient le modèle

| Élément | Fichiers |
|---|---|
| Déclaration, une seule entrée de menu d'usage (Outils), page de configuration | `setup.php`, `src/Menu.php`, `front/menu.php`, `front/config.php`, `src/Config.php` |
| Droits attribuables depuis les profils | `src/Profile.php`, `templates/profile_rights.html.twig` |
| Installation, désinstallation sans reste | `hook.php` |
| Visuel commun : encadré d'aide, badges, onglets de rubrique, configuration en onglets | `templates/_page_help.html.twig`, `_badge.html.twig`, `_section_nav.html.twig`, `menu.html.twig`, `config.html.twig` |
| Classes `bg-X-subtle` / `text-X-emphasis` des couleurs nommées de Tabler (badges, clair et sombre) | `public/css/monplugin.css` (hook `ADD_CSS`), `tests/Unit/SubtleColorClassesTest.php` |
| 18 langues, msgid en anglais, `.pot`, variantes régionales | `locales/`, `.github/scripts/sync-locale-variants.sh` |
| Licence et attribution | `LICENSE`, `NOTICE`, `CITATION.cff`, `AGENTS.md`, `tools/HEADER` |
| Documentation | `README.md`, `README.en.md`, `CHANGELOG.md`, `SECURITY.md` |
| CI | `.github/workflows/ci.yml` (syntaxe PHP 8.2 à 8.5, PHPUnit, traductions), `security.yml` (contrôles communs) |

## Démarrer un plugin

1. **Use this template** sur GitHub, puis cloner le nouveau dépôt.
2. Remplacer `monplugin` / `Monplugin` / `MONPLUGIN` / « Mon plugin » / « My plugin » par la clé et
   le nom du plugin, dans les noms de fichiers comme dans le code, les Twig, les `.po` et
   `.github/workflows/security.yml`. Adapter `NOTICE`, `CITATION.cff`, `tools/HEADER` (et l'en-tête
   des fichiers), `AGENTS.md` et les README.
3. **Supprimer `CHARTE.md`** du nouveau dépôt : la seule référence est celle de ce modèle, vers
   laquelle pointent déjà `AGENTS.md` et les README.
4. Dans **Settings > Branches**, protéger la branche principale et rendre obligatoires les jobs
   « security / ... » et « CI ».
5. Ajouter les workflows de publication (`auto-tag.yml`, `release.yml`) et le catalogue `<clé>.xml`
   en les copiant depuis le plugin le plus récent (charte section 11), ainsi que les jobs de CI
   complets (charte section 7).

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

## Réutilisation et citation

Ce modèle et le code qu'il produit sont sous GPL-3.0-or-later : conserver l'en-tête de chaque
fichier et `NOTICE`, et citer le projet d'origine (voir `CITATION.cff`).

## Licence

GPL-3.0-or-later, voir [LICENSE](LICENSE).
