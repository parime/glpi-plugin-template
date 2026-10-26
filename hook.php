<?php

/**
 * Installation et désinstallation. Règles communes (vérifiées par le contrôle de sécurité) :
 * - DDL via $DB->doQuery() seul (jamais « or die() ») ou via Migration ;
 * - la désinstallation retire tout ce que le plugin a écrit dans les tables du cœur (droits,
 *   notifications, liens de documents, suivis, notes, journaux, règles…), par la classe du cœur
 *   quand elle existe.
 */

function plugin_monplugin_install(): bool
{
    ProfileRight::addProfileRights(['plugin_monplugin']);

    return true;
}

function plugin_monplugin_uninstall(): bool
{
    ProfileRight::deleteProfileRights(['plugin_monplugin']);

    return true;
}
