<?php
namespace Utilities;

class FileReader {

    public function getReqs($filePath, $parent){
        $i = 3;
        $reqs = [];

        $fh = fopen(__DIR__.$filePath, 'r');

        $nSec = explode("=", fgets($fh))[1];
        
        $parent->lastSector = $nSec;

        $nTracks = fgets($fh);
        $sP = fgets($fh);

        $sP;

        $parent->setHd(new \Obj\HD($sP));

        while ($line = fgets($fh)) {
            if($line === ";") break;
            
            $values = explode("=", $line)[1];
            $abcd = explode(",", $values);

            $reqs[] = new \Obj\Request(...$abcd);
        }

        fclose($fh);

        return $reqs;
    }
}