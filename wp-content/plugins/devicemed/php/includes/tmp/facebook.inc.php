<?php
function facebook_likes($url) {
      $content = wget("http://api.ak.facebook.com/restserver.php?v=1.0&method=fql.query&query=select%20url,%20total_count%20from%20link_stat%20where%20url%20in%20('".$url."')&format=xml");
      $fbCount = simplexml_load_string($content);
     if(is_bool($fbCount)){
            return false;
        }else{
            return intval($fbCount->link_stat->total_count[0]);
        }
}


