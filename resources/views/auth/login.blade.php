<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - Argon Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="{{ asset('adminlte/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('adminlte/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link id="pagestyle" href="{{ asset('adminlte/assets/css/argon-dashboard.min.css?v=2.1.0') }}" rel="stylesheet" />
</head>

<body class="">

  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your username and password to sign in</p>
                </div>
                <div class="card-body">
                  @if ($errors->any())
                    <div class="alert alert-danger">
                      {{ $errors->first() }}
                    </div>
                  @endif
                  <form action="{{ url('login') }}" method="POST" id="form-login">
                    @csrf
                    <div class="mb-3">
                      <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required>
                      <span class="text-danger error-text" id="error-username"></span>
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                      <span class="text-danger error-text" id="error-password"></span>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new currency"</h4>
                <p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('adminlte/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('adminlte/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('adminlte/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('adminlte/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('adminlte/assets/js/argon-dashboard.min.js?v=2.1.0') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).ready(function() {
      $("#form-login").validate({
        rules: {
          username: {
            required: true,
            minlength: 4,
            maxlength: 20
          },
          password: {
            required: true,
            minlength: 5,
            maxlength: 20
          }
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
                }).then(() => {
                  window.location = response.redirect;
                });
              } else {
                $('.error-text').text('');
                if (response.msgField) {
                  $.each(response.msgField, function(prefix, val) {
                    $('#error-' + prefix).text(val[0]);
                  });
                }
                Swal.fire({
                  icon: 'error',
                  title: 'Terjadi Kesalahan',
                  text: response.message
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Terjadi kesalahan saat menghubungi server.'
              });
            }
          });
          return false;
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          if (element.closest('.input-group').length) {
            element.closest('.input-group').append(error);
          } else {
            element.parent().append(error);
          }
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
