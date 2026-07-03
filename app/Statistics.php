<?php

namespace App;

use App\Models\Photo;
use Illuminate\Support\Facades\Cache;

class Statistics
{
    private static $statisticsFile = 'app/private/statistics.json';

    public $memberCount = 0;

    //public $meetsToDate = 0;

    public $meetPhotos = 0;

    public static function get(): ?Statistics
    {
        $data = self::loadData();
        if ($data === null) return null;

        $statistics = new Statistics();
        $statistics->memberCount = $data['memberCount'];
        //$statistics->meetsToDate = $data['meetsToDate'];
        $statistics->meetPhotos = $data['meetPhotos'];
        return $statistics;
    }

    public static function save($data): void
    {
        file_put_contents(storage_path(self::$statisticsFile), json_encode($data));
        Cache::forget('statistics');
    }

    private static function loadData()
    {
        return Cache::remember('statistics', 600, function () {
            if (!file_exists(storage_path(self::$statisticsFile))) {
                return null;
            }

            $json = json_decode(file_get_contents(storage_path(self::$statisticsFile)), true);
            $json['meetPhotos'] = Photo::count();
            return $json;
        });
    }
}
