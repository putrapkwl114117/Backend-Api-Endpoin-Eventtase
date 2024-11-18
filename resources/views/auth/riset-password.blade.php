<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }

        .card {
            border: none;
            box-shadow: 0px 6px 10px rgba(58, 55, 55, 0.1);
            border-radius: 14px;
            width: 90%; /* Memperkecil lebar form */
            max-width: 400px; /* Maksimal lebar untuk desktop */
            margin: auto;
        }
        .card-header {
            background-color: transparent;
            text-align: center;
            padding: 20px;
            border: none;
        }
        .btn-primary {
            background-color: #2f80ed;
            border: 2px solid #c5cdda; /* Border pada tombol */
            border-radius: 10px;
            color: #fff; /* Warna teks */
            transition: background-color 0.3s, border-color 0.3s; /* Transisi border */
        }
        .btn-primary:hover {
            background-color: #1c6ab9;
            border-color: #1c6ab9; /* Ubah warna border saat hover */
        }
        .btn-secondary {
            border: 2px solid #6c757d; /* Border pada tombol cancel */
            border-radius: 10px;
            transition: border-color 0.3s;
        }
        .btn-secondary:hover {
            border-color: #6e8292; /* Ubah warna border saat hover */
        }
        .alert {
            border-radius: 8px;
            margin-bottom: 10px; /* Tambahkan jarak antara alert dan field */
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            border: 1px solid #c5cdda; /* Tambahkan border pada input */
            border-radius: 8px; /* Membuat sudut border lebih melengkung */
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #1c6ab9; /* Warna border saat fokus */
            box-shadow: 0 0 5px rgba(46, 140, 237, 0.5); /* Efek bayangan saat fokus */
        }
        .loading-spinner {
            display: none;
            margin-left: 8px;
            width: 20px;
            height: 20px;
            border: 3px solid #fff;
            border-radius: 50%;
            border-top: 3px solid #2f80ed;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .fade-down {
            animation: fadeDown 0.5s ease-in-out;
        }
        @keyframes fadeDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card fade-down">
                    <div class="card-header">
                        <img src="path_to_logo.png" alt="Logo" class="mb-3" style="width: 50px;">
                        <h4>Reset Password</h4>
                        <p class="text-muted">Enter new password for login to Eventtase Aps</p>
                    </div>
                    
                    <div class="card-body">
                        <!-- Menampilkan pesan sukses atau error -->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="resetForm" method="POST" action="{{ route('password.reset') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                            </div>

                            <hr> <!-- Garis pemisah -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary flex-fill mr-1" id="submitButton">
                                    Confirm
                                    <div class="loading-spinner" id="loadingSpinner"></div>
                                </button>
                                <button type="button" class="btn btn-secondary flex-fill ml-1" onclick="window.history.back()">Cancel</button>
                            </div>
                            <br>
                            <p>
                              Halaman ini akan hilang dalam waktu 30 detik
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#resetForm').on('submit', function(event) {
                event.preventDefault();
                $('#submitButton').prop('disabled', true);
                $('#loadingSpinner').show();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#loadingSpinner').hide();
                        $('#submitButton').prop('disabled', false);
                        $('.alert').remove(); // Hapus alert sebelumnya
                        $('.card-body').prepend('<div class="alert alert-success" role="alert">Password has been updated successfully!</div>');
                    },
                    error: function(xhr) {
                        $('#loadingSpinner').hide();
                        $('#submitButton').prop('disabled', false);
                        $('.alert').remove(); // Hapus alert sebelumnya
                        $('.card-body').prepend('<div class="alert alert-danger" role="alert">Failed to update password. Please try again.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>
