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

declare(strict_types=1);

namespace GlpiPlugin\Monplugin;

use CommonGLPI;
use Glpi\Application\View\TemplateRenderer;
use Session;

/**
 * Onglet des profils : chaque droit du plugin s'attribue depuis Administration > Profils, avec la
 * matrice du cœur. Le formulaire est enregistré par front/profile.form.php du cœur (droit
 * « profile »). Contrôle commun « profile-right » : tout droit du plugin doit figurer ici.
 */
class Profile extends CommonGLPI
{
    public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
    {
        return self::canManage($item) ? self::createTabEntry(Menu::getTypeName(), 0, static::class, Menu::getIcon()) : '';
    }

    public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
    {
        // ajax/common.tabs.php sert le contenu sans passer par getTabNameForItem().
        if (!self::canManage($item)) {
            return false;
        }
        TemplateRenderer::getInstance()->display('@monplugin/profile_rights.html.twig', [
            'item'   => $item,
            'title'  => Menu::getTypeName(),
            'rights' => [
                [
                    'rights' => [READ => __('Read'), UPDATE => __('Update'), CREATE => __('Create'), PURGE => __('Purge')],
                    'label'  => Menu::getTypeName(),
                    'field'  => Menu::RIGHTNAME,
                ],
            ],
        ]);

        return true;
    }

    // Droit « profile » du cœur, et accès au plugin : on ne délègue pas un module qu'on ne voit pas.
    private static function canManage(CommonGLPI $item): bool
    {
        return $item instanceof \Profile && !$item->isNewItem()
            && \Profile::canView() && (bool) Session::haveRight(Menu::RIGHTNAME, READ);
    }
}
