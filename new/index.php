<?php
require '../game/Common.php';
require '../game/Game.php';
require '../game/Response.php';
$uri = explode('?', $_SERVER['REQUEST_URI']);
if(count($uri) > 1){
	$strategy = getParam("strategy", $uri[1]);
	if($strategy === "smart" || $strategy === "random"){
		newGame($strategy);
	} else if ($strategy){
		echo json_encode(Response::withReason("Unknown strategy"));
	} else {
		echo json_encode(Response::withReason("Strategy not specified"));
	}
} else {
	echo json_encode(Response::withReason("Strategy not specified"));
}
function newGame($strategy){
	 $pid = uniqid();
	$game = new Game($strategy);
	saveGame($pid, $game);
	echo json_encode(Response::withPid($pid));
}
?>
