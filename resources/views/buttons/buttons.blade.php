<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buttons Grid</title>

    <!-- Include your styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- jQuery (full version) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        /* Tooltip container */
        .tooltip-bubble {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        /* Tooltip text */
        .tooltip-bubble .tooltip-text {
            visibility: hidden;
            width: 80px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%; /* Position above the icon */
            left: 50%;
            margin-left: -40px; /* Center the tooltip */
            opacity: 0;
            transition: opacity 0.3s;
        }

        /* Tooltip arrow */
        .tooltip-bubble .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%; /* Bottom of the tooltip */
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }

        /* Show the tooltip text when hovering */
        .tooltip-bubble:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .button-container {
            position: relative;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            transition: transform 0.3s ease;
        }
        .button {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100px;
            border-radius: 10px;
            border: 2px solid #ccc;
            color: black;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            padding: 10px;
            cursor: pointer;
            position: relative;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .button.white-button {
            color: black;
            border-color: black;
        }
        .button:not(.white-button) {
            color: white;
        }
        .button:hover {
            transform: scale(1.05);
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .action-buttons .btn {
            font-size: 1.2rem;
            padding: 5px;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
            position: relative;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="container mx-auto p-4">
        <div class="grid-container">
            @foreach($buttons as $button)
                @php
                    $isWhite = $button->color === '#ffffff' || $button->color === 'white';
                @endphp
                <div class="button-container" id="button-container-{{ $button->id }}">
                    <!-- Main Button -->
                    <div 
                        class="button {{ $isWhite ? 'white-button' : '' }}" 
                        style="background-color: {{ $button->color }}"
                        onclick="handleButtonClick({{ $button->id }}, '{{ $button->hyperlink }}')"
                    >
                        {{ $button->name ?? 'Button' }}
                    </div>

                    <!-- Action Buttons (Edit and Delete) -->
                    <div class="action-buttons">
                        <!-- Edit Button with Tooltip -->
                        <span class="tooltip-bubble">
                            <a href="{{ route('buttons.edit', $button->id) }}" class="btn btn-warning">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <span class="tooltip-text">Edit</span>
                        </span>

                        <!-- Delete Button with Tooltip -->
                        <span class="tooltip-bubble">
                            <button class="btn btn-danger" onclick="confirmDelete({{ $button->id }})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <span class="tooltip-text">Delete</span>
                        </span>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal-{{ $button->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $button->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel-{{ $button->id }}">Confirm Update</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to update this button's color to white and clear its hyperlink?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" onclick="deleteButton('{{ $button->id }}')">Yes, Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function handleButtonClick(buttonId, hyperlink) {
            if (hyperlink) {
                window.location.href = hyperlink;
            } else {
                window.location.href = `/buttons/edit/${buttonId}`;
            }
        }

        function deleteButton(buttonId) {
            $.ajax({
                url: `/buttons/${buttonId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.success) {
                        let buttonElement = $(`#button-container-${buttonId} .button`);
                        buttonElement.css('background-color', '#ffffff');
                        buttonElement.attr('onclick', `handleButtonClick(${buttonId}, '')`);
                        buttonElement.addClass('white-button');
                        buttonElement.text("");
                        
                        $(`#deleteModal-${buttonId}`).modal('hide');
                    } else {
                        alert('Failed to update the button.');
                    }
                },
                error: function(xhr) {
                    alert('Error updating the button');
                }
            });
        }

        function confirmDelete(buttonId) {
            $(`#deleteModal-${buttonId}`).modal('show');
        }

        // Enable tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>
</html>
