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
class Admin_iptcedit_Controller extends Admin_Controller {
  public function index() {
    print $this->_get_view();
  }

  public function handler() {
    $iptcTags = $this->iptcTags();
    access::verify_csrf();
    $form = $this->_get_form();
    if ($form->validate()) {
        foreach($iptcTags as $key=>$value){
            module::set_var("iptcedit", $key, $form->$key->$key->value);
            $key_required = $key."_required";
            module::set_var("iptcedit", $key_required, $form->$key->$key_required->value);
            if($key == 'IPTC_HEADLINE' || $key == 'IPTC_CAPTION' || $key == 'IPTC_BYLINE' || $key == 'IPTC_CREATED_DATE'){
                $key_fill = $key."_fill";
                module::set_var("iptcedit", $key_fill, $form->$key->$key_fill->value);
            }
            $key_label = $key."_label";
            module::set_var("iptcedit", $key_label, $form->$key->$key_label->value);
        }

        message::success(t("iptcedit Adminstration Complete Successfully"));

        url::redirect("admin/iptcedit");
    }

    print $this->_get_view($form);
  }

  private function _get_view($form=null) {
    $v = new Admin_View("admin.html");
    $v->content = new View("admin_iptcedit.html");
    $v->content->form = empty($form) ? $this->_get_form() : $form;
    return $v;
  }
  
  private function _get_form() {
    $iptcTags = $this->iptcTags();
    $form = new Forge("admin/iptcedit/handler", "", "post",
                      array("id" => "g-adminForm"));
    foreach($iptcTags as $key=>$value){
        $group = $form->group($key)->label(t($key));
        $group  ->checkbox($key)
                ->label(t("show"))
                ->checked(module::get_var("iptcedit", $key));
                
        $group  ->checkbox($key."_required")
                ->label(t("required"))
                ->checked(module::get_var("iptcedit", $key."_required"));
        if($key == 'IPTC_HEADLINE' || $key == 'IPTC_CAPTION' || $key == 'IPTC_BYLINE' || $key == 'IPTC_CREATED_DATE'){
            $group  ->checkbox($key."_fill")
                    ->label(t("fill with G3 value"))
                    ->checked(module::get_var("iptcedit", $key."_fill"));
        }
        $group  ->input($key."_label")
                ->value(module::get_var("iptcedit", $key."_label"));
    }
    /*
    $group->checkbox("IPTC_HEADLINE")->label(t("IPTC_HEADLINE"))->checked(module::get_var("iptcedit", "IPTC_HEADLINE"));
    $group->checkbox("IPTC_CAPTION")->label(t("IPTC_CAPTION"))->value(t("102"));
    $group->checkbox("IPTC_KEYWORDS")->label(t("IPTC_KEYWORDS"))->value(t("025"));
    $group->checkbox("IPTC_CITY")->label(t("IPTC_CITY"))->value(t("090"));
    $group->checkbox("IPTC_COUNTRY_CODE")->label(t("IPTC_COUNTRY_CODE"))->value(t("100"));
    $group->checkbox("IPTC_PROVINCE_STATE")->label(t("IPTC_PROVINCE_STATE"))->value(t("095"));
    $group->checkbox("IPTC_BYLINE")->label(t("IPTC_BYLINE"))->value(t("080"));
    $group->checkbox("IPTC_CREDIT")->label(t("IPTC_CREDIT"))->value(t("110"));
    $group->checkbox("IPTC_COPYRIGHT_STRING")->label(t("IPTC_COPYRIGHT_STRING"))->value(t("116"));
    $group->checkbox("IPTC_OBJECT_NAME")->label(t("IPTC_OBJECT_NAME"))->value(t("005"));
    $group->checkbox("IPTC_CREATED_DATE")->label(t("IPTC_CREATED_DATE"))->value(t("055"));
    $group->checkbox("IPTC_CREATED_TIME")->label(t("IPTC_CREATED_TIME"))->value(t("060"));
    $group->checkbox("IPTC_SOURCE")->label(t("IPTC_SOURCE"))->value(t("115"));
    $group->checkbox("IPTC_EDIT_STATUS")->label(t("IPTC_EDIT_STATUS"))->value(t("007"));
    $group->checkbox("IPTC_PRIORITY")->label(t("IPTC_PRIORITY"))->value(t("010"));
    $group->checkbox("IPTC_CATEGORY")->label(t("IPTC_CATEGORY"))->value(t("015"));
    $group->checkbox("IPTC_SUPPLEMENTAL_CATEGORY")->label(t("IPTC_SUPPLEMENTAL_CATEGORY"))->value(t("020"));
    $group->checkbox("IPTC_FIXTURE_IDENTIFIER")->label(t("IPTC_FIXTURE_IDENTIFIER"))->value(t("022"));
    $group->checkbox("IPTC_RELEASE_DATE")->label(t("IPTC_RELEASE_DATE"))->value(t("030"));
    $group->checkbox("IPTC_RELEASE_TIME")->label(t("IPTC_RELEASE_TIME"))->value(t("035"));
    $group->checkbox("IPTC_SPECIAL_INSTRUCTIONS")->label(t("IPTC_SPECIAL_INSTRUCTIONS"))->value(t("040"));
    $group->checkbox("IPTC_REFERENCE_SERVICE")->label(t("IPTC_REFERENCE_SERVICE"))->value(t("045"));
    $group->checkbox("IPTC_REFERENCE_DATE")->label(t("IPTC_REFERENCE_DATE"))->value(t("047"));
    $group->checkbox("IPTC_REFERENCE_NUMBER")->label(t("IPTC_REFERENCE_NUMBER"))->value(t("050"));
    $group->checkbox("IPTC_ORIGINATING_PROGRAM")->label(t("IPTC_ORIGINATING_PROGRAM"))->value(t("065"));
    $group->checkbox("IPTC_PROGRAM_VERSION")->label(t("IPTC_PROGRAM_VERSION"))->value(t("070"));
    $group->checkbox("IPTC_OBJECT_CYCLE")->label(t("IPTC_OBJECT_CYCLE"))->value(t("075"));
    $group->checkbox("IPTC_BYLINE_TITLE")->label(t("IPTC_BYLINE_TITLE"))->value(t("085"));
    $group->checkbox("IPTC_COUNTRY")->label(t("IPTC_COUNTRY"))->value(t("101"));
    $group->checkbox("IPTC_ORIGINAL_TRANSMISSION_REFERENCE")->label(t("IPTC_ORIGINAL_TRANSMISSION_REFERENCE"))->value(t("103"));
    $group->checkbox("IPTC_LOCAL_CAPTION")->label(t("IPTC_LOCAL_CAPTION"))->value(t("121"));
*/
    $group->submit("submit")->value(t("Submit"));

    return $form;
  }

