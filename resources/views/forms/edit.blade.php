    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Form</title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    </head>

    <body>
        <div class="container">
            <h1>Edit Trucking Testing Reminder Data Form</h1>
            <form action="{{ route('forms.update', $form->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group" id="fieldsContainer">
                    <!-- Fields will be appended here -->
                    @foreach(json_decode($form->form_data) as $index => $field)
                    <div class="field-group" data-index="{{ $index }}">
                        <div class="form-group">
                            <label for="label_{{ $index }}">Label</label>
                            <input type="text" name="label[{{ $index }}]" id="label_{{ $index }}" class="form-control" value="{{ $field->label }}" required>
                        </div>

                        <div class="form-group">
                            <label for="is_required_{{ $index }}">Is Required</label>
                            <select name="is_required[{{ $index }}]" id="is_required_{{ $index }}" class="form-control">
                                <option value="0" {{ $field->is_required == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $field->is_required == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="field_type_{{ $index }}">Field Type</label>
                            <select name="field_type[{{ $index }}]" id="field_type_{{ $index }}" class="form-control">
                                <option value="text" {{ $field->field_type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="textarea" {{ $field->field_type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                <option value="radio" {{ $field->field_type == 'radio' ? 'selected' : '' }}>Radio Button</option>
                                <option value="checkbox" {{ $field->field_type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                <option value="dropdown" {{ $field->field_type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                <option value="image" {{ $field->field_type == 'image' ? 'selected' : '' }}>Image</option>
                            </select>
                        </div>

                        <div class="form-group" id="options-container-{{ $index }}" style="{{ in_array($field->field_type, ['radio', 'checkbox', 'dropdown']) ? 'display:block;' : 'display:none;' }}">
                            <label for="field_options_{{ $index }}">Field Options (comma-separated)</label>
                            @foreach($field->field_options as $optionIndex => $option)
                            <div class="option-group">
                                <input type="text" name="field_options[{{ $index }}][]" class="form-control mb-2" value="{{ $option }}" placeholder="Option">
                                <button type="button" class="btn btn-danger delete-option" style="margin-left: 10px;">Delete</button>
                            </div>
                            @endforeach

                            <button type="button" class="btn btn-secondary add-option" data-index="{{ $index }}">Add Option</button>


                        </div>

                        <hr>
                    </div>
                    @endforeach
                </div>

                <button type="button" id="addField" class="btn btn-secondary">Add Field</button>
                <button type="submit" class="btn btn-success">Update Form</button>
            </form>
        </div>

        <script>
            $(document).ready(function() {

                // Handle field type change for dynamically added fields
                $('#addField').click(function() {
                    var fieldIndex = $('#fieldsContainer').children().length;

                    var newFieldHTML = `
            <div class="field-group" data-index="${fieldIndex}">
                <div class="form-group">
                    <label for="label_${fieldIndex}">Label</label>
                    <input type="text" name="label[${fieldIndex}]" id="label_${fieldIndex}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="is_required_${fieldIndex}">Is Required</label>
                    <select name="is_required[${fieldIndex}]" id="is_required_${fieldIndex}" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="field_type_${fieldIndex}">Field Type</label>
                    <select name="field_type[${fieldIndex}]" id="field_type_${fieldIndex}" class="form-control">
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                        <option value="radio">Radio Button</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="dropdown">Dropdown</option>
                    </select>
                </div>

                <div class="form-group" id="options-container-${fieldIndex}" style="display: none;">
                    <label for="field_options_${fieldIndex}">Field Options (comma-separated)</label>
                    <input type="text" name="field_options[${fieldIndex}][]" class="form-control mb-2" placeholder="Option 1">
                    <button type="button" class="btn btn-secondary add-option" data-index="${fieldIndex}">Add Option</button>
                </div>

                <hr>
            </div>
        `;

                    $('#fieldsContainer').append(newFieldHTML);

                    // Handle field type change for newly created fields


                });

                // Use event delegation to handle "Add Option" for dynamically created fields
                $(document).on('click', '.add-option', function() {
                    var fieldIndex = $(this).data('index');
                    var optionsContainer = $(`#options-container-${fieldIndex}`);
                    var newOption = `
            <div class="option-group mb-2">
                <input type="text" name="field_options[${fieldIndex}][]" class="form-control" placeholder="Option ${optionsContainer.children().length + 1}">
                <button type="button" class="btn btn-danger delete-option" style="margin-left: 10px;">Delete</button>
            </div>
        `;
                    optionsContainer.append(newOption);
                });

                // Delete option functionality
                $(document).on('click', '.delete-option', function() {
                    $(this).closest('.option-group').remove();
                });

                // This is the key part: When the page is loaded (during edit), check the existing field types and show the options container if needed
                $(document).on('change', 'select[name^="field_type"]', function() {
                    var fieldIndex = $(this).closest('.field-group').data('index');
                    var selectedOption = $(this).val();

                    if (selectedOption === 'radio' || selectedOption === 'checkbox' || selectedOption === 'dropdown') {
                        $(`#options-container-${fieldIndex}`).show();
                    } else {
                        $(`#options-container-${fieldIndex}`).hide();
                    }
                });
            });
        </script>
    </body>

    </html>