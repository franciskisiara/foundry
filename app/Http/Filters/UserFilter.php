<?php
namespace App\Http\Filters;

use Agog\Osmose\Library\OsmoseFilter;
use Agog\Osmose\Library\Services\Contracts\OsmoseFilterInterface;

class UserFilter extends OsmoseFilter implements OsmoseFilterInterface
{
    /**
     * Defines compulsory filter rules
     * @return array
     */
    public function bound () :array
    {
        return [
            function ($query) {
                return $query->whereHas('roles', function ($builder) {
                    $builder->where("roles.name", "like", "sysadmins::%");
                });
            }
        ];
    }

    /**
     * Defines form elements and sieve values
     * @return array
     */
    public function residue () :array
    {
        return [
            'search' => function ($query, $value) {
                return $query->where('name', 'like', "%$value%")
                            ->orWhere('email', 'like', "%$value%")
                            ->orWhere('phone', 'like', "%$value%");
            }
        ];
    }
}
