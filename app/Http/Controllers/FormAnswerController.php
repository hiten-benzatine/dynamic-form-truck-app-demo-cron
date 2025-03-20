<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormAnswer;
use Illuminate\Http\Request;

class FormAnswerController extends Controller
{
    public function store(Request $request, Form $form)
    {
        // dd($form->form_data);
        $request->validate([
            'answers' => 'required|array',
        ]);

        $answers = $request->input('answers');


        // Loop through answers and handle image uploads
        foreach ($request->answers as $index => $answer) {

            // Retrieve the field data from the form's JSON configuration
            $field = json_decode($form->form_data)[$index];

            // Check if the field type is 'image' and if a file has been uploaded
            if ($field->field_type == 'image' && $request->hasFile("answers.$index")) {
                // Generate a unique file name for the image
                $imageName = time() . '_' . $request->file("answers.$index")->getClientOriginalName();


                // Move the uploaded image to the public/images directory
                $request->file("answers.$index")->move(public_path('images'), $imageName);

                // Save the image file name/path in the answers array instead of the file object
                $answers[$index] = $imageName;
            }
        }

        // Check if this user has already submitted answers for this form
        $existingAnswer = FormAnswer::where('form_id', $form->id)->where('user_id', auth()->id())->first();

        if ($existingAnswer) {
            // Update existing answer with the new answers (including image paths)
            $existingAnswer->update([
                'answers' => json_encode($answers),  // Save the answers with the image file path
                'updated_at' => now(),
            ]);
        } else {
            // Create a new form answer entry with the answers (including image paths)
            FormAnswer::create([
                'form_id' => $form->id,
                'user_id' => auth()->id(),
                'answers' => json_encode($answers),  // Save the answers with the image file path
            ]);
        }

        // Redirect to a thank you page or another route
        return redirect()->route('forms.thankyou');
    }

    public function show(Form $form)
    {
        $answers = FormAnswer::where('form_id', $form->id)->get();

        return view('forms.answers', compact('answers', 'form'));
    }



