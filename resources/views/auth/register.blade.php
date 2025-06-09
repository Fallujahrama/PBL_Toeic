<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Daftar - Sistem Pendaftaran TOEIC</title>
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
                  <h4 class="font-weight-bolder">Pendaftaran</h4>
                  <p class="mb-0">Masukkan detail Anda untuk membuat akun</p>
                </div>
                <div class="card-body">
                  <form id="form-register" action="{{ url('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <input type="text" name="username" class="form-control form-control-lg" placeholder="Nama Pengguna" aria-label="Nama Pengguna">
                      <span class="text-danger error-text" id="error-username"></span>
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control form-control-lg" placeholder="Kata Sandi" aria-label="Kata Sandi">
                      <span class="text-danger error-text" id="error-password"></span>
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Konfirmasi Kata Sandi" aria-label="Konfirmasi Kata Sandi">
                      <span class="text-danger error-text" id="error-password_confirmation"></span>
                    </div>
                    <div class="mb-3">
                      <input type="text" name="nama" class="form-control form-control-lg" placeholder="Nama Lengkap" aria-label="Nama Lengkap">
                      <span class="text-danger error-text" id="error-nama"></span>
                    </div>
                    <div class="mb-3">
                      <select name="level_id" class="form-control form-control-lg">
                        <option value="">Pilih Tipe Pengguna</option>
                        @foreach($userTypes as $type)
                          <option value="{{ $type->level_id }}">{{ $type->level_nama }}</option>
                        @endforeach
                      </select>
                      <span class="text-danger error-text" id="error-level_id"></span>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Daftar</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Sudah memiliki akun?
                    <a href="{{ url('login') }}" class="text-primary text-gradient font-weight-bold">Masuk</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">Pendaftaran TOEIC</h4>
                <p class="text-white position-relative">Bergabunglah dengan komunitas TOEIC kami dan daftar untuk ujian yang akan datang.</p>
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
            required: "Harap masukkan nama pengguna",
            minlength: "Nama pengguna minimal 4 karakter",
            maxlength: "Nama pengguna maksimal 20 karakter"
          },
          password: {
            required: "Harap masukkan kata sandi",
            minlength: "Kata sandi minimal 5 karakter",
            maxlength: "Kata sandi maksimal 20 karakter"
          },
          password_confirmation: {
            required: "Harap konfirmasi kata sandi Anda",
            equalTo: "Kata sandi tidak cocok"
          },
          nama: {
            required: "Harap masukkan nama lengkap Anda",
            maxlength: "Nama tidak boleh lebih dari 255 karakter"
          },
          level_id: {
            required: "Harap pilih tipe pengguna"
          }
        },
        submitHandler: function(form) {
          $.ajax({
            url: form.action,
            type: 'POST',
            data: $(form).serialize(),
            beforeSend: function() {
              $('button[type="submit"]').prop('disabled', true);
              $('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i> Memproses...');
            },
            success: function(response) {
              if (response.status) {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: response.message
                }).then(function() {
                  window.location.href = response.redirect;
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: response.message
                });

                // Tampilkan error validasi
                if (response.msgField) {
                  $.each(response.msgField, function(key, value) {
                    $('#error-' + key).text(value);
                  });
                }

                $('button[type="submit"]').prop('disabled', false);
                $('button[type="submit"]').html('Daftar');
              }
            },
            error: function(xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan. Silakan coba lagi nanti.'
              });
              $('button[type="submit"]').prop('disabled', false);
              $('button[type="submit"]').html('Daftar');
            }
          });
          return false;
        }
      });
    });
  </script>
</body>

</html>
