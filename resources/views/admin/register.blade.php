<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>B-1 Test</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    /* body {
      background: url('public/uploads/bg-img-2.jpg') no-repeat center center fixed;
      background-size: cover;
  } */
  </style>

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-6 d-flex flex-column align-items-center justify-content-center">

              
              <div class="card mb-3">
                <div class="d-flex justify-content-center py-4">
                  <a href="javascript:void(0);" class="logo d-flex align-items-center w-auto">
                    <img src="{{asset('assets/img/logo.png')}}" alt="">
                    <span class="d-none d-lg-block">B-1 Test</span>
                  </a>
                </div>

                <div class="card-body">

                  <div class=" pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">User Registration Form</h5>
                    <p class="text-center small">Online Application Form For The Promotional Test Of HP Police Constables</p>
                  </div>

                  <form class="row g-3 " method="POST" action="{{route('admin.user-register')}}" enctype="multipart/form-data">
                  @csrf()
                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Full Name (As per official record)</label>
                      <div class="input-group has-validation">
                        <input type="text" name="name" class="form-control"  required>
                      </div>
                    </div>

                    
                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Father’s Name (As per official record)</label>
                      <div class="input-group has-validation">
                        <input type="text" name="father_name" class="form-control"  required>
                      </div>
                    </div>

                    
                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Date of Birth (As per official record)</label>
                      <div class="input-group has-validation">
                        <input type="date" name="dob" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Gender (Male, Female, Other)</label>
                      <div class="input-group has-validation">
                        <input type="text" name="gender" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Mobile Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="phone" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">E-mail address</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Permanent Address</label>
                      <div class="input-group has-validation">
                        <textarea class="form-control" rows="5" cols="5" name="permanent_address"  required></textarea>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Present Address</label>
                      <div class="input-group has-validation">
                        <textarea class="form-control" rows="5" cols="5" name="present_address"  required></textarea>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Aadhaar Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="aadhar_card" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">ID Card Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="id_card_no" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">PMIS Code</label>
                      <div class="input-group has-validation">
                        <input type="text" name="pmis_no" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">District/Unit</label>
                      <div class="input-group has-validation">
                        <input type="text" name="district" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Unique Constable Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="uni_constable_no" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Date of appointment/joining</label>
                      <div class="input-group has-validation">
                        <input type="date" name="date_of_join" class="form-control"  required>
                      </div>
                    </div>

                    

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Upload recent passport size photograph <span>(50 kb to 200 kb)</span></label>
                      <div class="input-group has-validation">
                        <input type="file" name="profile_image" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Signature of the candidate (option to upload signature in size between 20 kb to 50 kb)</label>
                      <div class="input-group has-validation">
                        <input type="file" name="user_sign" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-12">

                      <div class="form-check">
                        <input class="form-check-input" name="is_self_undertaking" type="checkbox" id="gridCheck2" checked>
                        <label class="form-check-label" for="gridCheck2">
                        Self-undertaking
                        </label>
                      </div>
                      <p>
                        "It is hereby declared that the information furnished above has been entered based on the official records of the concerned personnel and is true and correct to the best of my knowledge and belief."
                      </p>

                    </div>
                    
                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Date</label>
                      <div class="input-group has-validation">
                        <input type="date" name="form_fill_date" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Place</label>
                      <div class="input-group has-validation">
                        <input type="text" name="form_fill_place" class="form-control"  required>
                      </div>
                    </div>


                    

                    





                    <div class="col-3 ">
                      <button class="btn btn-primary w-100" type="submit">Register</button>
                    </div>
                    <!-- <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="{{route('admin.login')}}">Login</a></p>
                    </div> -->
                  
                  </form>

                </div>
              </div>

             

            </div>
          </div>
        </div>

      </section>
    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js')}}/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
  
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @elseif(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @elseif(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @elseif(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif
</script>


</body>

</html>