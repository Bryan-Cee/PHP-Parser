<?php
/**
 * Created by PhpStorm.
 * User: bryce
 * Date: 2019-03-12
 * Time: 16:39
 */

require_once ("./src/Models/Utilities/ParseArgv.php");


$parsed = new ParseArgv($_SERVER['argv']);

function print_args($parsed_array) {
    $parsed_string = "";

    foreach ($parsed_array as $item) {
        $newString=[];
        $item_list = explode(" ",$item[1]);
        $length = count($item_list);
        for ($i=0; $i<$length; $i++) {
            $string = preg_replace("/ /",", ", $item[1]);
            array_push($newString, $string);
        }
        if ($length === 1) {
            $parsed_string = $parsed_string.$item[0]." => ".$newString[0]." (".$length." argument)\n";
        } else {
            $newString = [];
            $finalOutput=[];
            $newString = array_merge($item_list,$newString);
            for ($i=0; $i<$length; $i++) {
                $newestString = str_replace($item_list[$i], "[".$i."] ".$newString[$i]."",$item_list);
                array_push( $finalOutput, $newestString[$i]);
            }
            $finalOutput = implode(", ", $finalOutput);

            $parsed_string = $parsed_string.$item[0]." => ".$finalOutput." (".$length." arguments)\n";
        }
    }
    unset($item);
    return $parsed_string;
}

print "FLAGS\n".$parsed->flags[0]."\n\n";
print "SINGLES\n".print_args($parsed->singles)."\n";
print "DOUBLES\n".print_args($parsed->double);
