<?php

namespace App\Libraries\Validation\Trait;

trait HasSubRules
{
    /**
     * Map child rules with prefix
     *
     * @param string $prefix
     * @param array $subRules
     * @return array rules of subRules
     */
    public function subRules(string $prefix, array $subRules)
    {
        $result = [];
        foreach ($subRules as $key => $rules) {
            $result[$prefix . '.' . $key] = $rules;
        }

        return $result;
    }
}
