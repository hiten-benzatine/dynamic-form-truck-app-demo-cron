<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        // Validate that required fields are provided
        $request->validate([
            'label' => 'required|array',
            'field_type' => 'required|array',
            'is_required' => 'required|array',
        ]);

        // Collect all the form data into an array structure
        $formFields = [];
        // dd($request->all());
        // Group the fields based on the input names and create a structured format
        foreach ($request->label as $index => $label) {
            $formFields[] = [
                'label' => $label,
                'field_type' => $request->field_type[$index],
                'is_required' => $request->is_required[$index],
                'field_options' => isset($request->field_options[$index]) ? $request->field_options[$index] : [],
            ];
        }

        // Store the entire form structure in the database as a JSON
        Form::create([
            'form_data' => json_encode($formFields) // Save all fields in one column as JSON
        ]);

        return redirect()->route('forms.index');
    }
    public function edit(Form $form)
    {
        return view('forms.edit', compact('form'));
    }

    // public function update(Request $request, Form $form)
    // {
    //     $form->update($request->all());
    //     return redirect()->route('forms.index');
    // }



    public function update(Request $request, $id)
    {
        // Validate that required fields are provided
        $request->validate([
            'label' => 'required|array',
            'field_type' => 'required|array',
            'is_required' => 'required|array',
        ]);

        // Collect all the form data into an array structure
        $formFields = [];
        foreach ($request->label as $index => $label) {
            $formFields[] = [
                'label' => $label,
                'field_type' => $request->field_type[$index],
                'is_required' => $request->is_required[$index],
                'field_options' => isset($request->field_options[$index]) ? $request->field_options[$index] : [],
            ];
        }

        // Update the form data in the database
        $form = Form::findOrFail($id);
        $form->form_data = json_encode($formFields); // Save all fields in one column as JSON
        $form->save();

        return redirect()->route('forms.index');
    }
    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('forms.index');
    }

    public function preview(Form $form)
    {

        return view('forms.preview', compact('form'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function test()
    {
        $form = Form::find(1);
    }
}
