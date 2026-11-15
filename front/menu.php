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
use GlpiPlugin\Monplugin\Menu;

// Page d'usage, seule entrée de menu du plugin (Outils > Mon plugin) : droit de lecture du plugin.
Session::checkRight(Menu::RIGHTNAME, READ);

Html::header(Menu::getTypeName(), '', 'tools', Menu::class);
TemplateRenderer::getInstance()->display('@monplugin/menu.html.twig', [
    // Onglets de la rubrique : un écran par onglet, selon les droits (ici un seul).
    'tabs' => [
        ['label' => __('Overview', 'monplugin'), 'icon' => 'ti ti-layout-dashboard', 'url' => Menu::getSearchURL(), 'active' => true],
    ],
]);
Html::footer();
