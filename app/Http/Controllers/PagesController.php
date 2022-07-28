<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\Job;
use App\Models\JobRequest;
use App\Models\Tender;
use App\Models\TenderRequest;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {
        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';
        $tender = Tender::count();
        $worker = Worker::count();
        $contractor = Contractor::count();
        $job = Job::count();

        $TenderChart = TenderRequest::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')->get();
        $TenderChart = $TenderChart->pluck('count');
        $JobChart = JobRequest::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')->get();
        $JobChart = $JobChart->pluck('count');

        $WorkerChart = Worker::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
            ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')->get();
        $WorkerChart = $WorkerChart->pluck('count');

        return view('pages.dashboard', compact(
            'page_title',
            'page_description',
            'tender',
            'worker',
            'contractor',
            'job',
            'TenderChart',
            'JobChart',
            'WorkerChart'
        ));
    }

    /**
     * Demo methods below
     */

    // Datatables
    public function datatables()
    {
        $page_title = 'Datatables';
        $page_description = 'This is datatables test page';

        return view('pages.datatables', compact('page_title', 'page_description'));
    }

    // KTDatatables
    public function ktDatatables()
    {
        $page_title = 'KTDatatables';
        $page_description = 'This is KTdatatables test page';

        return view('pages.ktdatatables', compact('page_title', 'page_description'));
    }

    // Select2
    public function select2()
    {
        $page_title = 'Select 2';
        $page_description = 'This is Select2 test page';

        return view('pages.select2', compact('page_title', 'page_description'));
    }

    // custom-icons
    public function customIcons()
    {
        $page_title = 'customIcons';
        $page_description = 'This is customIcons test page';

        return view('pages.icons.custom-icons', compact('page_title', 'page_description'));
    }

    // flaticon
    public function flaticon()
    {
        $page_title = 'flaticon';
        $page_description = 'This is flaticon test page';

        return view('pages.icons.flaticon', compact('page_title', 'page_description'));
    }

    // fontawesome
    public function fontawesome()
    {
        $page_title = 'fontawesome';
        $page_description = 'This is fontawesome test page';

        return view('pages.icons.fontawesome', compact('page_title', 'page_description'));
    }

    // lineawesome
    public function lineawesome()
    {
        $page_title = 'lineawesome';
        $page_description = 'This is lineawesome test page';

        return view('pages.icons.lineawesome', compact('page_title', 'page_description'));
    }

    // socicons
    public function socicons()
    {
        $page_title = 'socicons';
        $page_description = 'This is socicons test page';

        return view('pages.icons.socicons', compact('page_title', 'page_description'));
    }

    // svg
    public function svg()
    {
        $page_title = 'svg';
        $page_description = 'This is svg test page';

        return view('pages.icons.svg', compact('page_title', 'page_description'));
    }

    // Quicksearch Result
    public function quickSearch()
    {
        return view('layout.partials.extras._quick_search_result');
    }
}
