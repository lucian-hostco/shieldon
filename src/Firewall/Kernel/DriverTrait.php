<?php
/**
 * This file is part of the Shieldon package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * php version 7.1.0
 * 
 * @category  Web-security
 * @package   Shieldon
 * @author    Terry Lin <contact@terryl.in>
 * @copyright 2019 terrylinooo
 * @license   https://github.com/terrylinooo/shieldon/blob/2.x/LICENSE MIT
 * @link      https://github.com/terrylinooo/shieldon
 * @see       https://shieldon.io
 */

declare(strict_types=1);

namespace Shieldon\Firewall\Kernel;

use Shieldon\Firewall\Driver\DriverProvider;
use LogicException;
use RuntimeException;

/*
 * Messenger Trait is loaded in Kernel instance only.
 */
trait DriverTrait
{
    /**
     *   Public methods       | Desctiotion
     *  ----------------------|---------------------------------------------
     *   setDriver            | Set a data driver.
     *   setChannel           | Set a data channel.
     *   disableDbBuilder     | disable creating data tables.
     *  ----------------------|---------------------------------------------
     */

    /**
     * Driver for storing data.
     *
     * @var \Shieldon\Firewall\Driver\DriverProvider
     */
    public $driver;

    /**
     * This is for creating data tables automatically
     * Turn it off, if you don't want to check data tables every connection.
     *
     * @var bool
     */
    protected $isCreateDatabase = true;

    /**
     * Set a data driver.
     *
     * @param DriverProvider $driver Query data from the driver you choose to use.
     *
     * @return void
     */
    public function setDriver(DriverProvider $driver): void
    {
        $this->driver = $driver;
    }

    /**
     * Set a data channel.
     *
     * This will create databases for the channel.
     *
     * @param string $channel Specify a channel.
     *
     * @return void
     */
    public function setChannel(string $channel): void
    {
        if (!$this->driver) {
            throw new LogicException('setChannel method requires setDriver set first.');
        } else {
            $this->driver->setChannel($channel);
        }
    }

    /**
     * Shieldon creating data tables automatically.
     * Turning it off when the data tables exist overwise checling 
     * every pageview.
     * 
     * @return void
     */
    public function disableDbBuilder(): void
    {
        $this->isCreateDatabase = false;
    }

    /**
     * Check the data driver, throw an exception if not set.
     *
     * @return void
     */
    protected function assertDriver(): void
    {
        if (!isset($this->driver)) {
            throw new RuntimeException(
                'Data driver must be set.'
            );
        }
    }
}
