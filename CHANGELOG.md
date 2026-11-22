# Changelog

Toutes les évolutions notables de ce projet sont consignées ici.

Le format suit [Keep a Changelog](https://keepachangelog.com/fr/1.1.0/), et ce projet adhère au
[Semantic Versioning](https://semver.org/lang/fr/).

## [Unreleased]

### Changed

- CI : contrôles de sécurité communs glpi-plugin-security v1.9.0 (charte commune et contrôle des menus bloquants par défaut).
- CI : le contrôle « Sécurité commune » ne tourne plus sur chaque push de branche de travail, seulement sur les PR et les branches principales (moins d'exécutions en double et de notifications d'échec).

### Ajouté

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
