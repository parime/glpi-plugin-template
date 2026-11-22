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

namespace GlpiPlugin\Monplugin\Compat;

use GlpiPlugin\Monplugin\Menu;

/**
 * Point de passage des appels HTTP sortants du plugin (charte section 3), par le client du cœur
 * GLPI, donc avec son proxy et ses exclusions de proxy :
 * - GLPI 12 : Glpi\Toolbox\HttpClient, avec le contexte Menu::class (qu'un administrateur peut
 *   ajouter à GLPI_SERVERSIDE_URL_ALLOWED_PRIVATE_NETWORKS_CONTEXTS) ;
 * - GLPI 11 : Toolbox::getGuzzleClient() (Glpi\Toolbox\HttpClient n'y existe pas).
 *
 * Redirections jamais suivies ; délai total borné ; aucun en-tête de GLPI (session, cookie) transmis.
 * Version minimale du modèle : un plugin qui appelle des adresses saisies par un administrateur
 * reprend la version complète de GRC (contrôle des adresses internes, épinglage DNS).
 */
final class Http
{
    /** Contexte passé au client du cœur GLPI 12 (proxy et réseaux privés par contexte). */
    public const CONTEXT = Menu::class;

    /**
     * Requête GET. Un code HTTP (2xx à 5xx) est renvoyé tel quel, jamais levé en exception ; un
     * échec réseau (nom inconnu, connexion refusée, délai dépassé) lève une exception.
     *
     * @param array<string, string> $headers
     * @return array{status: int, body: string, headers: array<string, string>} en-têtes en minuscules
     */
    public static function get(string $url, array $headers = [], int $timeout = 10): array
    {
        $timeout = max(1, $timeout);

        return class_exists(\Glpi\Toolbox\HttpClient::class)
            ? self::getWithGlpi12($url, $headers, $timeout)
            : self::getWithGlpi11($url, $headers, $timeout);
    }

    /**
     * @param array<string, string> $headers
     * @return array{status: int, body: string, headers: array<string, string>}
     */
    private static function getWithGlpi12(string $url, array $headers, int $timeout): array
    {
        $options = [
            'headers'       => $headers,
            'timeout'       => $timeout,
            'max_duration'  => $timeout,
            'max_redirects' => 0,
        ];
        try {
            $response = (new \Glpi\Toolbox\HttpClient(self::CONTEXT))->request('GET', $url, $options);
        } catch (\Throwable $e) {
            // Le client du cœur lève une exception pour toute réponse 3xx, 4xx ou 5xx, qui porte la
            // réponse (HttpExceptionInterface de Symfony) ; sans réponse, c'est un échec réseau.
            $response = method_exists($e, 'getResponse') ? $e->getResponse() : null;
            if (!is_object($response) || !method_exists($response, 'getStatusCode')) {
                throw $e;
            }
        }
        $flat = [];
        foreach ($response->getHeaders(false) as $name => $values) {
            $flat[strtolower((string) $name)] = (string) ($values[0] ?? '');
        }

        return [
            'status'  => (int) $response->getStatusCode(),
            'body'    => (string) $response->getContent(false),
            'headers' => $flat,
        ];
    }

    /**
     * @param array<string, string> $headers
     * @return array{status: int, body: string, headers: array<string, string>}
     */
    private static function getWithGlpi11(string $url, array $headers, int $timeout): array
    {
        $response = \Toolbox::getGuzzleClient(['timeout' => $timeout, 'connect_timeout' => $timeout])
            ->request('GET', $url, [
                'headers'         => $headers,
                'timeout'         => $timeout,
                'allow_redirects' => false,
                'http_errors'     => false,
            ]);
        $flat = [];
        foreach ($response->getHeaders() as $name => $values) {
            $flat[strtolower((string) $name)] = (string) ($values[0] ?? '');
        }

        return [
            'status'  => $response->getStatusCode(),
            'body'    => (string) $response->getBody(),
            'headers' => $flat,
        ];
    }
}
