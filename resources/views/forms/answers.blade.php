<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Answers for Form: {{ $form->label }}</title>
    <!-- Bootstrap 5 CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for a cleaner design -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        .btn {
            font-size: 14px;
            padding: 10px 20px;
        }

        .answer-container {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mb-4 text-center">Submitted Answers for Form: {{ $form->label }}</h1>

        <!-- Table for displaying answers -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Answers</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($answers as $answer)
                <tr>
                    <!-- Display User's Name using the User model -->
                    <td>{{ $answer->user->name }}</td>

                    <td>
                        @php

                        $formData = json_decode($form->form_data, true);

                        // Prepare an associative array to map field ID to its label
                        $labels = [];
                        $types =[];
                        foreach ($formData as $index => $field) {
                        $labels[$index] = $field['label']; // Map field ID (index) to label
                        $types[$index] = $field['field_type'];
                        }
                         

                        // Decode the answers stored in JSON format
                        $decodedAnswers = json_decode($answer->answers, true);
                        
                        @endphp
                        
        
                        <!-- Loop through the decoded answers and display them -->
                        @foreach($decodedAnswers as $fieldId => $values)

                        <div class="answer-container">
                            <strong>Field Label:</strong>
                            @if(isset($labels[$fieldId]))
                            {{ $labels[$fieldId] }} <!-- Display label based on field ID -->
                            @else
                            Field label not found
                            @endif

                            <br>


                            @if (is_array($values) && count($values) > 1)
                            @foreach($values as $value)
                          
                            <strong>Value:</strong> {{ $value }}<br>
                            @if($field['field_type'] =='image')
                            <img src="{{ asset('images/' . $value) }}" alt="Uploaded Image" style="max-width: 100px; max-height: 100px;">
                            @endif
                            @endforeach
                            @else
                            <strong>Value:</strong> {{ $values }}<br>
                            @if($field['field_type'] == 'image')
                            <img src="{{ asset('images/' . $value) }}" alt="Uploaded Image" style="max-width: 100px; max-height: 100px;">
                            @endif
                            @endif
                        </div>
                        <hr>

                        @endforeach

                    </td>

                    <!-- Display submission date -->
                    <td>{{ $answer->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Back to forms list button -->
        <a href="{{ route('forms.index') }}" class="btn btn-primary mt-3">Back to Forms List</a>
    </div>

    <!-- Bootstrap JS and Popper (for any Bootstrap features) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>