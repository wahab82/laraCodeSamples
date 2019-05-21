<?php
/**
 * Created by PhpStorm.
 * User: Wahab
 * Date: 23/11/2017
 * Time: 10:11 PM
 */

namespace App\Http\Controllers\SystemManagement\Traits;

use App\Models\Management\Timezones;

trait Timezone
{
    public function updateTimezones()
    {
        $records = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        foreach ($records as $data)
        {
            (new Timezones())->saveTimezone($data);
        }
    }

    public function getTimezones()
    {
        if ($this->request->exists("filter"))
        {
            if(array_key_exists("filters" , $this->request->get("filter")))
            {
                return Timezones::GetAll($this->filter);
            }
        }
    }
}