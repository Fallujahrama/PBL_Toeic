<!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Login Sistem PBL</title>

     <!-- Google Font: Source Sans Pro -->
     <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
     <!-- Font Awesome -->
     <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
     <!-- icheck bootstrap -->
     <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
     <!-- SweetAlert2 -->
     <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
     <!-- Theme style -->
     <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
 </head>
<div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f0f3f6;">
  <div class="row w-100" style="max-width: 1000px; height: 90vh; box-shadow: 0 0 15px rgba(0,0,0,0.1); overflow: hidden;">

    <!-- Kolom kiri: Gambar -->
    <div class="col-md-6 p-0">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-100 h-100" style="object-fit: cover;">
    </div>

    <!-- Kolom kanan: Form login -->
    <div class="col-md-6 d-flex align-items-center justify-content-center bg-white">
      <div class="w-75">
        <p class="text-center mb-4">Selamat datang di TOEIC Registration Online !</p>

        <form action="{{ url('login') }}" method="POST" id="form-login">
          @csrf

          <div class="input-group mb-3">
            <input type="text" id="username" name="username" class="form-control" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>
      </div>
    </div>

  </div>
</div>
     <!-- jQuery -->
     <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
     <!-- Bootstrap 4 -->
     <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
     <!-- jquery-validation -->
     <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
     <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
     <!-- SweetAlert2 -->
     <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
     <!-- AdminLTE App -->
     <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

     <script>
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });

         $(document).ready(function() {
             $("#form-login").validate({
                 rules: {
                     username: { required: true, minlength: 4, maxlength: 20 },
                     password: { required: true, minlength: 5, maxlength: 20 }
                 },
                 submitHandler: function(form) {
                     $.ajax({
                         url: form.action,
                         type: form.method,
                         data: $(form).serialize(),
                         success: function(response) {
                             if (response.status) {
                                 Swal.fire({
                                     icon: 'success',
                                     title: 'Berhasil',
                                     text: response.message,
                                 }).then(function() {
                                     window.location = response.redirect;
                                 });
                             } else {
                                 $('.error-text').text('');
                                 $.each(response.msgField, function(prefix, val) {
                                     $('#error-' + prefix).text(val[0]);
                                 });
                                 Swal.fire({
                                     icon: 'error',
                                     title: 'Terjadi Kesalahan',
                                     text: response.message
                                 });
                             }
                         }
                     });
                     return false;
                 },
                 errorElement: 'span',
                 errorPlacement: function(error, element) {
                     error.addClass('invalid-feedback');
                     element.closest('.input-group').append(error);
                 },
                 highlight: function(element) {
                     $(element).addClass('is-invalid');
                 },
                 unhighlight: function(element) {
                     $(element).removeClass('is-invalid');
                 }
             });
         });
     </script>
 </body>
 </html>