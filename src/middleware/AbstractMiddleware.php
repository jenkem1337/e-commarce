<?php

abstract class Middleware{

    private $next;


    public function linkWith(Middleware $next): Middleware
    {
        $this->next = $next;

        return $next;
    }


    public function check(): bool
    {
        if (!$this->next) {
            return true;
        }

        return $this->next->check();
    }
}
