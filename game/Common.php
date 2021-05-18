<?php
//Used in indexes to find the parameters that are given
function getParam($toFind, $query){
    $params = explode('&', $query);
    foreach($params as $p){
        $p = strtolower($p);
        $param = explode('=', $p);
        if($param[0] === $toFind){
            if($param[1]){
                return $param[1];
            }
            else {
                break;
            }
        }
    }
    return FALSE;
}

//Implemented saving the game in writable
function saveGame($pid, $game){
    $filename = "../writable/savedGames/$pid.txt";
    $handle = fopen($filename, 'w') or die('Cannot open file:  '.$filename);
    fwrite($handle, json_encode($game));
    fclose($handle);
}
?>