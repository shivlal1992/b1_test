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
              <h5 class="card-title">Edit User 
              <button onclick="history.back()" class="btn btn-sm btn-secondary" style="float:right;" >Go Back</button>
              </h5>
              <!-- General Form Elements -->
              <form  id="userForm" class="row g-3 " method="POST" action="{{route('registered-user-update')}}" enctype="multipart/form-data">
                @csrf()
               <input type="hidden" name="id" value="{{$user->id}}">


                <div class="col-6">
                  <label for="yourUsername" class="form-label">Full Name (As per official record)</label>
                  <div class="input-group has-validation">
                    <input type="text" name="name" class="form-control" value="{{$user->name}}" pattern="^[A-Za-z ]+$" title="Only letters are allowed (A–Z or a–z)" required>
                  </div>
                </div>

                
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Father’s Name (As per official record)</label>
                  <div class="input-group has-validation">
                    <input type="text" name="father_name" class="form-control" value="{{$user->father_name}}"  pattern="^[A-Za-z ]+$" title="Only letters are allowed (A–Z or a–z)" required>
                  </div>
                </div>

                
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Date of Birth (As per official record)</label>
                  <div class="input-group has-validation">
                    <input type="date" name="dob" id="dob" class="form-control" value="{{$user->dob}}"  required>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Gender (Male, Female, Other)</label>
                  <div class="input-group has-validation">
                    <select name="gender" class="form-control" id="">
                      <option value="">Select Option</option>
                      <option value="Male" @if($user->gender == "Male") selected @endif>Male</option>
                      <option value="Female" @if($user->gender == "Female") selected @endif>Female</option>
                      <option value="Other" @if($user->gender == "Other") selected @endif>Other</option>
                    </select>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Mobile Number</label>
                  <div class="input-group has-validation">
                    <input type="text"  pattern="^\d{10}$"  title="Enter a valid 10-digit mobile number" minlength="10" maxlength="10" name="phone" class="form-control" value="{{$user->phone}}"  required>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">E-mail address</label>
                  <div class="input-group has-validation">
                    <input type="email" name="email" class="form-control" value="{{$user->email}}"  required>
                  </div>
                </div>

                <div class="col-12">
                  <label for="yourUsername" class="form-label">Permanent Address</label>
                  <div class="input-group has-validation">
                    <textarea class="form-control" value="{{$user->permanent_address}}" rows="5" cols="5" name="permanent_address"  required>{{$user->permanent_address}}</textarea>
                  </div>
                </div>

                <div class="col-12">
                  <label for="yourUsername" class="form-label">Present Address</label>
                  <div class="input-group has-validation">
                    <textarea class="form-control" value="{{$user->present_address}}" rows="5" cols="5" name="present_address"  required>{{$user->present_address}}</textarea>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Aadhaar Number</label>
                  <div class="input-group has-validation">
                    <input type="text" pattern="^\d{12}$" minlength="12" maxlength="12" title="Enter a valid 12-digit aadhaar number" name="aadhar_card" class="form-control" value="{{$user->aadhar_card}}"  required>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">ID Card Number</label>
                  <div class="input-group has-validation">
                    <input type="text" name="id_card_no" class="form-control" pattern="^\d{5}$" minlength="5" maxlength="5" title="Enter a valid 5-digit number" value="{{$user->id_card_no}}"  required>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">PMIS Code</label>
                  <div class="input-group has-validation">
                    <input type="text" name="pmis_no" class="form-control" pattern="^\d{5}$" minlength="5" maxlength="5" title="Enter a valid 5-digit number" value="{{$user->pmis_no}}"  required>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">District/Unit</label>
                  <div class="input-group has-validation">
                    <select  id="" class="form-control" disabled>
                        @foreach($districts as $item)
                        <option value="{{$item->id}}" @if($user->district_id == $item->id) selected @endif>{{$item->title}}</option>
                        @endforeach
                      </select>
                  </div>

                </div>

                
                <div class="col-6">
                  <label for="yourUsername" class="form-label">Unique Constable Number</label>
                  <div class="input-group has-validation">
                    <input type="text" name="uni_constable_no" pattern="\d*" title="Only numbers allowed" class="form-control" value="{{$user->uni_constable_no}}"  required>
                  </div>
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Date of appointment/joining</label>
                  <div class="input-group has-validation">
                    <input type="date" name="date_of_join" class="form-control" value="{{$user->date_of_join}}"  required>
                  </div>
                </div>

                

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Upload recent passport size photograph <span>(50 kb to 200 kb)</span></label>
                  <div class="input-group has-validation">
                    <input type="file" name="profile_image" id="profile_image" class="form-control" >
                  </div>
                  <br>
                  @if($user->profile_image)
                      <img src="{{ asset($user->profile_image) }}" width="100" alt="Profile Image">
                  @else
                      No Image Uploaded
                  @endif
                </div>

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Signature of the candidate (option to upload signature in size between 20 kb to 50 kb)</label>
                  <div class="input-group has-validation">
                    <input type="file" name="user_sign" id="user_sign" class="form-control" >
                  </div>
                  <br>
                  @if($user->user_sign)
                      <img src="{{ asset($user->user_sign) }}" width="100" alt="Signature">
                  @else
                      No Signature Uploaded
                  @endif
                </div>

                <div class="col-12">

                  <div class="form-check">
                    <input class="form-check-input" name="is_self_undertaking"  type="checkbox" id="gridCheck2" {{ $user->is_self_undertaking ? 'checked' : '' }} >
                    <label class="form-check-label" for="gridCheck2">
                    Self-undertaking
                    </label>
                  </div>
                  <p>
                    "I hereby declare that all the information provided in this application is true and accurate to the best of my knowledge, and I understand that any false information may lead to the rejection of my application or other appropriate actions."
                  </p>

                </div>
                
                <!-- <div class="col-6">
                  <label for="yourUsername" class="form-label">Date</label>
                  <div class="input-group has-validation">
                    <input type="date" name="form_fill_date" class="form-control" value="{{$user->form_fill_date}}"  required>
                  </div>
                </div> -->

                <div class="col-6">
                  <label for="yourUsername" class="form-label">Place</label>
                  <div class="input-group has-validation">
                    <input type="text" name="form_fill_place" class="form-control" value="{{$user->form_fill_place}}"  required>
                  </div>
                </div>
                <div class="col-6">
                  </div>

                <div class="col-3 ">
                  <button class="btn btn-primary w-100" type="submit">Submit</button>
                </div>
                
              </form><!-- End General Form Elements -->
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@section('script')
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
        alert("User must be at least 18 years old.");
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

            const confirmSubmit = confirm("Are you sure all the details are correct?");
            if (!confirmSubmit) {
                e.preventDefault(); // Cancel submission
            }
        });
    });
</script>
@endsection
