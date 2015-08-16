<?php

namespace Arandel\OtrsRpcClient\Struct;

class Struct
{
    /**
     * Struct constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
