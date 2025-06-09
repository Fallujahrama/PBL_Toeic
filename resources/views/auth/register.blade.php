<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register - TOEIC Registration System</title>
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
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Register</h4>
                  <p class="mb-0">Enter your details to create an account</p>
                </div>
                <div class="card-body">
                  <form id="form-register" action="{{ url('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" aria-label="Username">
                      <span class="text-danger error-text" id="error-username"></span>
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password">
                      <span class="text-danger error-text" id="error-password"></span>
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Confirm Password">
                      <span class="text-danger error-text" id="error-password_confirmation"></span>
                    </div>
                    <div class="mb-3">
                      <input type="text" name="nama" class="form-control form-control-lg" placeholder="Full Name" aria-label="Full Name">
                      <span class="text-danger error-text" id="error-nama"></span>
                    </div>
                    <div class="mb-3">
                      <select name="level_id" class="form-control form-control-lg">
                        <option value="">Select User Type</option>
                        @foreach($userTypes as $type)
                          <option value="{{ $type->level_id }}">{{ $type->level_nama }}</option>
                        @endforeach
                      </select>
                      <span class="text-danger error-text" id="error-level_id"></span>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Register</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Already have an account?
                    <a href="{{ url('login') }}" class="text-primary text-gradient font-weight-bold">Sign in</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">TOEIC Registration</h4>
                <p class="text-white position-relative">Join our TOEIC community and register for upcoming exams.</p>
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

  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).ready(function() {
      $("#form-register").validate({
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
          },
          password_confirmation: {
            required: true,
            equalTo: "[name='password']"
          },
          nama: {
            required: true,
            maxlength: 255
          },
          level_id: {
            required: true
          }
        },
        messages: {
          username: {
            required: "Please enter a username",
            minlength: "Username must be at least 4 characters",
            maxlength: "Username cannot exceed 20 characters"
          },
          password: {
            required: "Please enter a password",
            minlength: "Password must be at least 5 characters",
            maxlength: "Password cannot exceed 20 characters"
          },
          password_confirmation: {
            required: "Please confirm your password",
            equalTo: "Passwords do not match"
          },
          nama: {
            required: "Please enter your full name",
            maxlength: "Name cannot exceed 255 characters"
          },
          level_id: {
            required: "Please select user type"
          }
        },
        submitHandler: function(form) {
          $.ajax({
            url: form.action,
            type: 'POST',
            data: $(form).serialize(),
            beforeSend: function() {
              $('button[type="submit"]').prop('disabled', true);
              $('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            },
            success: function(response) {
              if (response.status) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: response.message
                }).then(function() {
                  window.location.href = response.redirect;
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: response.message
                });

                // Show validation errors
                if (response.msgField) {
                  $.each(response.msgField, function(key, value) {
                    $('#error-' + key).text(value);
                  });
                }

                $('button[type="submit"]').prop('disabled', false);
                $('button[type="submit"]').html('Register');
              }
            },
            error: function(xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred. Please try again later.'
              });
              $('button[type="submit"]').prop('disabled', false);
              $('button[type="submit"]').html('Register');
            }
          });
          return false;
        }
      });
    });
  </script>
</body>

</html>
