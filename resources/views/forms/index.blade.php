<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>Trucking Cron Demo  Forms</h1>
        <a href="{{ route('forms.create') }}" class="btn btn-primary">Create New Form</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Label</th>
                    <th>Field Type</th>
                    <th>Actions</th>
                    <th>Answer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($forms as $form)

                <tr>
                    <td>{{ $form->id }}</td>
                    
                    <td>
                        @foreach(json_decode($form->form_data) as $field)
                        <p>{{ $field->label }}</p>
                        @endforeach
                    </td>


                    <!-- Display the field types (could be text, textarea, etc.) -->
                    <td>
                        @foreach(json_decode($form->form_data) as $field)
                        <p>{{ ucfirst($field->field_type) }}</p>
                        @endforeach
                    </td>

                    <td>
                        <!-- Links to Edit or Delete the Form -->
                        <a href="{{ route('forms.edit', $form) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('forms.destroy', $form) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <a href="{{ route('forms.preview', $form) }}" class="btn btn-info">Preview</a>
                    </td>

                    <td>
                        <!-- Link to see answers for this form -->
                        <a target="_blank" href="{{ route('forms.answers.show', $form) }}" class="btn btn-info">Answer</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>