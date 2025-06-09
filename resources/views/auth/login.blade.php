<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - TOEIC Registration System</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link href="{{ asset('adminlte/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('adminlte/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- CSS -->
  <link id="pagestyle" href="{{ asset('adminlte/assets/css/argon-dashboard.min.css?v=2.1.0') }}" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain" data-aos="fade-right">
                <div class="card-header pb-0 text-start">
                  <div class="login-logo text-center mb-3">
                    <a href="{{ route('landing') }}">
                        <img src="{{ asset('img/Tregon.png') }}" alt="Tregon Logo" class="img-fluid" style="max-height: 100px;">
                    </a>
                  </div>
                  <h4 class="font-weight-bolder text-center">TOEIC Registration</h4>
                  <p class="mb-0 text-center">Enter your credentials to access your account</p>
                </div>
                <div class="card-body">
                  @if ($errors->any())
                  <div class="alert alert-danger">
                    {{ $errors->first() }}
                  </div>
                  @endif
                  <form action="{{ url('login') }}" method="POST" id="form-login">
                    @csrf
                    <div class="form-floating mb-3">
                      <input type="text" name="username" class="form-control" id="username" placeholder=" " required>
                      <label for="username">Username</label>
                      <span class="text-danger error-text" id="error-username"></span>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="password" name="password" class="form-control" id="password" placeholder=" " required>
                      <label for="password">Password</label>
                      <span class="text-danger error-text" id="error-password"></span>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0 pulse">Sign in</button>
                      <div class="mt-3">
                        <a href="{{ route('register') }}" class="btn btn-lg btn-outline-secondary btn-lg w-100 pulse">
                          <i class="fas fa-user-plus me-2"></i>Create New Account
                        </a>
                      </div>
                        <a href="{{ route('landing') }}" class="btn btn-link text-secondary mt-2 slide-up">
                            <i class="fas fa-arrow-left me-2"></i>Back to Landing Page
                        </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="login-side-image h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" data-aos="fade-left">
                <div class="login-side-content">
                  <h2 class="mt-5 text-white font-weight-bolder position-relative">Test of English for International Communication</h2>
                  <p class="text-white position-relative">Enhance your career prospects with internationally recognized English language certification. Register for your TOEIC exam today.</p>
                  <div class="mt-4">
                    <div class="d-flex justify-content-center mb-4">
                      <div class="px-3 py-2 bg-white bg-opacity-10 rounded-pill me-2">
                        <i class="fas fa-headphones me-1 "></i> Listening
                      </div>
                      <div class="px-3 py-2 bg-white bg-opacity-10 rounded-pill me-2">
                        <i class="fas fa-book-open me-1"></i> Reading
                      </div>
                      <div class="px-3 py-2 bg-white bg-opacity-10 rounded-pill">
                        <i class="fas fa-comments me-1"></i> Speaking
                      </div>
                    </div>
                    <div class="d-flex justify-content-center">
                      <div class="px-3 py-2 bg-white bg-opacity-10 rounded-pill me-2">
                        <i class="fas fa-pen me-1"></i> Writing
                      </div>
                      <div class="px-3 py-2 bg-white bg-opacity-10 rounded-pill">
                        <i class="fas fa-certificate me-1"></i> Certification
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('adminlte/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('adminlte/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('adminlte/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('adminlte/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('adminlte/assets/js/argon-dashboard.min.js?v=2.1.0') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <script>
    // Initialize AOS animations
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).ready(function() {
      // Focus animation for form fields
      $('.form-control').on('focus', function() {
        $(this).parent().addClass('focused');
      }).on('blur', function() {
        $(this).parent().removeClass('focused');
      });

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
        messages: {
          username: {
            required: "Please enter your username",
            minlength: "Username must be at least 4 characters",
            maxlength: "Username cannot exceed 20 characters"
          },
          password: {
            required: "Please enter your password",
            minlength: "Password must be at least 5 characters",
            maxlength: "Password cannot exceed 20 characters"
          }
        },
        submitHandler: function(form) {
          $.ajax({
            url: form.action,
            type: form.method,
            data: $(form).serialize(),
            beforeSend: function() {
              $('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Signing in...');
              $('button[type="submit"]').prop('disabled', true);
            },
            success: function(response) {
              if (response.status) {
                Swal.fire({
                  icon: 'success',
                  title: 'Login Successful',
                  text: response.message,
                  background: '#ffffff',
                  color: '#1f2937',
                  confirmButtonColor: '#3b82f6'
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
                  title: 'Login Failed',
                  text: response.message,
                  background: '#ffffff',
                  color: '#1f2937',
                  confirmButtonColor: '#3b82f6'
                });
                $('button[type="submit"]').html('Sign in');
                $('button[type="submit"]').prop('disabled', false);
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'There was an error connecting to the server.',
                background: '#1f2937',
                color: '#e2e8f0',
                confirmButtonColor: '#3b82f6'
              });
              $('button[type="submit"]').html('Sign in');
              $('button[type="submit"]').prop('disabled', false);
            }
          });
          return false;
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-floating').append(error);
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
