<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Entrego | Hirelogic</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

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
  <link href="{{asset('landing-page/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
    Theme Name: BizPage
    Theme URL: https://bootstrapmade.com/bizpage-bootstrap-business-template/
    Author: BootstrapMade.com
    License: https://bootstrapmade.com/license/
  ======================================================= -->
</head>

<body>

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
          <li ><a href="/">Home</a></li>
          <li class="menu-active"><a href="{{route('job.listing')}}">Browse Jobs</a></li>
          <li class="menu-has-children">
          <a href="#">Entrego</a>
            <ul>
              <li><a href="https://entrego.com.ph/about">About Entrego</a></li>
              <li><a href="https://entrego.com.ph/blog">Blog</a></li>
              <li><a href="https://entrego.com.ph/contact">Contact Us</a></li>
              <li><a href="#">Hirelogic Team</a></li>
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

  <!--==========================
    Intro Section
  ============================-->
 
  <main id="main">
    
    <!--==========================
      Call To Action Section
    ============================-->
    <section id="call-to-action" class="wow fadeIn">
        <div class="container text-center">
          <h3>We're hiring</h3>
          {{-- <a class="cta-btn" href="#">Call To Action</a> --}}
        </div>
      </section><!-- #call-to-action -->
    <!--==========================
      Portfolio Section
    ============================-->
    <section id="portfolio"  class="section-bg" >
        <div class="container">
  
          <header class="section-header">
            <h3 class="section-title">Job Listing</h3>
          </header>
  
          <div class="row">
            <div class="col-lg-12">
              <ul id="portfolio-flters">
                <li data-filter="*" class="filter-active">All</li>
                @foreach($list as $item)
                  <li data-filter=".filter-{{ $item['value'] }}">{{ $item['label'] }}</li>
                @endforeach
              </ul>
            </div>
          </div>
  
          <div class="row portfolio-container">
  
            {{-- <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/app1.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/app1.jpg" data-lightbox="portfolio" data-title="App 1" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">App 1</a></h4>
                  <p>App</p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.1s">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/web3.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/web3.jpg" class="link-preview" data-lightbox="portfolio" data-title="Web 3" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">Web 3</a></h4>
                  <p>Web</p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp" data-wow-delay="0.2s">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/app2.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/app2.jpg" class="link-preview" data-lightbox="portfolio" data-title="App 2" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">App 2</a></h4>
                  <p>App</p>
                </div>
              </div>
            </div> --}}

            @foreach($jobs as $job)
            <div class="col-lg-4 col-md-6 portfolio-item filter-{{$job->job_group}} wow fadeInUp">
              <div class="portfolio-wrap" style="">
                {{-- <figure>
                  <img src="img/portfolio/app1.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/app1.jpg" data-lightbox="portfolio" data-title="App 1" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure> --}}
  
                <div class="portfolio-info" >
                  <h4><a href="#">{{$job->job_title}}</a></h4>
                  <ul style="text-decoration: none;list-style:none; text-align:left">
                    <li>
                      <i class="ion-checkmark-round"></i> {{$job->job_nature_name}} 
                    </li>
                    <li>
                      <i class="ion-android-folder-open"></i> {{$job->vacancies}} position(s) available
                    </li>
                    <li>
                      <i class="ion-ios-clock-outline"></i> {{$job->required_experience_name}}
                    </li>
                    <li>
                      <i class="ion-arrow-graph-up-right"></i> {{$job->department_name}}
                    </li>
                    <li>
                      <i class="ion-ios-location-outline"></i> {{$job->location}}
                    </li>
                    <li>
                      <i class="ion-calendar"></i> {{$job->expires_at_name}}
                    </li>
                  </ul>
                  <a href="{{route('job.create', $job->id)}}" class="btn btn-get-started scrollto btn-success">Apply Now</button></a>
                </div>
              </div>
            </div>
            @endforeach
  
          </div>
  
        </div>
      </section><!-- #portfolio -->
  </main>

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
  <!-- Uncomment below i you want to use a preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- JavaScript Libraries -->
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
  <script>
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
