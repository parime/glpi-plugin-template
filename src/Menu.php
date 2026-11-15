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

/**
 * Seule entrée de menu d'usage du plugin (Outils > Mon plugin, charte section 9). Les écrans du
 * plugin sont ses onglets ou sous-pages (templates/_section_nav.html.twig) ; elle n'apparaît
 * qu'avec le droit de lecture du plugin. Page : front/menu.php.
 */
class Menu extends CommonGLPI
{
    public const RIGHTNAME = 'plugin_monplugin';

    public static $rightname = self::RIGHTNAME;

    public static function getTypeName($nb = 0)
    {
        return __('My plugin', 'monplugin');
    }

    public static function getIcon()
    {
        return 'ti ti-puzzle';
    }
}
