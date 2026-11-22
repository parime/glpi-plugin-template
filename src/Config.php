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

/**
 * Réglages du plugin, dans la table de configuration du cœur (contexte « plugin:monplugin »).
 * Saisis uniquement depuis la page du plugin (front/config.php), retirés à la désinstallation.
 * Chaque valeur est validée ici, jamais reprise telle quelle de la requête.
 */
final class Config
{
    private const CONTEXT = 'plugin:monplugin';

    /** @var array<string, string> */
    public const DEFAULTS = [
        'example_enabled' => '0',
        'example_label'   => '',
        // Composant « Version du plugin » (charte section 9 bis) : désactivable pour une instance
        // sans accès à Internet.
        'version_check'   => '1',
    ];

    /**
     * @return array<string, string>
     */
    public static function load(): array
    {
        return array_intersect_key(\Config::getConfigurationValues(self::CONTEXT), self::DEFAULTS) + self::DEFAULTS;
    }

    /**
     * @param array<string, mixed> $input
     */
    public static function save(array $input): void
    {
        \Config::setConfigurationValues(self::CONTEXT, [
            'example_enabled' => empty($input['example_enabled']) ? '0' : '1',
            'example_label'   => mb_substr(trim((string) ($input['example_label'] ?? '')), 0, 255),
            'version_check'   => empty($input['version_check']) ? '0' : '1',
        ]);
    }

    public static function uninstall(): void
    {
        \Config::deleteConfigurationValues(self::CONTEXT, array_keys(self::DEFAULTS));
    }
}
