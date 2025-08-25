@extends('admin.layouts.main')
@section('style')
@endsection
@section('content')
<div class="pagetitle">
      <!-- <h1>My Profile</h1> -->
    </div>
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">New User Register</h5>
              <!-- General Form Elements -->
              <form id="userForm" class="row g-3 " method="POST" action="{{route('registered-user-create')}}" enctype="multipart/form-data">
                  @csrf()
                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Full Name (As per official record)</label>
                      <div class="input-group has-validation">
                        <input type="text" name="name" class="form-control" pattern="^[A-Za-z ]+$" title="Only letters are allowed (A–Z or a–z)" required>
                      </div>
                    </div>

                    
                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Father’s Name (As per official record)</label>
                      <div class="input-group has-validation">
                        <input type="text" name="father_name" class="form-control" pattern="^[A-Za-z ]+$" title="Only letters are allowed (A–Z or a–z)" required>
                      </div>
                    </div>

                    
                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Date of Birth (As per official record)</label>
                      <div class="input-group has-validation">
                        <input type="date" name="dob" id="dob" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Gender (Male, Female, Other)</label>
                      <div class="input-group has-validation">
                        <select name="gender" class="form-control" id="">
                          <option value="">Select Option</option>
                          <option value="Male" >Male</option>
                          <option value="Female" >Female</option>
                          <option value="Other" >Other</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Mobile Number</label>
                      <div class="input-group has-validation">
                        <input type="text"  pattern="^\d{10}$"  title="Enter a valid 10-digit mobile number" minlength="10" maxlength="10" name="phone" class="form-control"  required>
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
                        <input type="text" pattern="^\d{12}$" minlength="12" maxlength="12"  title="Enter a valid 12-digit aadhaar number" name="aadhar_card" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">ID Card Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="id_card_no" pattern="^\d{5}$" minlength="5" maxlength="5" title="Enter a valid 5-digit number" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">PMIS Code</label>
                      <div class="input-group has-validation">
                        <input type="text" name="pmis_no" pattern="^\d{5}$" minlength="5" maxlength="5" title="Enter a valid 5-digit number" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">District/Unit</label>
                      <div class="input-group has-validation">
                        <select id="" class="form-control" disabled>
                            <option value="">Select Option</option>
                            @foreach($districts as $item)
                            <option value="{{$item->id}}" @if(auth()->user()->district_id == $item->id) selected @endif>{{$item->title}}</option>
                            @endforeach
                          </select>
                      </div>

                      <input type="hidden" name="district_id" value="{{auth()->user()->district_id}}">
                    </div>

                   
                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Unique Constable Number</label>
                      <div class="input-group has-validation">
                        <input type="text" name="uni_constable_no" pattern="\d*" title="Only numbers allowed" class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Date of appointment/joining</label>
                      <div class="input-group has-validation">
                        <input type="date" name="date_of_join" id="date_of_join" class="form-control"  required>
                      </div>
                    </div>

  

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Upload recent passport size photograph <span>(50 kb to 200 kb)</span></label>
                      <div class="input-group has-validation">
                        <input type="file" name="profile_image" id="profile_image"  class="form-control"  required>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Signature of the candidate (option to upload signature in size between 20 kb to 50 kb)</label>
                      <div class="input-group has-validation">
                        <input type="file" name="user_sign" id="user_sign"  class="form-control"  required>
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
                    
                    <!-- <div class="col-6">
                      <label for="yourUsername" class="form-label">Date</label>
                      <div class="input-group has-validation">
                        <input type="date" name="form_fill_date" class="form-control"  required>
                      </div>
                    </div> -->

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Place</label>
                      <div class="input-group has-validation">
                        <input type="text" name="form_fill_place" class="form-control"  required>
                      </div>
                    </div>
                    <div class="col-6">
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
    </section>
@endsection
@section('script')
<script>
document.getElementById('date_of_join').addEventListener('change', function () {
    const dojInput = this;
    const date_of_join = new Date(this.value);
    const today = new Date();
    const exp = today.getFullYear() - date_of_join.getFullYear();   
    const mon = today.getMonth() - date_of_join.getMonth();

    const isOldEnough = exp > 5 || (exp === 5 && mon >= 0 && today.getDate() >= date_of_join.getDate());

    const errorEl = document.getElementById('dob-error');

    if (!isOldEnough) {
        // errorEl.textContent = "You must be at least 18 years old.";
        alert("User must have minimum 5 years of experience");
        dojInput.value = ''; // Clear the input
        this.setCustomValidity("Invalid");
    } else {
        // errorEl.textContent = "";
        this.setCustomValidity("");    
    }   
});   
</script>
<script>
document.getElementById('dob').addEventListener('change', function () {
    const dobInput = this;
    const dob = new Date(this.value);
    const today = new Date();
    const age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();

    const isOldEnough = age > 18 || (age === 18 && m >= 0 && today.getDate() >= dob.getDate());

    const errorEl = document.getElementById('dob-error');

    if (!isOldEnough) {
        // errorEl.textContent = "You must be at least 18 years old.";
        alert("User must be at least 188 years old.");
        dobInput.value = ''; // Clear the input
        this.setCustomValidity("Invalid");
    } else {
        // errorEl.textContent = "";
        this.setCustomValidity("");   
    }
});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("userForm").addEventListener("submit", function (e) {
            let profileImage = document.getElementById("profile_image");
            let userSign = document.getElementById("user_sign");

            // Allowed file types
            let allowedTypes = ["image/jpeg", "image/png", "image/jpg"];

            // Profile Image Validation (50 KB - 200 KB)
            if (profileImage.files.length > 0) {
                let fileSize = profileImage.files[0].size / 1024; // Convert bytes to KB
                let fileType = profileImage.files[0].type;

                if (!allowedTypes.includes(fileType)) {
                    alert("Profile image must be a JPEG, PNG, or JPG file.");
                    e.preventDefault();
                    return;
                }
                if (fileSize < 50 || fileSize > 200) {
                    alert("Profile image must be between 50 KB and 200 KB.");
                    e.preventDefault();
                    return;
                }
            }

            // Signature Validation (20 KB - 50 KB)
            if (userSign.files.length > 0) {
                let fileSize = userSign.files[0].size / 1024; // Convert bytes to KB
                let fileType = userSign.files[0].type;

                if (!allowedTypes.includes(fileType)) {
                    alert("Signature must be a JPEG, PNG, or JPG file.");
                    e.preventDefault();
                    return;
                }
                if (fileSize < 20 || fileSize > 50) {
                    alert("Signature must be between 20 KB and 50 KB.");
                    e.preventDefault();
                    return;
                }
            }

            const confirmSubmit = confirm("Please ensure that all the information entered is correct and verified. No further changes will be allowed after submission.");
            if (!confirmSubmit) {
                e.preventDefault(); // Cancel submission
            }
        });
    });
</script>
@endsection
