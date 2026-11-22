# Charte commune des plugins GLPI de parime

Référence unique pour tous les plugins, existants et à venir : GRC Manager (`grcmanager`), AssetSign
(`assetsign`), Configuration GLPI Auto (`configurationglpiauto`), Inventaire Docker
(`dockerinventory`) et tout plugin créé depuis ce modèle. Contributeurs et assistants de code la
lisent avant toute modification ; chaque `AGENTS.md` et chaque `README.md` y renvoie.

Principe directeur : **un plugin simplifie GLPI, il ne le complique pas.** Il s'installe dans GLPI
sans en changer les habitudes, se règle depuis sa propre page et n'ajoute qu'une seule entrée de menu.

Chaque règle donne **la règle**, **la raison** et **le contrôle** : *auto* (nom du contrôle
automatique, presque toujours dans [glpi-plugin-security](https://github.com/parime/glpi-plugin-security),
appelé par le workflow `security.yml` de chaque plugin) ou *revue* (relecture de PR). Les contrôles
« charte » et le contrôle des menus sont **bloquants** depuis glpi-plugin-security v1.9.0 (avertissement
de v1.7.0 à v1.8.x, le temps de corriger les écarts des plugins existants).

## 1. Licence et attribution

| Règle | Raison | Contrôle |
|---|---|---|
| Licence **GPL-3.0-or-later** partout : `LICENSE` (texte de la GPL v3), `'license' => 'GPL-3.0-or-later'` dans `setup.php`, `composer.json` et `CITATION.cff`. Pas de `GPLv3` ni `GPL-3.0-only`. | Un identifiant SPDX unique et exact : la marketplace, Composer et les outils de conformité le lisent tels quels. | auto : charte |
| En-tête de licence en tête de chaque fichier PHP et Twig : le bloc de `tools/HEADER` (commentaire `/** */` en PHP, `{# #}` en Twig). Les fichiers d'outillage (`.github/`, fichiers cachés, `tests/`) en sont dispensés. | La GPL demande que chaque fichier copié garde son titulaire et sa licence ; c'est la seule trace qui suit un fichier isolé. | auto : charte |
| `NOTICE` (titulaire, adresse du dépôt), `CITATION.cff`, `AGENTS.md` (consignes d'attribution pour les assistants, en anglais) et une section « Réutilisation et citation » dans `README.md` / « Reuse and citation » dans `README.en.md`. | Rendre la réutilisation conforme facile, y compris par un assistant de code. | auto : charte |
| Dépendance tierce : licence compatible GPL v3, citée dans `NOTICE` si son code est inclus. | Distribuer l'archive sans risque. | revue |

## 2. Traductions

| Règle | Raison | Contrôle |
|---|---|---|
| **18 langues** : `de_DE en_GB en_US es_419 es_AR es_CL es_CO es_EC es_ES es_MX es_VE fr_BE fr_CA fr_FR it_IT pl_PL pt_BR pt_PT`. Langues de base traduites : fr_FR, en_GB, de_DE, es_ES, it_IT, pl_PL, pt_BR ; les variantes sont des copies générées par `sync-locale-variants.sh`. | GLPI ne se replie pas d'une variante (es_MX) vers sa langue de base (es_ES) : sans copie, l'utilisateur voit la langue de l'instance. | auto : charte (fichiers présents) ; CI du plugin : `sync-locale-variants.sh --check` |
| Chaque langue de base traduit **chaque** chaîne ; le `.pot` est versionné et régénéré par `vendor/bin/extract-locales` (glpi-project/tools). | Une chaîne non traduite s'affiche dans la langue du code source. | CI du plugin : job « Traductions complètes » |
| Toute chaîne affichée passe par `__()`, `_n()`, `_x()` avec le domaine du plugin ; jamais de concaténation de phrases, `sprintf()` avec `%s`. | Les traducteurs voient la phrase entière ; l'ordre des mots change selon la langue. | revue |
| Une traduction n'ajoute rien d'actif (balise, URL, JavaScript, `##…##`). | Les chaînes traduites sont souvent affichées sans échappement. | auto : traductions |
| **Langue des msgid : anglais pour tout nouveau plugin** (voir ci-dessous). Un plugin n'en mélange jamais deux. | Convention du cœur GLPI et des plugins de la marketplace. | revue |

**Décision sur la langue des msgid.** Le cœur de GLPI, ses plugins officiels et les plateformes de
traduction travaillent depuis des chaînes sources en anglais : les traducteurs allemands, italiens
ou polonais lisent l'anglais plus souvent que le français, une chaîne du cœur (`__('Save')`) se
réutilise telle quelle, et une chaîne non encore traduite s'affiche en anglais, compris de tous.
GRC Manager suit déjà cette convention. AssetSign (~1 500 chaînes), Configuration GLPI Auto (~1 200)
et Inventaire Docker (~400) ont des msgid en français : **aucune migration imposée**. Leurs 18
langues sont complètes et vérifiées par la CI, donc l'utilisateur ne voit aucune différence ; le
seul gain viendrait des traducteurs extérieurs. Une migration coûterait la réécriture de toutes les
chaînes, de toutes les traductions et des tests qui comparent des libellés. L'ouverture à Weblate
(section 2 bis) ne l'impose pas non plus : Weblate accepte une langue source française, et chaque
traducteur peut y afficher la traduction anglaise en « langue secondaire » à côté de la source.
Si les retours des traducteurs montrent que la source française les gêne, la migration est engagée
plugin par plugin, en commençant par Inventaire Docker (plugin jeune, ~400 chaînes), idéalement
avant sa version 1.0.0. Le plan (script de correspondance msgid français vers anglais appliqué au
code, aux Twig et aux `.po`) est décrit dans l'issue « langue des msgid » de chaque plugin concerné.

## 2 bis. Traductions collaboratives (Weblate)

Les plugins seront ouverts aux traducteurs sur **Hosted Weblate**, offre « Libre » (gratuite pour
les projets libres), dès que le compte du projet est créé. Règles, applicables dès maintenant :

| Règle | Raison | Contrôle |
|---|---|---|
| **Source unique : le `.pot`**, régénéré en CI depuis le code (`vendor/bin/extract-locales`) et versionné ; le job « Traductions complètes » échoue si le `.pot` versionné n'est pas à jour. Weblate lit le `.pot` et les `.po` du dépôt, jamais une copie. | Les traducteurs travaillent sur les chaînes réellement affichées, sans dérive. | CI du plugin |
| **Weblate propose, la CI dispose** : Weblate pousse sur une branche et ouvre une **PR** (jamais d'écriture directe sur la branche principale) ; la PR passe la CI comme toute autre, avec sa ligne de CHANGELOG. | Une traduction est une contribution comme une autre : relue et contrôlée. | protection de branche |
| Le **contrôle de complétude** reste (chaque langue de base traduit chaque chaîne), ainsi que le contrôle « traductions sans contenu actif » et `sync-locale-variants.sh` : Weblate ne gère que les langues de base, les variantes restent des copies générées. | Une contribution partielle ou piégée ne passe pas. | CI du plugin ; auto : traductions |
| Les traductions générées par IA sont la **base de départ** : publiées complètes, puis corrigées par les contributeurs dans Weblate (une chaîne corrigée y est marquée relue). | Toutes les langues utilisables dès la première version, qualité améliorée par ceux qui la parlent. | revue |
| Chaque chaîne nouvelle arrive traduite dans la PR qui l'ajoute ; Weblate sert à corriger et à ajouter des langues, pas à combler un manque. | Pas de version publiée avec des trous. | CI du plugin |

Une fois le projet Weblate créé, chaque README reçoit une ligne, dans sa section Documentation ou
Contribuer : « Contributions de traduction bienvenues sur Hosted Weblate : <adresse du projet> »
(README.en.md : « Translation contributions are welcome on Hosted Weblate: <project URL> »).
L'adresse n'est ajoutée qu'une fois le projet réellement créé.

## 3. Sécurité

| Règle | Raison | Contrôle |
|---|---|---|
| Workflow commun `security.yml` à la **dernière étiquette** de glpi-plugin-security, job obligatoire dans la protection de branche. | Les mêmes contrôles partout, mis à jour ensemble. | auto : audit hebdomadaire de glpi-plugin-security |
| Droit vérifié dans chaque point d'entrée (`front/`, `ajax/`) : `Session::checkRight()`, `->check($id, READ)` ; droit sur l'**enregistrement** (`$item->can()`), jamais le seul droit global ; entité lue dans la requête validée par `Session::haveAccessToEntity()`. | Un utilisateur d'une entité ne lit ni ne modifie celles des autres. | auto : Semgrep communes ; `check-entrypoints-auth.sh` (security.yml, v1.8.0) |
| **Matrice d'accès** de bout en bout (`tests/security/access-matrix.sh`) : chaque page exercée par un profil délégué, ou justifiée dans `not-covered.txt`. | Un écran ajouté sans test d'accès fait échouer la CI. | auto : `check-security-matrix-coverage.sh` (security.yml, v1.8.0) |
| Contenu d'un onglet : `displayTabContentForItem()` contrôle lui-même le droit. Chaque droit du plugin s'attribue depuis l'onglet du plugin sur les profils. | `ajax/common.tabs.php` ne consulte pas `getTabNameForItem()`. | auto : contrôles dans un vrai GLPI |
| Affichage par **Twig uniquement**, sans `\|raw` sur une donnée non purifiée ; test XSS (`tests/security/xss-check.sh`). | Échappement automatique. | auto : Semgrep `glpi-twig-raw-output` ; CI du plugin : marketplace (cliquet HTML en PHP), xss-check |
| **Pas de SQL brut** hors installation et migrations : `$DB->request()`, `insert()`, `update()`, `delete()`. | Requêtes préparées ; exigence de la marketplace. | auto : `check-marketplace-readiness.php` (security.yml, v1.8.0) |
| Formulaires en POST avec le jeton CSRF de GLPI (`csrf_compliant`) ; aucune action qui modifie en GET. | Protection CSRF du cœur. | revue |
| Fichier déposé : taille, type MIME réel et extension vérifiés, stocké par `Document` du cœur ; test `upload-check.sh` dès qu'un plugin accepte un dépôt. | Pas de fichier exécutable ni d'image piégée. | revue ; CI du plugin |
| **Appels HTTP sortants** par le client de GLPI seulement (`src/Compat/Http.php` : `Toolbox::getGuzzleClient()` en GLPI 11, `Glpi\Toolbox\HttpClient` en GLPI 12), avec un **contexte** (classe du plugin) qu'un administrateur peut ajouter à `GLPI_SERVERSIDE_URL_ALLOWED_PRIVATE_NETWORKS_CONTEXTS`, sans suivre les redirections. Jamais `curl_*` ni `file_get_contents()` sur une URL. | Proxy de GLPI respecté, réseaux privés fermés par défaut (SSRF), clé d'API jamais renvoyée vers un autre serveur. | revue |
| Secrets (clés d'API, mots de passe) chiffrés par `GLPIKey`, jamais affichés en clair après saisie. | Une sauvegarde de base ne livre pas les accès. | revue |
| Cible de notification du plugin ≥ 1000 ; document généré non récursif ; désinstallation sans reste dans les tables du cœur. | Défauts relevés par les revues de la marketplace. | auto : contrôles dans un vrai GLPI |

## 4. Structure

```
setup.php  hook.php            déclaration et hooks ; installation, mises à jour, désinstallation
src/                           classes PSR-4, espace de noms GlpiPlugin\<Clé>\ (dossier plat)
src/Compat/                    différences GLPI 11 / 12 (Http.php...), un seul endroit
src/Install/                   installateur et migrations versionnées (si le plugin a des tables)
front/  ajax/                  points d'entrée minces : droit, lecture de la requête, rendu Twig
templates/                     Twig ; partiels préfixés « _ » (_page_help, _badge, _section_nav)
public/css/<clé>.css           classes bg-X-subtle / text-X-emphasis des couleurs nommées (section 8)
locales/                       <clé>.pot et les 18 .po (+ .mo générés)
tests/Unit  tests/Integration  tests/security
tools/HEADER                   en-tête de licence
.github/workflows  .github/scripts
```

- Nouveau code dans `src/` (pas de `inc/*.class.php` ni de `src/GlpiPlugin/<Clé>/`) : c'est
  l'autochargement natif de GLPI 11 pour `GlpiPlugin\<Clé>\`. Les plugins existants migrent
  `inc/` au fil des modifications. *revue*
- Toute table est créée et migrée par l'installateur avec `Migration`, et supprimée par la
  désinstallation, avec tout ce que le plugin a écrit dans le cœur (droits, configuration,
  notifications, liens). *auto : désinstallation*
- `vendor/` n'est pas versionné : l'archive de release l'installe (`composer install --no-dev`).
  L'archive ne contient aucun fichier de développement. *auto : archive*

## 5. Logique et principes

- **Lecture seule vers les systèmes extérieurs** (Portainer, WUD, Harbor, Jira, NVD, HIBP...) :
  le plugin lit, il ne redéploie, ne supprime, ne ferme rien chez eux. Comptes aux droits minimaux.
- **Rien ne change tout seul dans GLPI** : jamais de changement automatique de statut, de priorité,
  d'affectation ou de droit. Le plugin **propose** (ticket proposé, alerte, action suggérée) et un
  humain valide. Un objet disparu de la source est marqué « retiré », pas supprimé.
- **Imports idempotents avec aperçu** : relancer un import ne crée pas de doublon (clé de la source
  conservée) ; un aperçu montre ce qui sera créé ou modifié avant d'écrire ; un journal garde le
  résultat.
- **Entités respectées** : tout objet est créé dans l'entité de sa source ou celle choisie ;
  visibilité par `can()`.
- **Aucun appel sortant sans réglage explicite** d'un administrateur.

*Contrôle : revue (et principes rappelés dans la section « Principes » du README).*

## 6. Langage et compatibilité

- **GLPI 11 et 12** (`min 11.0.0`, `max 12.99.99`) ; **PHP 8.2 à 8.5** pour GLPI 11, 8.3 à 8.5
  pour GLPI 12 ; `declare(strict_types=1);` dans les nouveaux fichiers. *CI du plugin : job
  « php-compat » (chargement des classes sur chaque PHP) et installation réelle sur GLPI 12.*
- Différence entre versions de GLPI : un seul point, `src/Compat/`, testé sur les deux. *revue*
- Code, noms de classes et commentaires techniques en anglais ou en français, mais homogènes dans un
  fichier ; textes d'interface traduits (section 2).

## 7. Qualité et CI

Jobs attendus dans la CI de chaque plugin (en plus de `security.yml`) : CI officielle GLPI
(matrice), installation réelle GLPI 12, php-compat, **PHPStan niveau 6** (configurations GLPI 11 et
12), style (**PHP-CS-Fixer** avec `@PSR12`, lignes de 120 caractères au plus), **PHPUnit** unitaire
et intégration, traductions complètes, et CHANGELOG modifié dans chaque PR. Les points d'entrée, la
matrice d'accès et les exigences marketplace (SQL brut, Twig) sont vérifiés par `security.yml`. PHPCS reste admis là où il est déjà en place. Un niveau PHPStan ne baisse
jamais : un faux positif s'ignore ligne par ligne avec sa raison. *auto : CI du plugin*

## 8. Interface et visuel

- Composants de GLPI (Tabler/Bootstrap) ; icônes **Tabler** (`ti ti-*`) uniquement, pas de Font
  Awesome ; aucune couleur ni style en ligne quand une classe existe.
- **Badges** de statut avec icône et couleur constantes d'un plugin à l'autre (partiel
  `_badge.html.twig`) :

  | Sens | Classe | Exemple |
  |---|---|---|
  | conforme, terminé, à jour | `bg-green-lt` | `ti-circle-check` |
  | à surveiller, bientôt échu | `bg-orange-lt` | `ti-alert-triangle` |
  | en retard, critique, refusé | `bg-red-lt` | `ti-alert-octagon` |
  | en cours, information | `bg-blue-lt` | `ti-loader` |
  | neutre, retiré, sans objet | `bg-secondary-lt` | `ti-circle-dashed` |

- **Classes `*-subtle` et `*-emphasis` des couleurs nommées** : GLPI et Tabler ne définissent
  `bg-X-subtle`, `text-X-emphasis` et `border-X-subtle` que pour les couleurs de thème (`primary`,
  `secondary`, `success`, `info`, `warning`, `danger`, `light`, `dark`). Pour les couleurs nommées
  de Tabler (`blue`, `azure`, `indigo`, `purple`, `pink`, `red`, `orange`, `yellow`, `lime`,
  `green`, `teal`, `cyan`), elles n'existent pas et le badge s'affiche **sans fond**. Chaque plugin
  embarque donc la feuille commune `public/css/<clé>.css` (copie de celle du modèle, mêmes teintes
  partout, variante sombre sous `[data-bs-theme="dark"]`, repli sur `--tblr-X-*` si Tabler les
  fournit un jour), chargée sur toutes les pages par
  `$PLUGIN_HOOKS[Hooks::ADD_CSS]['<clé>'] = ['css/<clé>.css'];` dans `setup.php`, et le test
  `tests/Unit/SubtleColorClassesTest.php`. Ce test échoue si le code (Twig, PHP, JS) utilise une
  classe de ce type que ni Tabler ni la feuille ne définissent, écrite en clair
  (`bg-orange-subtle`) ou construite depuis un nom de couleur (`bg-{{ color }}-subtle` avec
  `'color' => 'orange'` côté PHP). Le plugin qui n'utilise encore aucune couleur nommée garde le
  test, qui protège l'avenir. Les classes `bg-X-lt` du tableau ci-dessus existent pour toutes les
  couleurs et ne demandent rien. *auto : PHPUnit du plugin*
- **Encadré d'aide** en tête de chaque page d'usage (partiel `_page_help.html.twig`) : « À quoi
  sert cette page ? », ce qui est attendu de l'utilisateur, référence éventuelle ; repliable,
  choix mémorisé.
- Page d'usage : titre, encadré d'aide, onglets de rubrique (`_section_nav.html.twig`) si la page
  regroupe plusieurs écrans, puis le contenu ; état vide qui dit quoi faire ensuite.
- Formulaires par les macros du cœur (`components/form/fields_macros.html.twig`), aide visible
  sous le champ (`form-hint`) plutôt que cachée derrière un « ? ».
- Testé dans le navigateur comme un utilisateur non technique : libellés, liens, guidage.

*Contrôle : revue (captures dans la PR pour tout écran nouveau ou modifié).* Exemple complet dans
`templates/` de ce modèle.

## 9. Menus et réglages

- **Tous les réglages dans la page de configuration du plugin** (`Hooks::CONFIG_PAGE`, ouverte
  depuis Configuration > Plugins), organisée en **onglets**. Pas de réglage ailleurs. Accès :
  droit `config` de GLPI (ou droit de configuration propre au plugin).
- **Une seule entrée de menu d'usage au plus** (`Hooks::MENU_TOADD`), dans le secteur natif qui
  convient (Parc, Assistance, Outils...), avec onglets ou sous-pages pour ses écrans. Pas d'entrée
  dans Configuration ou Administration pour des réglages, ni de secteur de menu propre. Exception :
  un plugin dont l'usage même est de configurer GLPI (Configuration GLPI Auto) a sa seule entrée
  dans Configuration, et elle mène à sa page de configuration.
- **Exception « outil métier complet »** : un plugin qui est une application métier à part entière
  (plusieurs modules d'usage pour des publics différents, comme GRC Manager) peut avoir **son propre
  secteur de menu**, qui regroupe ses écrans d'usage. Ses réglages restent dans sa page de
  configuration, et il n'ajoute pas d'autre entrée dans les secteurs natifs sans justification. Il
  le déclare dans le fichier d'exceptions des contrôles de sécurité par la ligne
  `menus-secteur-metier : <justification>` ; le contrôle « menus » compte alors ce secteur comme
  une seule entrée.
- Les objets natifs de GLPI (ordinateurs, applications, tickets) reçoivent des **onglets**, pas de
  nouveau menu.
- Toute adresse retirée redirige vers la nouvelle (favoris des utilisateurs).

*Contrôle : auto, contrôle « menus » des contrôles dans un vrai GLPI (bloquant au-delà d'une entrée) ;
revue pour les réglages.*

## 10. Documentation

| Fichier | Contenu | Contrôle |
|---|---|---|
| `README.md` (français) et `README.en.md` (anglais) | Présentation, Principes, Compatibilité, Installation, Utilisation, Documentation, Réutilisation et citation, Licence ; lien vers cette charte | auto : charte (fichiers, réutilisation, lien) |
| `CHANGELOG.md` | [Keep a Changelog](https://keepachangelog.com/fr/1.1.0/), section `## [Unreleased]`, une ligne par PR ; SemVer | auto : charte ; CI du plugin |
| `AGENTS.md` | Attribution, règles de contribution, lien vers cette charte | auto : charte |
| `SECURITY.md`, `NOTICE`, `CITATION.cff` | Signalement privé ; titulaire ; citation | auto : charte |
| `ROADMAP.md`, `ARCHITECTURE.md`, guide utilisateur (`USER_GUIDE.md` ou `docs/`) | Conseillés dès que le plugin dépasse quelques écrans | revue |

## 11. Publication

- Version dans `setup.php` (`PLUGIN_<CLÉ>_VERSION`) ; sa modification fusionnée dans la branche
  principale crée l'étiquette (`auto-tag.yml`), qui lance `release.yml` : archive `git archive` +
  `composer install --no-dev`, publication GitHub, PR de mise à jour du catalogue `<clé>.xml` de la
  marketplace avec sa ligne de CHANGELOG. Copier ces workflows depuis le plugin le plus récent.
- Chaque lot fini et testé part en version, sans attendre (GRC : `dev` puis `main`, puis `main`
  ramené dans `dev` par un merge commit).

## 12. Commits, PR et issues

- Commits et titres de PR : préfixe Conventional Commits (`feat`, `fix`, `docs`, `chore`, `ci`,
  `style`, `test`, `refactor`) puis description **en français** ; corps qui dit pourquoi.
- PR en français, liée à son issue, avec sa ligne de CHANGELOG et des captures pour l'interface.
- Issues en français : besoin ou constat, proposition, liste de cases à cocher.

## 13. Données et typographie

- **Données fictives** dans les tests, captures et documentation : `example.org`, adresses IP de
  documentation (192.0.2.0/24, 198.51.100.0/24, 203.0.113.0/24), personnes et sociétés inventées.
  *revue*
- **Pas de tiret cadratin** (U+2014) : « : », virgule, parenthèses ou « - ». *auto : typographie*

## Contrôles automatiques et évolution

| Contrôle (glpi-plugin-security) | Règles | Mode |
|---|---|---|
| Règles Semgrep communes | 3 | bloquant |
| Traductions sans contenu actif | 2 | bloquant |
| Aucun tiret cadratin | 13 | bloquant |
| Archive de release sans fichier de développement | 4 | bloquant |
| Workflows GitHub Actions valides | 7 | bloquant |
| Contrôles dans un vrai GLPI (onglets, droits, notifications, désinstallation) | 3, 4 | bloquant |
| Contrôles dans un vrai GLPI : menus | 9 | bloquant (v1.9.0) |
| Charte commune (licence, documentation, langues) | 1, 2, 10 | bloquant (v1.9.0) ; `charter-mode: warning` le temps d'une mise en conformité |

Modifier la charte : PR sur ce dépôt (glpi-plugin-template), avec, si une règle devient
vérifiable, son contrôle dans glpi-plugin-security (cas secbad/secgood) et une issue dans chaque
plugin en écart. Une règle plus stricte arrive en avertissement pour une version, puis en bloquant.
