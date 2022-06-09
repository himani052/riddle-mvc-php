<?php

namespace App\functions;

class Timer
{

    var $classname = "Timer";
    var $start = 0;
    var $stop = 0;
    var $elapsed = 0;

    # Constructor
    function Timer($start = true)
    {
        if ($start)
            $this->start();
    }

    # Start counting time
    function start()
    {
        $this->start = $this->_gettime();
    }

    # Stop counting time

    function _gettime()
    {
        $mtime = microtime();
        $mtime = explode(" ", $mtime);
        return $mtime[1] + $mtime[0];
    }

    # Get Elapsed Time

    function elapsed()
    {
        if (!$elapsed)
            $this->stop();

        return $this->elapsed;
    }

    # Resets Timer so it can be used again

    function stop()
    {
        $this->stop = $this->_gettime();
        $this->elapsed = $this->_compute();
    }

    #### PRIVATE METHODS ####

    # Get Current Time

    function _compute()
    {
        return $this->stop - $this->start;
    }

    # Compute elapsed time

    function reset()
    {
        $this->start = 0;
        $this->stop = 0;
        $this->elapsed = 0;
    }
}

