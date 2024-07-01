<?php

namespace App\Http\Controllers;

use App\Models\FormCheck;
use Illuminate\Http\Request;

class FormCheckController extends Controller
{
    /**
     * Display a listing of the form checks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formChecks = FormCheck::all();
        return view('form_checks.index', compact('formChecks'));
    }

    /**
     * Show the form for creating a new form check.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form_checks.create');
    }

    /**
     * Store a newly created form check in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        FormCheck::create($request->all());
        return redirect()->route('form_checks.index');
    }

    /**
     * Display the specified form check.
     *
     * @param  \App\Models\FormCheck  $formCheck
     * @return \Illuminate\Http\Response
     */
    public function show(FormCheck $formCheck)
    {
        return view('form_checks.show', compact('formCheck'));
    }

    /**
     * Show the form for editing the specified form check.
     *
     * @param  \App\Models\FormCheck  $formCheck
     * @return \Illuminate\Http\Response
     */
    public function edit(FormCheck $formCheck)
    {
        return view('form_checks.edit', compact('formCheck'));
    }

    /**
     * Update the specified form check in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormCheck  $formCheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormCheck $formCheck)
    {
        $formCheck->update($request->all());
        return redirect()->route('form_checks.index');
    }

    /**
     * Remove the specified form check from storage.
     *
     * @param  \App\Models\FormCheck  $formCheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormCheck $formCheck)
    {
        $formCheck->delete();
        return redirect()->route('form_checks.index');
    }
}

