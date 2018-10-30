<?php

namespace Politics;

class Scan {

    public $hd, $fileReader, $file, $lastSector = true;

    public function __construct($file){
        $this->fileReader = new \Utilities\FileReader();
        $this->file = $file;
    }

    public function setHD($hd){
        $this->hd = $hd;
    }

    public function printResults(){
        $reqs = $this->fileReader->getReqs($this->file, $this);

        $totalWaitTime = 0;
        $totalAccessTime = 0;

        $initialPos = $this->hd->getCurrentPosition();
        $missingReq = [];

        foreach($reqs as $r){
            if($r->b > $initialPos){
                $totalAccessTime += $this->hd->goTo($r);

                $totalWaitTime += $totalAccessTime - $r->a;
            } else {
                $missingReq[] = $r;
            }
        }

        foreach(array_reverse($missingReq) as $r){
            $totalAccessTime += $this->hd->goTo($r);

            $totalWaitTime += $totalAccessTime - $r->a;
        }

        echo "AccessTime=".$totalAccessTime/count($reqs)."\n";
        echo "WaitingTime=".$totalWaitTime/count($reqs)."\n";
    }

    private function orderReqs($reqs){
        function cmp($a, $b){
            if ($a->b == $b->b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        }
        
        usort($reqs, "cmp");
    }
}