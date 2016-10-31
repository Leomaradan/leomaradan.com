<?php

namespace App\Models;

trait TouchableTrait {

    private $touchWatch = true;

    public function setTouched($field) {

        if (!$this->touchWatch)
            return;


        $touched = explode(',', trim($this->touched));
        if (!in_array($field, $touched)) {
            $touched[] = $field;
        }

        sort($touched);

        $this->touched = implode(',', $touched);
    }

    public function isTouched($field) {
        $touched = explode(',', $this->touched);
        //dd($touched);
        return in_array($field, $touched);
    }

    public function deactivateTouchWatch() {
        $this->touchWatch = false;
    }

}
