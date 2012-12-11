<?php defined("SYSPATH") or die("No direct script access.") ?>
<div class="g-iptcedit-block">
  <?php 
  foreach($iptcTags as $key=>$value){
    echo "<p><span style='font-size: .9em; color: #5382BF'>" . $iptcLabels[$key] . "</span><br/>" . $i->get($iptcTags[$key]) . "</p>";
  }
  ?>
</div>
