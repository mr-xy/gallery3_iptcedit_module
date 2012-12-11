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
include_once('class.iptcdata.php'); 
 
class iptcedit_Controller extends Controller {
    
  function dialog($item_id) {
    $item = ORM::factory("item", $item_id);
    access::required("view", $item);
    access::required("edit", $item);
    //read iptc
    $i = new iptcdata($item->thumb_path());
    $v = new View("iptcedit_dialog.html");
    $v->item = $item;
    $v->iptcLabels = iptcdata::iptcLabels();
    $v->iptcTags = iptcdata::iptcTags();
    $v->i = $i;
    if($_POST['submitted'] == 1) {
           $i->write($_POST['iptcdata'],$v->iptcTags,$item);
            if(module::is_active("exif")){
                exif::extract($item);
            }
            if(module::is_active("search_ext")){
                search_ext::update($item);
            }
    message::success(t("iptcedit Processing Successfully"));
    }
    print $v;
  }
  
    
  function upload_dialog($item_id) {
    $item = ORM::factory("item", $item_id);
    access::required("view", $item);
    access::required("edit", $item);
    //get itemId of last item in album before upload
    foreach($item->viewable()->children() as $child) {
        $children[] = $child->id;
    }
    $lastChild = end($children);
    //read iptc
    $i = new iptcdata($item->thumb_path());
    $v = new View("iptcedit_upload_dialog.html");
    $v->item = $item;
    $v->iptcLabels = iptcdata::iptcLabels();
    $v->iptcTags = iptcdata::iptcTags();
    $v->i = $i;
    //Nutzername
    $user = identity::active_user();
    $v->IPTC_HEADLINE = $item->title;
    $v->IPTC_CAPTION = $item->description;
    $v->IPTC_BYLINE = $user->full_name;
    $today = time();
    $v->IPTC_CREATED_DATE = date('Ymd', $today);
    if($_POST['submitted'] != 1 ) {
        $v->last = $lastChild;
    }
    if($_POST['submitted'] == 1 && $_POST['radio'] == "all") {
        $i->write($_POST['iptcdata'],$v->iptcTags,$item); 
        foreach($item->viewable()->children() as $child) {
            if($child->is_photo()){
                $j = new iptcdata($child->thumb_path());
                $j->write($_POST['iptcdata'],$v->iptcTags,$child);
                if(module::is_active("exif")){
                    exif::extract($child);
                }
                if(module::is_active("search_ext")){
                    search_ext::update($child);
                }
            }
        }
        message::success(t("iptcedit Processing Successfully"));
    }elseif($_POST['submitted'] == 1 && $_POST['radio'] == "new") {
        $i->write($_POST['iptcdata'],$v->iptcTags,$item); 
        foreach($item->viewable()->children() as $child) {
            if($child->is_photo() && $child->id > $_POST['lastItem']){
                $j = new iptcdata($child->thumb_path());
                $j->write($_POST['iptcdata'],$v->iptcTags,$child);
                if(module::is_active("exif")){
                    exif::extract($child);
                }
                if(module::is_active("search_ext")){
                    search_ext::update($child);
                }
            }
        }
        message::success(t("iptcedit Processing Successfully"));
    }
    print $v;
  }
    
  public function index() {
    print $this->_get_form();
  }

  public function handler() {
    access::verify_csrf();

    $form = $this->_get_form();
    if ($form->validate()) {
      // @todo process the admin form

      message::success(t("iptcedit Processing Successfully"));

      json::reply(array("result" => "success"));
    } else {
      json::reply(array("result" => "error", "html" => (string)$form));
    }
  }

  private function _get_form() {
    $form = new Forge("iptcedit/handler", "", "post",
                      array("id" => "g-iptcedit-form"));
    $group = $form->group("group")->label(t("iptcedit Handler"));
    $group->input("text")->label(t("Text"))->rules("required");
    $group->submit("submit")->value(t("Submit"));

    return $form;
  }
}
