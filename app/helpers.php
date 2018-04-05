<?php

use Illuminate\Support\Str;

function uuid()
{
    return (string) Str::uuid();
}
