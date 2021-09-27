<?php

use Spatie\Permission\Models\Role;

if (!function_exists('createRole')) {
    /**
     * Create role
     * 
     * Creates role
     * 
     * @param string $role_name Role name
     * 
     * @return Role
     */
    function createRole($role_name)
    {
        return Role::firstOrCreate(['name' => $role_name]);
    }
}

if (!function_exists('updateRole')) {
    /**
     * Update role
     * 
     * Updates specified role
     * 
     * @param string $role_name Role to be changed
     * @param string $new_role_name Role's new name
     * 
     * @return Role
     */
    function updateRole($role_name, $new_role_name)
    {
        return Role::updateOrCreate(['name' => $role_name], ['name' => $new_role_name]);
    }
}

if (!function_exists('deleteRole')) {
    /**
     * Delete Role
     * 
     * Deletes specified role
     * 
     * @param string $role_name Role's name
     * 
     * @return bool Wether or not a role was deleted.
     */
    function deleteRole($role_name)
    {
        return (bool) Role::where('name',$role_name)->delete();
    }
}

if (!function_exists('floatFormat')) {
    /**
     * Float Format
     * 
     * Formates float to a string
     * 
     * @param Float $value value to be converted
     * @param Integer $decimal_places amount of decimal places (the default is 2)
     * @param String $decimal_separator decimal separator (the default is ',')
     * @param String $thousands_separator thousands separator (the default is '.')
     * 
     * @return String float formatted as string
     */
    function floatFormat($value, $decimal_places = 2, $decimal_separator = ',', $thousands_separator = '.')
    {
        try {
            return number_format($value, $decimal_places, $decimal_separator, $thousands_separator);
        } catch (\Throwable $th) {
            return number_format(0, 2, ',', '.');
        }
    }
}

if (!function_exists('strToFloat')) {
    /**
     * Str To Float
     * 
     * Parses string to float. Commas are converted to dots and any other non numeric character is erased. Simply put, only numbers, commas, dots and minus signs are kept.
     *  
     * Values that are already numeric are simply returned as they are
     * 
     * @param String $float_as_string
     * 
     * @return Float Converted string
     */
    function strToFloat($float_as_string)
    {
        try {
            return ((float) str_replace(",", ".", (preg_replace('/[^0-9,.-]+/', '', $float_as_string))));
        } catch (\Throwable $th) {
            return null;
        }
    }
}

if (!function_exists('isEnvProduction')) {
    /**
     * Is Env Production
     * 
     * Returns wether or not current environment is production
     * 
     * @return Boolean
     */
    function isEnvProduction()
    {
        return app()->environment() == "production";
    }
}

if (!function_exists('isEnvLocal')) {
    /**
     * Is Env Local
     * 
     * Returns wether or not current environment is local, by checking if it's different than production
     * 
     * @return Boolean
     */
    function isEnvLocal()
    {
        return !isEnvProduction();
    }
}
