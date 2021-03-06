<?php

declare(strict_types=1);

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Tests\Unit\HttpKernel\BundleCollection;

use Pimcore\HttpKernel\BundleCollection\Item;
use Pimcore\Tests\Test\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ItemTest extends TestCase
{
    public function testEmptyEnvironmentsMatchesAnyEnvironment()
    {
        $item = new Item(new ItemTestBundle(), 0, []);
        foreach (['prod', 'dev', 'test'] as $environment) {
            $this->assertTrue($item->matchesEnvironment($environment));
        }
    }

    public function testItemMatchesEnvironment()
    {
        $item = new Item(new ItemTestBundle(), 0, ['dev']);

        $this->assertTrue($item->matchesEnvironment('dev'));
        $this->assertFalse($item->matchesEnvironment('prod'));
        $this->assertFalse($item->matchesEnvironment('test'));
    }

    public function testItemWithMultipleEnvironments()
    {
        $item = new Item(new ItemTestBundle(), 0, ['dev', 'test']);

        $this->assertTrue($item->matchesEnvironment('dev'));
        $this->assertTrue($item->matchesEnvironment('test'));
        $this->assertFalse($item->matchesEnvironment('prod'));
    }
}

class ItemTestBundle extends Bundle
{
}
