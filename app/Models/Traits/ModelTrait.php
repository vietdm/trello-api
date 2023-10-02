<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait ModelTrait {
    public static function insert($data, $catchError = true) {
        $model = new self;
        foreach ($data as $key => $value) {
            $model->{$key} = $value;
        }
        if (!$catchError) {
            $model->save();
            return $model;
        }
        DB::beginTransaction();
        try {
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception|\PDOException $e) {
            DB::rollBack();
            logger($e);
            return false;
        }
    }
}
