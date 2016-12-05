<?php

namespace NotifyException\Drivers;

/**
 * Interface BaseDriver
 *
 * @package NotifyException\Drivers
 */
interface BaseDriver {

    public function configure($config);
    public function push($message);

}
