<?php

namespace GintonicCMS\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;

class ThreadedHelper extends Helper
{
    /**
     * Transform threaded data into an unsorted list
     *
     * @param array $items the threaded data
     * @param string $key the key to use as display field
     * @return string
     */
    public function ul(array $items, $key)
    {
        $output = '<ul>';
        foreach ($items as $item) {
            $output .= '<li>' . $item[$key];

            if (!empty($item['children'])) {
                $output .= $this->ul($item['children'], $key);
            }

            $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
    }
}
