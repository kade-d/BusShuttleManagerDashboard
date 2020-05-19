<?php

class Loop {

    public $id;
    public $loopName;

    /**
     * Loop constructor.
     * @param $_id
     * @param $_loopName
     */
    public function __construct($_id, $_loopName)
    {
        $this->id = $_id;
        $this->loopName = $_loopName;
    }

}

?>