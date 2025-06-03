<?php

namespace App\Message;

class Notification
{
    public function __construct(
        public $content,
    ) {
    }

    public function getContent(): array
    {
        return $this->content;
    }

}