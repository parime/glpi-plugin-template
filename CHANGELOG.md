# Changelog

Toutes les évolutions notables de ce projet sont consignées ici.

Le format suit [Keep a Changelog](https://keepachangelog.com/fr/1.1.0/), et ce projet adhère au
[Semantic Versioning](https://semver.org/lang/fr/).

## [Unreleased]

### Changed

- CI : contrôles de sécurité communs glpi-plugin-security v1.9.0 (charte commune et contrôle des menus bloquants par défaut).
- CI : le contrôle « Sécurité commune » ne tourne plus sur chaque push de branche de travail, seulement sur les PR et les branches principales (moins d'exécutions en double et de notifications d'échec).

### Ajouté

- Charte commune des plugins (`CHARTE.md`), dont les traductions collaboratives (Hosted Weblate).
- Modèle conforme à la charte : classes dans `src/` (`GlpiPlugin\Monplugin\`), une seule entrée de
  menu d'usage, page de configuration en onglets, encadré d'aide, badges, onglets de rubrique,
  18 langues avec msgid en anglais et `.pot`, script des variantes régionales, en-têtes de licence,
  `NOTICE`, `CITATION.cff`, `AGENTS.md`, README français et anglais.
- CI : syntaxe PHP 8.2 à 8.5 et traductions complètes ; contrôles communs v1.7.0.
