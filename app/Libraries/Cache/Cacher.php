<?php

namespace App\Libraries\Cache;

trait Cacher
{
    /**
     * Get specific field from cache
     *
     * @param mixed $key
     * @param mix $value
     * @param null|string $operator
     * @return mixed
     */
    public function get(mixed $key, mixed $value = null, string $operator = '='): mixed
    {
        $data = $this->getFromCache();
        return $data->firstWhere($key, $operator, $value);
    }

    /**
     * Get all from cache
     *
     * @param string $key
     * @param null|string $value
     * @param string $operator
     * @return mixed
     */
    public function all(?array $fields = []): mixed
    {
        if (!empty($fields)) {
            $this->$this->getFromCache()->only($fields);
        }

        return $this->getFromCache();
    }
}
