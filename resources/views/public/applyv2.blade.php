<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8">
  <title>Entrego | Job Summary</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="Browse jobs, search jobs, career search, opportunity, job fair, job board, Jobs at Entrego, Jobs, Apply, Hirelogic, Apply Now, Entrego, Entrego Logistics, Entrego Incorporated," name="keywords">
  <meta content="Browse jobs at Entrego!" name="description">

  <!-- Favicons -->
  <link href="/img/favicon.png" rel="icon">
  <link href="/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Favicons -->
  <link href="/img/favicon.png" rel="icon">
  <link href="/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="{{asset('landing-page/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="{{asset('landing-page/lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('landing-page/lib/animate/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('landing-page/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('landing-page/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('landing-page/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="{{asset('landing-page/css/apply-style.css')}}" rel="stylesheet">

  
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container-fluid">

      <div id="logo" class="pull-left">
        <h1>
            <a href="#intro" class="scrollto">Entrego
            <span style="font-size:x-small">Powered by HIRELOGIC</span>
            </a>
        </h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#intro"><img src="img/logo.png" alt="" title="" /></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="/">Home</a></li>
          <li><a href="{{route('job.listing')}}">Browse Jobs</a></li>
          <li class="menu-has-children">
          <a href="#">Entrego</a>
            <ul>
              <li><a href="https://entrego.com.ph/about">About Entrego</a></li>
              <li><a href="https://entrego.com.ph/blog">Blog</a></li>
              <li><a href="https://entrego.com.ph/contact">Contact Us</a></li>
            </ul>
          </li>
          @if(auth()->check())
          <li class="menu-has-children">
          <a href="#">
                Hello, {{auth()->user()->fullname}}
          </a>
            <ul>
              <li><a href="{{route('profile.edit')}}">Profile</a></li>
              <li><a href="javascript:void(0)" onclick="logout()">Logout</a></li>
            </ul>
          </li>
          @else 
          <li class="menu-has-children">
            <a href="#">
                Login / Register
            </a>
              <ul>
                <li><a href="{{route('login')}}">Login</a></li>
                <li><a href="{{route('register')}}">Register</a></li>
              </ul>
            </li>
          @endif
          
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

    <!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_1">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text">
                        <h3>{{ $job->job_title}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ bradcam_area  -->

    <div class="job_details_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                <div class="thumb">
                                    <img src="{{asset('img/1.svg')}}" alt="">
                                </div>
                                <div class="jobs_conetent">
                                    <a href="#"><h4>{{$job->job_title}}</h4></a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i> {{$job->location}}, Philippines</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i> {{$job->job_nature}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Job description</h4>
                            <p>
                                {{$job->description}}
                            </p>
                        </div>
                        <div class="single_wrap">
                            <h4>Responsibility</h4>
                            <p>
                                {{$job->responsibilities}}
                            </p>

                        </div>
                        <div class="single_wrap">
                            <h4>Qualifications</h4>
                            <p>
                                {{$job->qualifications}}
                            </p>
                        </div>
                        <div class="single_wrap">
                            <h4>Benefits</h4>
                            <p>
                                {{$job->benefits}}
                            </p>
                        </div>
                        @if(auth()->check() && auth()->user()->isAppliedToJob($job->id))
                        <div class="text-center">
                          <h3 href="#" class="text-warning weight-bold"> You've already applied for this job</h3>
                        </div>
                        @else
                        <div class="text-center">
                          <form action="{{route('job.store',$job->id)}}" method="POST">
                              @csrf
                          <button class="btn btn-lg btn-success" type="submit">Apply Now!</button>
                          </form>
                        </div>
                        @endif
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="job_sumary">
                        <div class="summery_header">
                            <h3>Job Summary</h3>
                        </div>
                        <div class="job_content">
                            <ul>
                                <li>Published on: <span>{{ $job->created_at->format('F d, Y')}}</span></li>
                                <li>Vacancy: <span>{{ $job->vacancy }} Position</span></li>
                                <li>Required Experience: <span>{{ $job->required_experience_name }}</span></li>
                                <li>Location: <span> {{$job->location}} Philippines</span></li>
                                <li>Job Nature: <span> {{$job->job_nature_name}}</span></li>
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="share_wrap d-flex">
                        <span>Share at:</span>
                        <ul>
                            <li><a href="#"> <i class="fa fa-facebook"></i></a> </li>
                            <li><a href="#"> <i class="fa fa-google-plus"></i></a> </li>
                            <li><a href="#"> <i class="fa fa-twitter"></i></a> </li>
                            <li><a href="#"> <i class="fa fa-envelope"></i></a> </li>
                        </ul>
                    </div>
                    <div class="job_location_wrap">
                        <div class="job_lok_inner">
                            <div id="map" style="height: 200px;"></div>
                            <script>
                              function initMap() {
                                var uluru = {lat: -25.363, lng: 131.044};
                                var grayStyles = [
                                  {
                                    featureType: "all",
                                    stylers: [
                                      { saturation: -90 },
                                      { lightness: 50 }
                                    ]
                                  },
                                  {elementType: 'labels.text.fill', stylers: [{color: '#ccdee9'}]}
                                ];
                                var map = new google.maps.Map(document.getElementById('map'), {
                                  center: {lat: -31.197, lng: 150.744},
                                  zoom: 9,
                                  styles: grayStyles,
                                  scrollwheel:  false
                                });
                              }
                              
                            </script>
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpfS1oRGreGSBU5HHjMmQ3o5NLw7VdJ6I&callback=initMap"></script>
                            
                          </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-6 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="ion-ios-arrow-right"></i> <a href="https://entrego.com.ph/blog">Blog</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="https://entrego.com.ph/about">About us</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="https://entrego.com.ph/contact">Contact</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="https://entrego.com.ph/faqs">FAQs</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="https://entrego.com.ph/terms-and-conditions">Terms of service</a></li>
              <li><i class="ion-ios-arrow-right"></i> <a href="https://entrego.com.ph/privacy-policy">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-6 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              <i class="ion-ios-location-outline"></i>
              128 Pioneer Street, Buayang Bato, Mandaluyong, 1553 Metro Manila, Philippines <br>
              <strong>Customer Service:</strong> 
              <br><i class="ion-ios-email-outline"></i>
			  customersupport@entrego.com.ph<br>
              <strong>Partnership/Warehousing/Freight Forwarding:</strong> 
              <br><i class="ion-ios-email-outline"></i>
			  marketing.events@entrego.com.ph<br>
            </p>

            <div class="social-links">
              <a href="https://twitter.com/EntregoPh" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="https://www.facebook.com/EntregoPH/" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="https://www.instagram.com/entregoph/" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="https://www.linkedin.com/company/entregoph" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Entrego</strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- Uncomment below if you want to use a preloader -->
  <!-- <div id="preloader"></div> -->

  <script src="{{asset('landing-page/lib/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/jquery/jquery-migrate.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/easing/easing.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/superfish/hoverIntent.js')}}"></script>
  <script src="{{asset('landing-page/lib/superfish/superfish.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/wow/wow.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/waypoints/waypoints.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/counterup/counterup.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/isotope/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/lightbox/js/lightbox.min.js')}}"></script>
  <script src="{{asset('landing-page/lib/touchSwipe/jquery.touchSwipe.min.js')}}"></script>
  <!-- Contact Form JavaScript File -->
  <script src="{{asset('landing-page/contactform/contactform.js')}}"></script>

  <!-- Template Main Javascript File -->
  <script src="{{asset('landing-page/js/main.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    (function (){
      showMessage()
    })()
    async function showMessage()
    {
      @if(session()->has('message'))
          const title = '{{session()->has('title') ? session()->get('title') : 'Success'}}';
          const type = '{{session()->has('type') ? session()->get('type') : 'success'}}';
          await Swal.fire(
              title,
              '{{session()->get('message')}}',
              type
          )
          @if(session()->has('redirect'))
            location.href = '{{session()->get('redirect')}}'
          @endif
        @endif
    }
    async function logout(){
        await fetch('{{route('logout')}}', {
            'headers': {
                "X-CSRF-Token": '{{csrf_token()}}' 
            },
            'method': 'POST',
            'content-type': 'application/json',
            'body': JSON.stringify({
                'csrf-token': '{{csrf_token()}}' 
            })
        })
        location.reload()
    }
  </script>
</body>
</html>
