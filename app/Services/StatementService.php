<?php

namespace App\Services;
use App\Models\Statement;

class StatementService
{
    public static function getList($request)
    {
        $dataSearch = $request->all();

        $query = Statement::query();

        if(!empty($dataSearch['description'])) {
            $query->where('description', 'like', '%' . $dataSearch['description'] . '%');
        }

        if(!empty($dataSearch['send_by'])) {
            $query->where('send_by', $dataSearch['send_by']);
            $query->orWhere('description', 'like', '%' . $dataSearch['send_by'] . '%');
        }


        if(!empty($dataSearch['transaction_id'])) {
            $query->where('transaction_id', $dataSearch['transaction_id']);
        }

        return $query->paginate(10);
    }
}
