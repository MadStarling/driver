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
        $reqs = $this->orderReqs($reqs);

        $totalWaitTime = 0;
        $totalAccessTime = 0;

        $initialPos = $this->hd->getCurrentPosition();
        $missingReq = [];
        $currentTime = 0;

        $reqsLength = count($reqs);

        while(count($reqs) > 0){

            foreach($reqs as $r){
                if($r->b > $initialPos && $r->a >= $currentTime){
                    $totalAccessTime += $this->hd->goTo($r);
                    $currentTime += $totalAccessTime;
                    $totalWaitTime += $totalAccessTime - $r->a;
                } else {
                    $missingReq[] = $r;
                }
            }

            $finalReq = new \Obj\Request($currentTime, $this->lastSector, 0, 0);

            $totalAccessTime += $this->hd->goTo($finalReq);
            $currentTime += $totalAccessTime;
            $totalWaitTime += $totalAccessTime - $finalReq->a;
            $reqs = [];

            foreach(array_reverse($missingReq) as $r){
                if($r->a >= $currentTime){
                    $totalAccessTime += $this->hd->goTo($r);

                    $totalWaitTime += $totalAccessTime - $r->a;
                } else {
                    $reqs[] = $r;
                }
            }
        }

        echo "AccessTime=".$totalAccessTime/count($reqsLength)."\n";
        echo "WaitingTime=".$totalWaitTime/count($reqsLength)."\n";
    }

    private function orderReqs($reqs){
        usort($reqs, [$this, "cmp"]);

        return $reqs;
    }

    private function cmp($a, $b){
        if ($a->b == $b->b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }
}