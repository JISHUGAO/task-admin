<?php
namespace App\Transformers;

use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Adapter\Fractal;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;


class TaskTransformer extends TransformerAbstract
{

    public function transform(Model $model)
    {
        return [];
    }
}