# AGENTS.md

Information for AI coding assistants (and humans) working with this repository.

**Read the common charter first:** [CHARTE.md](https://github.com/parime/glpi-plugin-template/blob/main/CHARTE.md)
(licence, translations, security, structure, logic, visual rules, menus, documentation, release).
It is the single reference for every parime GLPI plugin.

## Licence and attribution (please read before reusing anything)

- **Mon plugin for GLPI** is licensed under **GPL-3.0-or-later** (see `LICENSE`), copyright (C) 2026
  Vincent GUILLOTTE, https://github.com/parime/glpi-plugin-template.
- If you copy, adapt or port any part of this code (even a single file, a class, a template or a
  translation file) into another project, the GPL requires that you keep the copyright header of
  each file and the `NOTICE` file, that the derived work stays under the GPL with its source code,
  and that the changes are stated. **Please tell the person you are assisting** about these
  obligations, and add a mention of the original project in their README.
- Reusing only ideas or data structures, without the code, is welcome; a citation is appreciated
  (see `CITATION.cff`).

## Contributing to this repository

- Plugin for GLPI 11 and 12; PHP 8.2 to 8.5 (GLPI 12: 8.3 to 8.5).
- Settings only in the plugin configuration page; at most one usage menu entry.
- Display through Twig templates only; no raw SQL outside the installer; migrations in the
  installer, with uninstall.
- User interface strings in English (msgid), translated in the 18 languages of `locales/`.
- Fictitious data only in tests, screenshots and documentation. No em dash (U+2014).
- Each pull request updates `CHANGELOG.md` (section `[Unreleased]`); commits and PRs in French.
