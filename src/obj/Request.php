<?php
namespace Obj;

class Request {

    public $a, $b, $c, $d;

    public function __construct($a, $b, $c, $d){
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
    }
}