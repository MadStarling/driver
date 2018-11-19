<?php

namespace Politics;

class CScan {

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
        $currentTime = 0;

        while(count($reqs) > 0){
            $missingReq = [];

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
            $currentTime += $totalAccessTime + 1;
            $totalWaitTime += $totalAccessTime - $finalReq->a;
            $reqs = $missingReq;
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