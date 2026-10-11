<?php

namespace Supalta\Cannelle ;

/**
 * Leftover class from the start of the project
 */
class Dummy
{
    private string $msg = "Hello World !";

    /**
     * Display the message then a greeting to the given name
     * @param string $name
     * @return void
     */
    public function greeting(string $name): void
    {
        echo $this->msg . "\n";
        echo "Hello $name\n";
    }
}
