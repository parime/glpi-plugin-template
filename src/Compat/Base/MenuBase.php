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

namespace GlpiPlugin\Monplugin\Compat\Base;

use CommonGLPI;
use GlpiPlugin\Monplugin\Compat\GlpiVersion;
use GlpiPlugin\Monplugin\Menu;

/*
 * Parent de \GlpiPlugin\Monplugin\Menu : redéclare $rightname sans type en GLPI 11, typé en
 * GLPI 12 (voir GlpiVersion). La valeur vient de la constante de la classe enfant.
 */
if (GlpiVersion::isAtLeast12()) {
    abstract class MenuBase extends CommonGLPI
    {
        public static string $rightname = Menu::RIGHTNAME;
    }
} else {
    abstract class MenuBase extends CommonGLPI
    {
        public static $rightname = Menu::RIGHTNAME;
    }
}
