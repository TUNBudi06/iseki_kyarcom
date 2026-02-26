<?php

namespace App\Http\Controllers;

use App\Exports\TractorKyarcomExportTemplate;
use App\Imports\TractorKyarcomImport;
use App\Models\DateKyarCom;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ComputeController extends Controller
{
    public function index()
    {

        $list = dateKyarCom::query();


        return Inertia::render('Compute/Index', [
            'list' => $list->get(),
            'today' => $list->where('date', date('Y-m-d'))->first(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'name' => 'required|string|max:255',
        ]);

        DateKyarCom::updateOrCreate(
            ['date' => $request->date],
            ['name' => $request->name]
        );

        return redirect()->route('kyarcom.kyarcom-data-list')->with('success', 'Data saved successfully.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new TractorKyarcomExportTemplate, 'tractor_kyarcom_template.xlsx');
    }

    public function importKyarcom(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        // Handle file upload and processing here
        // You can use Excel::import() to import the data from the uploaded file

        return redirect()->route('kyarcom.kyarcom-data-list')->with('success', 'File imported successfully.');
    }

    public function importTractroKyarcom(Request $request)
    {
        $request->validate([
            'file'      => 'required|file|mimes:xlsx,xls,csv',
            'timestamp' => 'required|string',
        ]);

        $import = new TractorKyarcomImport($request->input('timestamp'));

        Excel::import($import, $request->file('file'));

        return redirect()->route('kyarcom.kyarcom-data-list')
            ->with('success', 'File imported successfully.');
    }
}
