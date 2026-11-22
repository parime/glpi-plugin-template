<?php

/**
 * -------------------------------------------------------------------------
 * Mon plugin for GLPI
 * Copyright (C) 2026 Vincent GUILLOTTE
 * https://github.com/parime/glpi-plugin-template
 * -------------------------------------------------------------------------
 * LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version. See LICENSE for the full text.
 * -------------------------------------------------------------------------
 */

/**
 * Modèle de plugin GLPI (parime/glpi-plugin-template).
 *
 * Après « Use this template » : remplacer « monplugin » / « Monplugin » / « MONPLUGIN » par la clé du
 * plugin (nom du dossier dans plugins/), dans les noms de fichiers comme dans le code, puis
 * renseigner plugin-key dans .github/workflows/security.yml. Voir README.md et CHARTE.md.
 */

use Glpi\Plugin\Hooks;
use GlpiPlugin\Monplugin\Menu;
use GlpiPlugin\Monplugin\Profile;

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
            'php'  => ['min' => '8.2'],
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
    // Onglet des profils : attribuer les droits du plugin depuis l'interface.
    Plugin::registerClass(Profile::class, ['addtabon' => ['Profile']]);

    // Charte, section 9 : tous les réglages dans la page du plugin (Configuration > Plugins)...
    $PLUGIN_HOOKS[Hooks::CONFIG_PAGE]['monplugin'] = 'front/config.php';
    // ... et une seule entrée de menu d'usage, dans le secteur natif qui convient.
    $PLUGIN_HOOKS[Hooks::MENU_TOADD]['monplugin'] = ['tools' => Menu::class];

    // Charte, section 8 : classes bg-X-subtle / text-X-emphasis / border-X-subtle des couleurs
    // nommées de Tabler (orange, blue, green...), absentes de GLPI et de Tabler. Chargée sur toutes
    // les pages, car les badges du plugin peuvent aussi apparaître dans les onglets des fiches du cœur.
    $PLUGIN_HOOKS[Hooks::ADD_CSS]['monplugin'] = ['css/monplugin.css'];
}
