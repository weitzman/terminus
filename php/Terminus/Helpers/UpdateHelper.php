<?php

namespace Terminus\Helpers;

use Terminus\Caches\FileCache;
use Terminus\Config;
use Terminus\Request;

class UpdateHelper extends TerminusHelper
{

  /**
   * Retrieves current version number from repository and saves it to the cache
   *
   * @return string The version number
   */
    public function getCurrentVersion()
    {
        $request  = new Request();
        $url = 'https://api.github.com/repos/pantheon-systems/terminus/releases/tags/0.x?per_page=1';
        try {
            $release = $request->request($url, ['absolute_url' => true,])['data'];
        } catch (\Exception $e) {
            return;
        }
        $cache = new FileCache();
        $cache->putData(
            'latest_release',
            ['version' => $release->name, 'check_date' => time(),]
        );
        return $release->name;
    }

  /**
   * Checks for new versions of Terminus once per week and saves to cache
   *
   * @return void
   */
    public function checkForUpdate()
    {
        $cache      = new FileCache();
        $cache_data = $cache->getData(
            'latest_release',
            ['decode_array' => true]
        );
        if (!$cache_data
        || ((int)$cache_data['check_date'] < (int)strtotime('-7 days'))
        ) {
            try {
                $current_version = $this->getCurrentVersion();
                if (version_compare($current_version, Config::get('version'), '>')) {
                    $this->command->log()->info(
                        'An update to Terminus is available. Please update to {version}.',
                        ['version' => $current_version]
                    );
                }
            } catch (\Exception $e) {
                $this->command->log()->info(
                    "Cannot retrieve current Terminus version.\n{msg}",
                    ['msg' => $e->getMessage(),]
                );
            }
        }
    }
}
