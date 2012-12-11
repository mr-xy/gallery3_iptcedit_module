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
class iptcedit_installer {
  static function install() {
    $version = module::get_version("iptcedit");
    if ($version == 0) {
      /* @todo Put database creation here */
      module::set_version("iptcedit", 1);
    }
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
    foreach($iptcTags as $key=>$value){
        module::set_var("iptcedit", $key , "1");
        module::set_var("iptcedit", $key."_required", "0");
        module::set_var("iptcedit", $key."_label", $key);
    }
  }
  
  static function upgrade($version) {
  }

  static function uninstall() {
    /* @todo Put database table drops here */
    Database::instance()->query("DELETE FROM TABLE {vars} WHERE module_name LIKE 'iptcedit'");
    dir::unlink(VARPATH . "modules/iptcedit");
    module::delete("iptcedit");
  }
}
