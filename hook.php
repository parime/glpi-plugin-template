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

use GlpiPlugin\Monplugin\Config;

/**
 * Installation et désinstallation. Règles communes (vérifiées par le contrôle de sécurité) :
 * - DDL via $DB->doQuery() seul (jamais « or die() ») ou via Migration ; pas de SQL brut ailleurs ;
 * - la désinstallation retire tout ce que le plugin a écrit dans les tables du cœur (droits,
 *   configuration, notifications, liens de documents, suivis, notes, journaux, règles…), par la
 *   classe du cœur quand elle existe.
 */

function plugin_monplugin_install(): bool
{
    ProfileRight::addProfileRights(['plugin_monplugin']);

    return true;
}

function plugin_monplugin_uninstall(): bool
{
    ProfileRight::deleteProfileRights(['plugin_monplugin']);
    Config::uninstall();

    return true;
}
