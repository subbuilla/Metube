<?php

class MessageBean
{
    public $sentBy;
    public $sentTo;
    public $message;

    public function __construct($sentBy,$sentTo)
        {
            $this->sentBy=$sentBy;
            $this->sentTo=$sentTo;

        }






}
?>