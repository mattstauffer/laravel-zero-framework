<?php

declare(strict_types=1);

/**
 * This file is part of Laravel Zero.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace LaravelZero\Framework\Components\Updater;

use Illuminate\Console\OutputStyle;
use Humbug\SelfUpdate\Updater as PharUpdater;

/**
 * @internal
 */
final class Updater
{
    /**
     * The base updater.
     *
     * @var \Humbug\SelfUpdate\Updater
     */
    private $updater;

    /**
     * Updater constructor.
     *
     * @param \Humbug\SelfUpdate\Updater $updater
     */
    public function __construct(PharUpdater $updater)
    {
        $this->updater = $updater;
    }

    /**
     * @param \Illuminate\Console\OutputStyle
     *
     * @return void
     */
    public function update(OutputStyle $output): void
    {
        $result = $this->updater->update();

        if ($result) {
            $output->success(printf('Updated from version %s to %s.', $this->updater->getOldVersion(),
                $this->updater->getNewVersion()));
            exit(0);
        } elseif (! $this->updater->getNewVersion()) {
            $output->success('There are no stable builds available.');
        } else {
            $output->success('You have the current stable build installed.');
        }
    }
}
