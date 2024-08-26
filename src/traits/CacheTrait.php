<?php

namespace app\traits;

use Yii;

trait CacheTrait
{
    public function cacheGet($key)
    {
        return Yii::$app->cache->get($key);
    }

    public function cacheSet($key, $value, $duration = 3600)
    {
        Yii::$app->cache->set($key, $value, $duration);
    }

    public function cacheDelete($key)
    {
        Yii::$app->cache->delete($key);
    }

    public function cacheClear()
    {
        Yii::$app->cache->flush();
    }
}
