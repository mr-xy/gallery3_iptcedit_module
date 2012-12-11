<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2011 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

include_once(MODPATH . "iptcedit/controllers/class.iptcdata.php");
 
class iptcedit_block {
  static function get_site_list() {
    return array(
      "iptcedit_site" => t("iptcedit Sidebar Block"));
  }

  static function get_admin_list() {
    return array(
      "iptcedit_admin" => t("iptcedit Dashboard Block"));
  }

  static function get($block_id, $theme) {
    if($theme->page_type() == "item"){
        $block = new Block();
        switch ($block_id) {
        case "iptcedit_admin":
          $block->css_id = "g-iptcedit-admin";
          $block->title = t("iptcedit Dashboard Block");
          $block->content = new View("admin_iptcedit_block.html");

          $block->content->item = ORM::factory("item", 1);
          break;
        case "iptcedit_site":
          $item_path = $theme->item->thumb_path();
          $i = new iptcdata($item_path); 

     
          $block->css_id = "g-iptcedit-site";
          $block->title = t("IPTC Data");
          $block->content = new View("iptcedit_block.html");
          $block->content->i = $i;
          $block->content->iptcLabels = iptcdata::iptcLabels();
          $block->content->iptcTags = iptcdata::iptcTags();
          break;
        }
    }
    return $block;
  }
}
