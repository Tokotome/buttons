<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Button</title>

    <link rel="stylesheet" href="/css/app.css/">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .color-picker-square {
            width: 15em;
            height: 15em;
            border: 1px solid #ccc;
            border-radius: 0;
            position: relative;
            overflow: hidden;
            background-color: #ffffff; /* Default color */
        }

        .color-picker-square input[type="color"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .color-picker-square .color-display {
            width: 100%;
            height: 100%;
            border: 1px solid #ccc;
            background-color: #ffffff;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .spinner-border {
            display: none;
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        .btn-primary.loading .spinner-border {
            display: inline-block;
        }

        .btn-primary.loading .button-text {
            display: none;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="container mx-auto p-4">
        <h1>Edit Button</h1>

        <form id="editButtonForm" action="{{ route('buttons.update', $button->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hidden Position Field -->
            <input type="hidden" id="position" name="position" value="{{ old('position', $button->position) }}">

            <div class="form-group">
                <label for="color">Pick button color from the square</label>
                <div class="color-picker-square" id="color-picker">
                    <input type="color" id="color" name="color" value="{{ old('color', $button->color) }}" onchange="updateColorDisplay(this)">
                    <div class="color-display" id="color-display"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="hyperlink">Hyperlink</label>
                <input type="url" class="form-control" id="hyperlink" name="hyperlink" value="{{ old('hyperlink', $button->hyperlink) }}">
            </div>

            <button type="submit" class="btn btn-primary">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="button-text">Update Button</span>
            </button>
            <a href="{{ route('buttons.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        // Function to update the color display based on the color input
        function updateColorDisplay(colorInput) {
            const colorDisplay = document.getElementById('color-display');
            colorDisplay.style.backgroundColor = colorInput.value;
        }

        // Initialize color display with current color value
        document.addEventListener('DOMContentLoaded', function() {
            const colorInput = document.getElementById('color');
            updateColorDisplay(colorInput);
        });

        // Show spinner and disable button on form submission
        document.getElementById('editButtonForm').addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.classList.add('loading');
            submitButton.disabled = true;
        });
    </script>
</body>
</html>
