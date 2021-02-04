<?php
class ContactBean
{
    public $contactUserName;
    public $status;
    public $type;


    public function __construct($cun,$ty)
    {
        $this->contactUserName=$cun;
        $this->type=$ty;
    }
}

?>