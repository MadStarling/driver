<?php

namespace Politics;

class FCFS {

    public $hd, $fileReader, $file, $lastSector;

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

        foreach($reqs as $r){
            $totalAccessTime += $this->hd->goTo($r);

            $totalWaitTime += $totalAccessTime - $r->a;
        }

        echo "AccessTime=".$totalAccessTime/count($reqs)."\n";
        echo "WaitingTime=".$totalWaitTime/count($reqs)."\n";
    }
}