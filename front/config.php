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

use Glpi\Application\View\TemplateRenderer;
use GlpiPlugin\Monplugin\Config;
use GlpiPlugin\Monplugin\Menu;
use GlpiPlugin\Monplugin\PluginVersion;

// Page de configuration du plugin (Configuration > Plugins > Mon plugin) : le seul endroit où le
// plugin se règle (charte section 9). Réservée au droit de configuration de GLPI.
Session::checkRight('config', UPDATE);

if (isset($_POST['update'])) {
    // Jeton CSRF vérifié par GLPI (csrf_compliant) ; valeurs validées par Config::save().
    Config::save($_POST);
    Session::addMessageAfterRedirect(__('Settings saved.', 'monplugin'));
    Html::back();
}

$values = Config::load();
// Encadré « Version du plugin » (charte section 9 bis) : clé du plugin et dépôt GitHub en paramètres.
$pluginVersion = (new PluginVersion('monplugin', 'parime/glpi-plugin-template', PLUGIN_MONPLUGIN_VERSION))
    ->status($values['version_check'] === '1');

Html::header(Menu::getTypeName(), '', 'config', 'plugin');
TemplateRenderer::getInstance()->display('@monplugin/config.html.twig', [
    'values'         => $values,
    'version'        => PLUGIN_MONPLUGIN_VERSION,
    'plugin_version' => $pluginVersion,
]);
Html::footer();
