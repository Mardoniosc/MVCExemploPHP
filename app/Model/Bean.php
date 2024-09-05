<?php

namespace App\Model;

abstract class  Bean {
    public $id;

    public function verifyAttibutesNotNull($arrayEscape) {

        $params = get_object_vars($this);

        foreach ($params as $key => $value) {
            if (in_array($key,$arrayEscape)) {
                continue;
            } elseif ($value === null || $value === "") {
                return false;
            }
        }
        return true;
    }
}

