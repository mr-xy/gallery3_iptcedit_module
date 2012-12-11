<?php defined("SYSPATH") or die("No direct script access.");/**
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
class iptcedit_event {
    
  static function context_menu($menu, $context_menu, $item, $thumbnail_css_selector) {
      if (access::can("edit", $item)) {
          if ($item->is_photo() || $item->is_movie()) {
            $menu->get("options_menu")
              ->append(Menu::factory("dialog")
                       ->id("iptcedit")
                       ->label(t("IPTC edit"))
                       ->css_class("ui-icon-pencil")
                       ->url(url::site("iptcedit/dialog/{$item->id}")));
          }
      }
    if (!empty($item) && access::can("edit", $item)) {
        if ($item->is_album()) {
            $menu->get("options_menu")
              ->append(Menu::factory("dialog")
                       ->id("iptcedit")
                       ->label(t("IPTC Album edit"))
                       ->css_class("ui-icon-pencil")
                       ->url(url::site("iptcedit/upload_dialog/{$item->id}")));
        }
    }
  }
    
  static function add_photos_form($album, $form) {
        iptcedit_Controller::upload_dialog($album->id);
  }

  static function add_photos_form_completed($item, $form) {
  }

  static function admin_menu($menu, $admin_menu) {
      $menu->get("settings_menu")
      ->append(Menu::factory("link")
               ->label(t("IPTC Edit"))
               ->url(url::site("admin/iptcedit")));
  }

  static function after_combine($type, $contents) {
  }

  static function album_add_form($parent, $form) {
  }

  static function album_add_form_completed($album, $form) {
  }

  static function album_menu($menu, $album_menu) {
  }

  static function batch_complete() {
  }

  static function before_combine($type, $before_combine, $type, $group) {
  }

  static function captcha_protect_form($form) {
  }

  static function comment_add_form($form) {
  }

  static function comment_created($comment_created) {
  }

  static function comment_updated($original, $comment_updated) {
  }



  static function gallery_ready() {
  }

  static function gallery_shutdown() {
  }

  static function graphics_composite($input_file, $output_file, $options, $item) {
  }

  static function graphics_composite_completed($input_file, $output_file, $options, $item) {
  }

  static function graphics_resize($input_file, $output_file, $options, $item) {
  }

  static function graphics_resize_completed($input_file, $output_file, $options, $item) {
  }

  static function graphics_rotate($input_file, $output_file, $options, $item) {
  }

  static function graphics_rotate_completed($input_file, $output_file, $options, $item) {
  }

  static function group_before_delete($group_before_delete) {
  }

  static function group_created($group_created) {
  }

  static function group_deleted($old) {
  }

  static function group_updated($original, $group_updated) {
  }

  static function identity_provider_changed($current_provider, $new_provider) {
  }

  static function info_block_get_metadata($block, $theme) {
  }

  static function item_before_create($item_before_create) {
  }

  static function item_before_delete($item_before_delete) {
  }

  static function item_before_update($item) {
  }

  static function item_created($item_created) {
  }

  static function item_deleted($old) {
  }

  static function item_edit_form($photo, $form) {
  }

  static function item_edit_form_completed($movie, $form) {
  }

  static function item_index_data($item, $data) {
  }

  static function item_moved($item_moved, $original) {
  }

  static function item_related_update($item) {
  }

  static function item_updated($original, $item_updated) {
  }

  static function item_updated_data_file($item_updated_data_file) {
  }

  static function module_change($changes) {
  }

  static function movie_menu($menu, $movie_menu) {
  }

  static function photo_menu($menu, $photo_menu) {
  }

  static function pre_deactivate($data) {
  }

  static function show_user_profile($event_data) {
  }

  static function site_menu($menu, $theme) {
    
    $item = $theme->item();
    if (!empty($item) && access::can("edit", $item)) {
        if ($item->is_photo() || $item->is_movie()) {
            $menu->get("options_menu")
              ->append(Menu::factory("dialog")
                       ->id("iptcedit")
                       ->label(t("IPTC edit"))
                       ->css_class("ui-icon-pencil")
                       ->url(url::site("iptcedit/dialog/{$item->id}")));
        }
    }
    
    if (!empty($item) && access::can("edit", $item)) {
        if ($item->is_album()) {
            $menu->get("options_menu")
              ->append(Menu::factory("dialog")
                       ->id("iptcedit")
                       ->label(t("IPTC Album edit"))
                       ->css_class("ui-icon-pencil")
                       ->url(url::site("iptcedit/upload_dialog/{$item->id}")));
        }
    }
  }

  static function tag_menu($menu, $tag_menu) {
  }

  static function theme_edit_form($form) {
  }

  static function theme_edit_form_completed($form) {
  }

  static function user_add_form_admin($user, $form) {
  }

  static function user_add_form_admin_completed($user, $form) {
  }

  static function user_auth($user) {
  }

  static function user_auth_failed($name) {
  }

  static function user_before_delete($user_before_delete) {
  }

  static function user_change_email_form_completed($user, $form) {
  }

  static function user_change_password_form($user, $form) {
  }

  static function user_change_password_form_completed($user, $form) {
  }

  static function user_created($user_created) {
  }

  static function user_deleted($old) {
  }

  static function user_edit_form($user, $form) {
  }

  static function user_edit_form_admin($user, $form) {
  }

  static function user_edit_form_admin_completed($user, $form) {
  }

  static function user_edit_form_completed($user, $form) {
  }

  static function user_login($user) {
  }

  static function user_login_failed($username) {
  }

  static function user_logout($user) {
  }

  static function user_menu($menu, $user_menu) {
  }

  static function user_password_change($user) {
  }

  static function user_profile_contact_form($form) {
  }

  static function user_updated($original, $user_updated) {
  }

}
