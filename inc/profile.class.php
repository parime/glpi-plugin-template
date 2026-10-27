<?php

use Glpi\Application\View\TemplateRenderer;

/**
 * Onglet des profils : chaque droit du plugin s'attribue depuis Administration > Profils, avec la
 * matrice du cœur. Le formulaire est enregistré par front/profile.form.php du cœur (droit
 * « profile »). Contrôle commun « profile-right » : tout droit du plugin doit figurer ici.
 */
class PluginMonpluginProfile extends CommonGLPI
{
    public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
    {
        return self::canManage($item) ? __('Mon plugin', 'monplugin') : '';
    }

    public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
    {
        // ajax/common.tabs.php sert le contenu sans passer par getTabNameForItem().
        if (!self::canManage($item)) {
            return false;
        }
        TemplateRenderer::getInstance()->display('@monplugin/profile_rights.html.twig', [
            'item'   => $item,
            'rights' => [
                [
                    'rights' => [READ => __('Read'), UPDATE => __('Update'), CREATE => __('Create'), PURGE => __('Purge')],
                    'label'  => __('Mon plugin', 'monplugin'),
                    'field'  => 'plugin_monplugin',
                ],
            ],
        ]);

        return true;
    }

    // Droit « profile » du cœur, et accès au plugin : on ne délègue pas un module qu'on ne voit pas.
    private static function canManage(CommonGLPI $item): bool
    {
        return $item instanceof Profile && !$item->isNewItem()
            && Profile::canView() && Session::haveRight('plugin_monplugin', READ);
    }
}
