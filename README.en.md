# glpi-plugin-template

GLPI (11 and 12) plugin template by parime. A new plugin starts compliant with the
[common plugin charter](CHARTE.md) (in French: licence, translations, security, structure, logic,
visual rules, menus, documentation, release) and with the common security checks
([parime/glpi-plugin-security](https://github.com/parime/glpi-plugin-security)).

## Getting started

1. **Use this template** on GitHub, then clone the new repository.
2. Replace `monplugin` / `Monplugin` / `MONPLUGIN` / "Mon plugin" / "My plugin" with the plugin key
   and name everywhere (file names, code, Twig, `.po`, `.github/workflows/security.yml`), and adapt
   `NOTICE`, `CITATION.cff`, `tools/HEADER`, `AGENTS.md` and both READMEs.
3. Delete `CHARTE.md` from the new repository: the single reference is the template's one.
4. Protect the main branch and require the "security" and "CI" jobs.

## Reuse and citation

GPL-3.0-or-later: keep each file header and `NOTICE`, and cite the original project (see
`CITATION.cff`).

## Licence

GPL-3.0-or-later, see [LICENSE](LICENSE).
