<?php

/**
 * Modèle de plugin GLPI (parime/glpi-plugin-template).
 *
 * Après « Use this template » : remplacer « monplugin » / « Monplugin » / « MONPLUGIN » par la clé du
 * plugin (nom du dossier dans plugins/), dans les noms de fichiers comme dans le code, puis
 * renseigner plugin-key dans .github/workflows/security.yml. Voir README.md.
 */

define('PLUGIN_MONPLUGIN_VERSION', '0.1.0');
define('PLUGIN_MONPLUGIN_MIN_GLPI', '11.0.0');
define('PLUGIN_MONPLUGIN_MAX_GLPI', '12.99.99');

function plugin_version_monplugin(): array
{
    return [
        'name'         => 'Mon plugin',
        'version'      => PLUGIN_MONPLUGIN_VERSION,
        'author'       => 'Vincent GUILLOTTE',
        'license'      => 'GPL-3.0-or-later',
        'homepage'     => 'https://github.com/parime/glpi-plugin-template',
        'requirements' => [
            'glpi' => ['min' => PLUGIN_MONPLUGIN_MIN_GLPI, 'max' => PLUGIN_MONPLUGIN_MAX_GLPI],
        ],
    ];
}

function plugin_monplugin_check_prerequisites(): bool
{
    return true;
}

function plugin_monplugin_check_config($verbose = false): bool
{
    return true;
}

function plugin_init_monplugin(): void
{
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['monplugin'] = true;
}
