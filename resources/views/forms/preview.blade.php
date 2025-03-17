<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Form</title>
</head>

<body>
    <div class="container">
        <h1>Trucking Cron Demo Form</h1>
        <form action="{{ route('forms.answers.store', $form) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @foreach(json_decode($form->form_data) as $field)
            <div class="form-group">
                <label>{{ $field->label }}</label>

                @if($field->field_type == 'text')
                <input type="text" name="answers[{{ $loop->index }}]" class="form-control" required="{{ $field->is_required ? 'required' : '' }}">


                @elseif($field->field_type == 'textarea')
                <textarea name="answers[{{ $loop->index }}]" class="form-control" required="{{ $field->is_required ? 'required' : '' }}"></textarea>

                @elseif($field->field_type == 'image')
                <input type="file" name="answers[{{ $loop->index }}]" class="form-control" required="{{ $field->is_required ? 'required' : '' }}">

                @elseif($field->field_type == 'radio')
                @foreach($field->field_options as $option)
                <label>
                    <input type="radio" name="answers[{{ $loop->parent->index }}]" value="{{ $option }}" required="{{ $field->is_required ? 'required' : '' }}">
                    {{ $option }}
                </label><br>
                @endforeach

                @elseif($field->field_type == 'checkbox')
                @foreach($field->field_options as $option)
                <label>
                    <input type="checkbox" name="answers[{{ $loop->parent->index }}][]" value="{{ $option }}">
                    {{ $option }}
                </label><br>
                @endforeach

                @elseif($field->field_type == 'dropdown')
                <select name="answers[{{ $loop->index }}]" class="form-control" required="{{ $field->is_required ? 'required' : '' }}">
                    <option value="">Select Option</option>
                    @foreach($field->field_options as $option)
                    <option>{{ $option }}</option>
                    @endforeach
                </select>
                @endif
            </div>
            @endforeach

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</body>

</html>