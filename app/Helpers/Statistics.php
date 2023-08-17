<?php 

namespace App\Helpers;


class Statistics {

    public static function computeStats($model, $currentStats){
        return $model->when($currentStats == 'current_month', function($q){
            return $q->whereMonth('created_at', now()->month);
        })
        ->when($currentStats == 'previous_month', function($q){
            return $q->whereMonth('created_at', now()->subMonth()->month);
        })
        ->when($currentStats == 'current_year', function($q){
            return $q->whereYear('created_at', now()->year);
        })
        ->when($currentStats == 'previous_year', function($q){
            return $q->whereYear('created_at', now()->subYear()->year);
        })
        ->when($currentStats == 'current_week', function($q){
            return $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        })
        ->when($currentStats == 'previous_week', function($q){
            return $q->whereDate('created_at', now()->subDay()->day);
        })
        ->when($currentStats == 'today', function($q){
            return $q->whereDate('created_at', now()->today());
        })
        ->when($currentStats == 'yersterday', function($q){
            return $q->whereDate('created_at', now()->subDay()->day);
        });
    }

    public static function getSumByMonthInAYear($model, $currentStats, $fieldName){

        $stats = [];

        $res = $model->selectRaw("(SUM($fieldName)) as amount, MONTH(created_at) as month")
        ->when($currentStats == 'current_year' || !in_array($currentStats,['previous_year','current_year']), function($q){
            return $q->whereYear('created_at', now()->year);
        })
        ->when($currentStats == 'previous_year', function($q){
            return $q->whereYear('created_at', now()->subYear()->year);
        })
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->pluck('amount', 'month')
        ->toArray();

        foreach (range(1, 12) as $key => $monthIndex) {
            if(!array_key_exists($monthIndex, $res)){
                $stats[] = 0;
                continue;
            }

            $stats[] = $res[$monthIndex];        
        }

        return $stats; //Stats from January to December
    }

    public static function getTotalByMonthInAYear($model, $currentStats){

        $stats = [];

        $res = $model->selectRaw("(COUNT(*)) as total, MONTH(created_at) as month")
        ->when($currentStats == 'current_year' || !in_array($currentStats,['previous_year','current_year']), function($q){
            return $q->whereYear('created_at', now()->year);
        })
        ->when($currentStats == 'previous_year', function($q){
            return $q->whereYear('created_at', now()->subYear()->year);
        })
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get()
        ->pluck('total', 'month')
        ->toArray();

        foreach (range(1, 12) as $key => $monthIndex) {
            if(!array_key_exists($monthIndex, $res)){
                $stats[] = 0;
                continue;
            }

            $stats[] = $res[$monthIndex];        
        }

        return $stats; //Stats from January to December
    }

}
