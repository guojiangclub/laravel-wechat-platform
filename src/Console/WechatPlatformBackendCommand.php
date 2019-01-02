<?php
/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Console;

use Illuminate\Console\Command;
use iBrand\Wechat\Platform\Seeds\WechatPlatFormBackendTablesSeeder;

class InstallCommand extends Command
{

    protected $signature = 'ibrand-wechat-platform:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ibrand wechat platform install';

    public function handle()

    {
        $this->call('db:seed', ['--class' => WechatPlatFormBackendTablesSeeder::class]);

        $this->call('migrate');

        $this->info('ibrand wechat platform install successfully.');

    }


}
