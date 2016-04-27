<?php

namespace M2Digital\Extras\Illuminate\Support;

use Illuminate\Support\Collection as BaseCollection;

class Collection extends BaseCollection {

    /**
     * Search a key by keyword.
     *
     * @param $keyword
     * @return bool|static
     */
    public function like($keyword) {
        
        if(is_null($keyword) || empty($keyword)) {
            return false;
        }
        
        $newItems = [];
        
        $this->filter(function($value, $key) use ($keyword, &$newItems) {
            if (strpos($key, $keyword)) {
                $newItems[$key] = $value;
            }
        });

        return $this->make($newItems);

    }

}