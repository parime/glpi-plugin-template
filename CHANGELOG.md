# Changelog

Toutes les évolutions notables de ce projet sont consignées ici.

Le format suit [Keep a Changelog](https://keepachangelog.com/fr/1.1.0/), et ce projet adhère au
[Semantic Versioning](https://semver.org/lang/fr/).

## [Unreleased]

### Corrigé

- Accessibilité de l'encadré « Version du plugin » (relevé par le parcours commun des pages, axe-core) :
  badges de version, et badges « information » et « neutre » de `_badge.html.twig` (charte section 8),
  en `bg-*-subtle text-*-emphasis` (contraste suffisant) et lien
  « Voir les versions sur GitHub » souligné, reconnaissable sans la couleur.
- `src/Menu.php` ne redéclare plus `$rightname` : erreur fatale « Type of ...::$rightname must be string »
  en GLPI 12 dès l'activation du plugin ; le droit est vérifié par `canView()` (#12).

### Changed

- CI : contrôles de sécurité communs glpi-plugin-security v1.10.1 (secrets, dépendances, CodeQL, test de mise à jour depuis la version publiée, tests d'intégration en français, parcours de toutes les pages).
- CI : contrôles de sécurité communs glpi-plugin-security v1.9.0 (charte commune et contrôle des menus bloquants par défaut).
- CI : le contrôle « Sécurité commune » ne tourne plus sur chaque push de branche de travail, seulement sur les PR et les branches principales (moins d'exécutions en double et de notifications d'échec).

### Ajouté

- Composant commun « Version du plugin » (#12) : encadré en tête de l'onglet Général de la
  configuration (`templates/_plugin_version.html.twig`, classe `src/PluginVersion.php`, clé du plugin
  et dépôt en paramètres) avec la version installée, la dernière release GitHub et un badge « À jour »,
  « Mise à jour disponible » (notes de version, archive) ou « Dernière version inconnue » avec la raison
  et la date de la dernière vérification réussie. Lecture côté serveur par le client HTTP de GLPI
  (`src/Compat/Http.php`, proxy respecté), délai de 3 s, cache de 12 h, ETag, dernier résultat
  réutilisé en cas d'échec, option pour désactiver. Tests `tests/Unit/PluginVersionTest.php`,
  22 chaînes traduites, section 9 bis de la charte.
- Feuille commune `public/css/monplugin.css`, chargée par `Hooks::ADD_CSS` : classes `bg-X-subtle`,
  `text-X-emphasis` et `border-X-subtle` des douze couleurs nommées de Tabler (blue, azure, indigo,
  purple, pink, red, orange, yellow, lime, green, teal, cyan), en thème clair et sombre, absentes de
  GLPI et de Tabler (badges sans fond sinon). Reprise de GRC. Test `tests/Unit/SubtleColorClassesTest.php`
  (job CI « PHPUnit ») et règle documentée dans la charte, section 8 (#10).
- Charte commune des plugins (`CHARTE.md`), dont les traductions collaboratives (Hosted Weblate).
- Modèle conforme à la charte : classes dans `src/` (`GlpiPlugin\Monplugin\`), une seule entrée de
  menu d'usage, page de configuration en onglets, encadré d'aide, badges, onglets de rubrique,
  18 langues avec msgid en anglais et `.pot`, script des variantes régionales, en-têtes de licence,
  `NOTICE`, `CITATION.cff`, `AGENTS.md`, README français et anglais.
- CI : syntaxe PHP 8.2 à 8.5 et traductions complètes ; contrôles communs v1.7.0.
