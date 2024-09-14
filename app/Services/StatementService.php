<?php

namespace App\Services;
use App\Models\Statement;

class StatementService
{
    public static function getList($request)
    {
        $dataSearch = $request->all();

        if(!empty($dataSearch['page']) && $dataSearch['page'] == 'all') {
            return Statement::all();
        }

        $query = Statement::query();

        if(!empty($dataSearch['send_at'])) {
            $query->where('send_at', $dataSearch['send_at']);
        }

        if(!empty($dataSearch['description'])) {
            $query->where('description', 'like', '%' . $dataSearch['description'] . '%');
        }

        if(!empty($dataSearch['send_by'])) {
            $query->where('send_by', $dataSearch['send_by']);
        }

        if(!empty($dataSearch['transaction_id'])) {
            $query->where('transaction_id', $dataSearch['transaction_id']);
        }

        return $query->paginate(config('app.number_per_page'));
    }
}
