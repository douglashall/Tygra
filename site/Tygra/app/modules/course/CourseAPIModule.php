<?php

class CourseAPIModule extends APIModule
{
    protected $id = 'course';
    protected $vmin = 1;
    protected $vmax = 1;

    public function initializeForCommand() {
        $this->invalidCommand();
    }
}


