<?php

namespace Supalta\Cannelle ;

class Dummy
{

    private string $msg = "Hello World !";

    /**
     * @param string $name
     * @return void
     */
    public function greeting(string $name) : void
    {
        echo $this->msg . "\n";
        echo "Hello $name\n";
    }

}