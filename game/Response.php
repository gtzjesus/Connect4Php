<?php
class Response{
    public $response;
    
    function __construct($bool){
        $this->response = $bool;
    }
    
    static function withReason($reason){
        $instance = new self(FALSE);
        $instance->reason = $reason;
        return $instance;
    }
    
    static function withPid($pid){
        $instance = new self(TRUE);
        $instance->pid = $pid;
        return $instance;
    }
    
    static function withMove($ackMove){
        $instance = new self(TRUE);
        $instance->ack_move = $ackMove;
        return $instance;
    }
    
    static function withMoves($ackMove, $move){
        $instance = new self(TRUE);
        $instance->ack_move = $ackMove;
        $instance->move = $move;
        return $instance;
    }
}
?>