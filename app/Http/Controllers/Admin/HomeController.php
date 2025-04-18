<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
    //

    public function __construct(){
        $this->middleware('can:home');
    }
    public function index(){
        $chart1_options = [
            'chart_title' => 'Posts by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\post',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',

            'filter_field' => 'created_at',
            'filter_days' => 3650,
        ];
        $chart1 = new LaravelChart($chart1_options);

        $chart2_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',

            'filter_field' => 'created_at',
            'filter_days' => 365,
        ];
        $chart2 = new LaravelChart($chart2_options);

        return view('dashboard.index' , compact('chart1' , 'chart2'));
    }
}
