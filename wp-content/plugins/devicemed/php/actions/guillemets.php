<?php
remove_filter('the_content', 'wptexturize');
/*add_filter('the_content', 'frenchquotes');

function frenchquotes($text){
    $size = strlen($text);
    $i=0;
    $replace = array();
    $replace['one'] = array();
    $replace['two'] = array();
    while($i < $size)
    {
        if($text[$i] == '"')
        {
            if($text[$i-1] == " " || empty($text[$i-1]))
            {
                    $replace['one'][] = $i;
            }
            elseif($text[$i+1] == " " || empty($text[$i+1]))
            {
                $replace['two'][] = $i;
            }
        }

        $i++;
    }

    $y = 0;
    $it = 0;
    foreach($replace['one'] as $ghh)
    {
        $text = substr_replace($text, '&laquo;', ($ghh+$y), 1);
        $y += 6;
        $it++;
    }

    $to=0;
    $i=1;
    $u=1;
    foreach($replace['two'] as $ghhd)
    {
        $text = substr_replace($text, '&raquo;', ($ghhd-1+$to+((8*$i)-($u*1))), 1);
        $i++;
        $u +=2;
        $to +=6;
    }
    while(strstr($text, ' &raquo;')!==false) {
	    $text = str_replace(' &raquo;','&raquo;',$text);
	}
	$text = str_replace('&raquo;','&thinsp;&raquo;',$text);

    while(strstr($text, '&laquo; ')!==false) {
	    $text = str_replace('&laquo; ','&laquo;',$text);
	}
	$text = str_replace('&laquo;','&laquo;&thinsp;',$text);

    return $text;
}*/