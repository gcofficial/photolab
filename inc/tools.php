<?php

class Tools{

    /**
     * Join array to string
     * @param  array  $arr --- array like 'key' => 'value'
     * @return string --- joined string
     */
    public static function join($arr = array())
    {
        $arr    = self::removeEmpty($arr);
        $result = array();
        foreach ($arr as $key => $value) 
        {
            $result[] = sprintf('%s="%s"', $key, $value);
        }
        return implode(' ', $result);
    }

	/**
     * Remove empty elements
     * @param  array $arr --- array with empty elements
     * @return array --- array without empty elements
     */
    public static function removeEmpty($arr)
    {
        return array_filter($arr, function($var) { return $var != ''; });
    }

    /**
     * Lave just right keys in array
     * @param  array $right_keys --- right keys array
     * @param  array $arr --- array to sanitize
     * @return array --- sanitized array
     */
    public static function leaveRightKeys($right_keys, $arr)
    {
        if(count($arr))
        {
            foreach ($arr as $key => $value) 
            {
                if(!in_array($key, $right_keys)) unset($arr[$key]);
            }
        }
        return $arr;
    }

    /**
     * Leave keys from array
     * @param  array $remove_keys --- kyes to remove
     * @param  array $arr --- array from we need remove these keys
     * @return array --- sanitized array
     */
    public static function removeKeys($remove_keys, $arr)
    {
        if(count($remove_keys))
        {
            foreach ($remove_keys as $key => $value) 
            {
            	if(array_key_exists($value, $arr)) unset($arr[$value]);
            }
        }
        return $arr;
    }

    /**
     * Get key or return empty string
     * @param  string $key --- key name
     * @param  array $arr --- array to check key
     * @param  mixed $default --- default value
     * @return mixed --- key 
     */
    public static function tryGet($key, $arr, $default = '')
    {
    	if(array_key_exists($key, $arr)) return $arr[$key];
        return $default;
    }

    /**
     * Render your view
     * @param  string $view_name --- view name
     * @param  array $variables  --- variables to extract in rendering View
     * @return string            --- HTML code
     */
    public static function renderView($view_name, $variables = array())
    {
        extract($variables);
        ob_start();
        include sprintf('views/%s.php', $view_name);
        return ob_get_clean();
    }

    /**
     * Render select control
     * @param  array $values --- options for select ctrl
     * @param  string $attributes --- attributes to 
     * @return string         --- HTML code
     */
    public static function renderSelectControl($values, $attributes = array())
    {
        $attributes = array_merge(array('value' => ''), $attributes);
        return self::renderView(
            'select_control', 
            array(
                'attributes' => $attributes,
                'values'     => $values
            )
        );
    }
}