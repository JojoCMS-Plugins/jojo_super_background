<?php

/**
 *                    Jojo CMS
 *                ================
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Rick Hambrook <rick@hambrook.co.nz>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 * @package jojo_super_background
 */

class Jojo_Plugin_jojo_super_background extends Jojo_Plugin {

    function hook_foot() {
        // Set the page background image
        global $page, $smarty;

        $page_bg_image = $page->page['pg_bg_image'];
        if (!$page_bg_image) {
            $page_bg_image = self::find_pg_image($page->page['pg_parent']);
        }
        $smarty->assign("super_bg_image", $page_bg_image);
        echo $smarty->fetch("super_bg_foot.tpl");
    }

    private static function find_pg_image($pageid) {
        $parent = Jojo::selectRow("SELECT pageid, pg_parent, pg_bg_image AS bg FROM {page} WHERE pageid = ?", $pageid);
        if (!$parent) { return false; }
        if ($parent['bg']) {
            return $parent['bg'];
        }
        if ($parent['pg_parent']) {
            return self::find_pg_image($parent['pg_parent']);
        }
        return false;
    }

}