    private function iptcTags() {
        $iptcTags = array(
                    'IPTC_HEADLINE' => '105',
                    'IPTC_CAPTION' => '120',
                    'IPTC_KEYWORDS' => '025',    
                    'IPTC_CITY' => '090',
                    'IPTC_COUNTRY_CODE' => '100',    
                    'IPTC_PROVINCE_STATE' => '095',       
                    'IPTC_BYLINE' => '080',   
                    'IPTC_CREDIT' => '110',
                    'IPTC_COPYRIGHT_STRING' => '116',   
                    'IPTC_OBJECT_NAME' => '005',       
                    'IPTC_CREATED_DATE' => '055',
                    'IPTC_CREATED_TIME' => '060',    
                    'IPTC_SOURCE' => '115',    
                    'IPTC_EDIT_STATUS' => '007',
                    'IPTC_PRIORITY' => '010',
                    'IPTC_CATEGORY' => '015',
                    'IPTC_SUPPLEMENTAL_CATEGORY' => '020',
                    'IPTC_FIXTURE_IDENTIFIER' => '022',
                    'IPTC_RELEASE_DATE' => '030',
                    'IPTC_RELEASE_TIME' => '035',
                    'IPTC_SPECIAL_INSTRUCTIONS' => '040',
                    'IPTC_REFERENCE_SERVICE' => '045',
                    'IPTC_REFERENCE_DATE' => '047',
                    'IPTC_REFERENCE_NUMBER' => '050',
                    'IPTC_ORIGINATING_PROGRAM' => '065',
                    'IPTC_PROGRAM_VERSION' => '070',
                    'IPTC_OBJECT_CYCLE' => '075',
                    'IPTC_BYLINE_TITLE' => '085',
                    'IPTC_COUNTRY' => '101',
                    'IPTC_ORIGINAL_TRANSMISSION_REFERENCE' => '103',
                    'IPTC_LOCAL_CAPTION' => '121'
        );
    return $iptcTags;
    }
}