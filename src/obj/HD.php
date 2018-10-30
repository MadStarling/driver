<?php

namespace Obj;

class HD{

    private $currentPos;

    public function __construct($p){
        $this->currentPos = $p;
    }

    public function goTo($r){
        $at = $this->getAccessTime($r->c, $r->d, $r->b);
        $this->currentPos = $r->b;

        return $at;
    }

    private function getAccessTime($seekTime, $transferTime, $finalPos){
        return $seekTime + $transferTime + (
            $this->currentPos > $finalPos ? 
                $this->currentPos - $finalPos : $finalPos - $this->currentPos
        );
    }

    public function getCurrentPosition(){
        return $this->currentPos;
    }
}