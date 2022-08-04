<?php

namespace App\Modules\Setting;

use App\Libraries\Crud\CrudService;
use App\Libraries\Cache\Cacher;
use App\Libraries\Cache\WithCache;
use App\Modules\Setting\Enum\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingService extends CrudService implements WithCache
{
    use Cacher;

    protected array $allowedRelations = [];

    private $cacheName = 'settings';

    public function __construct(SettingRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Get all settings and cache
     *
     * @return Collection
     */
    public function getFromCache(): Collection
    {
        return Cache::rememberForever($this->cacheName, function () {
            return $this->repo->getMany(['setting_key']);
        });
    }

    /**
     * Clear settings Cache
     *
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheName);
    }

    /**
     * Find value of setting by it's key
     *
     * @return mix Setting Value
     */
    public function value(Setting $key): mixed
    {
        $setting = $this->get('setting_key', $key->value);
        if (!$setting) {
            return null;
        }

        return $setting->setting_value;
    }

    /**
     * @return array|object
     */
    public function getTheme()
    {
        return $this->value(Setting::WEBSITE_THEME);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function saveTheme(Request $request)
    {
        $theme = $this->repo->getOneWhere(['setting_key' => Setting::WEBSITE_THEME->value]);

        if (!$theme) {
            return $this->repo->createOne([
                'setting_key' => Setting::WEBSITE_THEME->value,
                'setting_value' => json_encode($request->theme)
            ]);
        }

        $this->repo->updateOne($theme, [
            'setting_value' => json_encode($request->theme)
        ]);

        $this->clearCache();

        return $theme;
    }
}
