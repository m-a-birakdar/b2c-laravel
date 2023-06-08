<?php

namespace Modules\Report\Http\Controllers\DaApi;

use Modules\Report\Enums\TypeEnum;
use Illuminate\Routing\Controller;

class ValidateMethodsController extends Controller
{
    public array $values = [];

    private function matchRouteMethod($main): bool
    {
        $request = request();
        return match ($request->route()->getActionMethod()){
            'show', 'compareOne' => ( $main || ! $this->validateType($request->input('type'), $request->all()) ),
            'index', 'compareMany' => ( $main || ! $request->has('sub') || ! is_numeric($request->input('sub')) ||  (int) $request->input('sub') != $request->input('sub') ),
        };
    }

    private function validateTypeInRequest(): bool
    {
        $request = request();
        return ! $request->has('type') || ! in_array($request->has('type'), array_column(TypeEnum::cases(), 'value'));
    }

    public function validateRouteMethodMain(): bool
    {
        return $this->matchRouteMethod($this->validateTypeInRequest());
    }

    public function validateRouteMethod($module, $repository): bool
    {
        $request = request();
        $main = (
            ! $request->has($module . '_id') || $this->validateTypeInRequest() || ! $this->validateModules($request->input($module . '_id'), $repository)
        );
        return $this->matchRouteMethod($main);
    }

    private function validateModules($id, $repository): bool
    {
        $ids = is_string($id) ? explode(',', $id) : (array) $id;
        foreach ($ids as $id)
            if (! ( $repository )->exists($id))
                return false;
        return true;
    }

    private function validateType($type, $request): bool
    {
        $types = match ($type){
            TypeEnum::YEARLY->value => [
                'y'
            ],
            TypeEnum::MONTHLY->value => [
                'y', 'm'
            ],
            TypeEnum::WEEKLY->value, TypeEnum::DAILY->value => [
                'y', 'm', 'd'
            ],
        };
        $keys = array_keys($request);
        foreach ($types as $new)
            if (! in_array($new, $keys))
                return false;
        $this->values = array_intersect_key($request, array_flip($types));
        return true;
    }
}
