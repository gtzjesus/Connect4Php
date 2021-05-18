<?php
require 'PlayerMove.php';
class Game{
	public $board;
	public $strategy;
	function __construct($strategy){
		//Create the board as array
		$this->board = array(
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
				array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)
		);
		$this->strategy = $strategy;
	}
	
	//Function used in play/index.php for creating moves
	static function restore($pid){
		$filename = "../writable/savedGames/$pid.txt";
		$handle = fopen($filename, 'rb') or die('Cannot open file:  '.$filename);
		$content = fread($handle, filesize($filename));
		fclose($handle);
		
		$previous = json_decode($content);
		$instance = new self($previous->strategy);
		$instance->board = json_decode(json_encode($previous->board), TRUE);
		return $instance;
	}
	
	//Function to create a move
	function doMove($player1, $move){
		$this->board[$move[0]][$move[1]] = ($player1)? 1 : 2;
		
		//Value will show if it was a win, draw or neither.
		$result = $this->checkWin($move);
		if($result == 0){
			return new PlayerMove($move[0], $move[1], FALSE, FALSE, array()); //Value did not result in win or draw
		} else if($result == 2){
			return new PlayerMove($move[0], $move[1], FALSE, TRUE, array()); //Value resulted in a draw
		} else {
			return new PlayerMove($move[0], $move[1], TRUE, FALSE, $result); //Value resulted in a win
		}				
		}
	
	//Function implemented to check for win on board
	function checkWin($lastMove){
		$row = array();
		$myMove = $this->board[$lastMove[0]][$lastMove[1]];
		$startIndexH = ($lastMove[0]<4)? 0 : $lastMove[0]-4;
		$endIndexH = ($lastMove[0]>10)? 14 : $lastMove[0]+4;
		$startIndexV = ($lastMove[1]<4)? 0 : $lastMove[1]-4;
		$endIndexV = ($lastMove[1]>10)? 14 : $lastMove[1]+4;
		$counth = 0;
		$countv= 0;
		$count1 = 0;
		$count2 = 0;
		$count3 = 0;
		$count4 = 0;
		
		//Horizontal of the last move in the board win
		for($i = $startIndexH; $i <= $endIndexH; $i++){
			if($this->board[$i][$lastMove[1]] == $myMove){
				$counth++;
				$row[] =$i;
				$row[] = $lastMove[1];
				if($counth == 5){
					return $row;
				}
			}
			else {
				$counth = 0;
			}
		}
		
		$row = array();
		
		//Vertical of the last move in the board win
		for($i = $startIndexV; $i <= $endIndexV; $i++){
			if($this->board[$lastMove[0]][$i] == $myMove){
				$countv++;
				$row[] =$lastMove[0];
				$row[] = $i;
				if($countv == 5){
					return $row;
				}
			} else {
				$countv = 0;
			}
		}
		
		$row = array();
		
		//Diagonals for the last move in the board win
		for($x = 4; $x < 15; $x++){
			for($i = 0; $i <= $x; $i++){
				if($this->board[$x-$i][$i] == $myMove){
					$count1++;
					$row[] = $x-$i;
					$row[] = $i;
					if($count1 == 5){
						return $row;
					}
				} else {
					$count1 = 0;
				}
				if($this->board[14-$x+$i][14-$i] == $myMove){
					$count2++;
					$row[] = 14-$x+$i;
					$row[] = 14-$i;
					if($count2 == 5){
						return $row;
					}
				} else {
					$count2 = 0;
				}
				
				if($this->board[14-$x+$i][$i] == $myMove){
					$count3++;
					$row[] = 14-$x+$i;
					$row[] = $i;
					if($count3 == 5){
						return $row;
					}
				} else {
					$count3 = 0;
				}
				if($this->board[$i][14-$x+$i] == $myMove){
					$count4++;
					$row[] = $i;
					$row[] = 14-$x+$i;
					if($count4 == 5){
						return $row;
					}
				} else {
					$count4 = 0;
				}
			}
		}

		//Draw of the game where for loop stops
		for($i = 0; $i < 15; $i++){
			for($j = 0; $j < 15; $j++){
				if($this -> board[$i][$j] === 0){
					return 0;
				}
			}
		}
		
		return 2;
	}
}
?>