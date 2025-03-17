<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trucker form</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Trucking Cron Demo simple form</h1>
        <form action="{{ route('forms.store') }}" method="POST">
            @csrf

            <div class="form-group" id="fieldsContainer">
                <!--  Fields will be appended here -->
            </div>

            <button type="button" id="addField" class="btn btn-secondary">Add Field</button>
            <button type="submit" class="btn btn-success">Create Form</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Add new  form field
            $('#addField').click(function() {
                var fieldIndex = $('#fieldsContainer').children().length;

                // Create the new  field form group
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
                                <option value="image">Image</option>
                            </select>
                        </div>

                        <div class="form-group" id="options-container-${fieldIndex}" style="display: none;">
                            <label for="field_options_${fieldIndex}">Field Options</label>
                            <input type="text" name="field_options[${fieldIndex}][]" class="form-control mb-2" placeholder="Option 1">
                            <button type="button" class="btn btn-secondary" id="add-option-${fieldIndex}">Add Option</button>
                        </div>
                </div>

                        <hr>
                    </div>
                `;

                // Append the new field group to the form
                $('#fieldsContainer').append(newFieldHTML);

                // Show options container for radio, checkbox, or dropdown fields
                $(`#field_type_${fieldIndex}`).change(function() {
                    var selectedOption = $(this).val();
                    if (selectedOption === 'radio' || selectedOption === 'checkbox' || selectedOption === 'dropdown') {
                        $(`#options-container-${fieldIndex}`).show();
                    } else {
                        $(`#options-container-${fieldIndex}`).hide();

                    }
                });



                // Add more options for the radio, checkbox, and dropdown fields
                $(`#add-option-${fieldIndex}`).click(function() {
                
                    var optionsContainer = $(`#options-container-${fieldIndex}`);
                    var optionIndex = optionsContainer.children('input').length + 1;
                    var newOption = $(`
                        <div class="option-group mb-2">
                            <input type="text" name="field_options[${fieldIndex}][]" class="form-control" placeholder="Option ${optionIndex}">
                            <button type="button" class="btn btn-danger delete-option" style="margin-left: 10px;">Delete</button>
                        </div>
                    `);
                    optionsContainer.append(newOption);
                });
                $(document).on('click', '.delete-option', function() {
                    $(this).parent().remove();
                });
            });
        });
    </script>
</body>

</html>