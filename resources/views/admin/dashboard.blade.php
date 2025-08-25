@extends('admin.layouts.main')
@section('style')
<style>
   .upgrade-plan-img {
   position: absolute;
   top: 10px;
   right: 10px;
   width: 49px;
   height: auto;
   transition: transform 0.3s ease;
   }
   .upgrade-plan-img:hover {
   transform: scale(1.1);
   }
   .scroll-container {
   height: 250px; /* Adjust height */
   overflow: hidden;
   position: relative;
   border-radius: 10px;
   background: #f8f9fa;
   padding: 10px;
   }
   .scroll-content {
   display: flex;
   flex-direction: column;
   gap: 8px;
   /* position: absolute; */
   animation: scroll-up 60s linear infinite;
   }
   @keyframes scroll-up {
   0% { transform: translateY(0); }
   100% { transform: translateY(-50%); } /* Moves up slowly */
   }
   .crypto-card {
   background: white;
   padding: 15px;
   border-radius: 10px;
   box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
   display: flex;
   align-items: center;
   justify-content: space-between;
   transition: all 0.3s ease;
   }
   .crypto-card:hover {
   transform: scale(1.02);
   }
   .crypto-icon {
   width: 50px;
   height: 50px;
   }
   .price-up {
   color: green;
   }
   .price-down {
   color: red;
   }
   .success-card {
   background: white;
   padding: 20px;
   border-radius: 10px;
   box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
   transition: all 0.3s ease;
   max-width: 600px;
   margin: auto;
   }
   .success-card:hover {
   transform: scale(1.02);
   }




   
   .slider-container {
            /* max-width: 600px; */
            margin: auto;
            overflow: hidden;
            position: relative;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .review-slide {
            display: none;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .review-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        .review-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #ddd;
        }
        .review-name {
            font-size: 18px;
            font-weight: bold;
        }
        .review-stars {
            color: #FFD700;
        }
        .review-text {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 10px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.3s;
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.5);
        }
        .prev { left: 0; }
        .next { right: 0; }
        .prev:hover, .next:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        #main {
  margin-top: 80px;
}



</style>
@endsection
@section('content')
<div class="pagetitle">
   <h1 style="">Dashboard</h1>
</div>

<section class="section dashboard">

   
   <div class="row">
   <div class="col-lg-12">
   <div class="row">
      @if(auth()->user() && auth()->user()->hasAnyRole(['Super Admin']))
      <div class="col-xxl-3 col-md-3">
         <a href="javascript:void(0);">
            <div class="card info-card sales-card">
               <div class="card-body">
                  <h5 class="card-title">District Admin </h5>
                  <div class="d-flex align-items-center">
                     <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-arms-up"></i>
                     </div>
                     <div class="ps-3">
                        <h6>{{@$total_District_Admin ?? 0}}</h6>
                     </div>
                  </div>
               </div>
            </div>
         </a>
      </div>
      @endif

      @if(auth()->user() && auth()->user()->hasAnyRole(['Super Admin', 'District Admin']))
      <div class="col-xxl-3 col-md-3">
         <a href="javascript:void(0);">
            <div class="card info-card sales-card">
               <div class="card-body">
                  <h5 class="card-title">Registrar </h5>
                  <div class="d-flex align-items-center">
                     <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-check"></i>
                     </div>
                     <div class="ps-3">
                        <h6>{{@$total_Registrar ?? 0}}</h6>
                     </div>
                  </div>
               </div>
            </div>
         </a>
      </div>
      @endif

      @if(auth()->user() && auth()->user()->hasAnyRole(['Super Admin', 'Registrar']))

      <div class="col-xxl-3 col-md-3">
         <a href="javascript:void(0);">
            <div class="card info-card sales-card">
               <div class="card-body">
                  <h5 class="card-title">Candidates </h5>
                  <div class="d-flex align-items-center">
                     <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-video2"></i>
                     </div>
                     <div class="ps-3">
                        <h6>{{@$total_User ?? 0}}</h6>
                     </div>
                  </div>
               </div>
            </div>
         </a>
      </div>
      @endif

         </div>
      </div>
   </div>
</section>

@endsection
@section('script')

@endsection