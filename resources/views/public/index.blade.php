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
          <li class="menu-active"><a href="index.html#intro">Home</a></li>
          <li><a href="{{route('job.listing')}}">Browse Jobs</a></li>
          <li class="menu-has-children">
          <a href="#">Entrego</a>
            <ul>
              <li><a href="https://entrego.com.ph/about">About Entrego</a></li>
              <li><a href="https://entrego.com.ph/blog">Blog</a></li>
              <li><a href="#contact">Contact Us</a></li>
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
  <section id="intro">
    <div class="intro-container">
      <div id="introCarousel" class="carousel  slide carousel-fade" data-ride="carousel">

        <ol class="carousel-indicators"></ol>


        <div class="carousel-inner" role="listbox">

            <div class="carousel-item active">
              <div class="carousel-background"><img src="{{asset('landing-page/img/intro-carousel/1.jpg')}}" alt=""></div>
              <div class="carousel-container">
                <div class="carousel-content">
                  <h2>Start your career at Entrego</h2>
                  <p>At Entrego, we believe in fostering a collaborative and innovative environment
                   that encourages growth and professional development. Your role in shaping our team 
                   is invaluable, and we're excited to see the incredible contributions you'll help us 
                   unlock through your endeavor!</p>
                  <a href="{{route('job.listing')}}" class="btn-get-started scrollto">Browse Jobs</a>
                </div>
              </div>
            </div>
  
            <div class="carousel-item">
              <div class="carousel-background"><img src="{{asset('landing-page/img/intro-carousel/2.jpg')}}" alt=""></div>
              <div class="carousel-container">
                <div class="carousel-content">
                  <h2>Life at Entrego.</h2>
                  <p>Entrego is a melting pot of talent from different backgrounds and geographies. We
                   value unique perspectives, ambition, and the humility to never settle for the status quo. 
                   Together we work to empower Philippine business, giving clients a newfound competitive advantage 
                   in logistics that’s powered by technology. </p>
                  {{-- <a href="#" class="btn-get-started scrollto">Get Started</a> --}}
                </div>
              </div>
            </div>
  
            <div class="carousel-item">
              <div class="carousel-background"><img src="{{asset('landing-page/img/intro-carousel/3.jpg')}}" alt=""></div>
              <div class="carousel-container">
                <div class="carousel-content">
                  <h2>Perks and Benefits</h2>
                  <p>We are a technology company that values uniqueness and excellence, at all times. We provide great 
                  perks and benefits that define the Entrego experience.</p>
                  <ul style="list-style-type:none">
                      <li><strong style="color:white">25 Leave Credits</strong>
                          <br><p>We value your work-life balance.</p>
                      </li>
                      <li><strong style="color:white">Health Card/Dental Benefit</strong>
                          <br><p>We value your overall health and wellness.</p>
                      </li>
                      <li><strong style="color:white">Trainings</strong>
                          <br><p>Continuous learning is guaranteed here in Entrego.</p>
                      </li>
                  </ul>
                  {{-- <a href="#featured-services" class="btn-get-started scrollto">View More</a> --}}
                </div>
              </div>
            </div>
            
          </div>

        <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>

      </div>
    </div>
  </section><!-- #intro -->
  {{-- <main id="main">
    <!--==========================
      Portfolio Section
    ============================-->
    <section id="portfolio"  class="section-bg" >
        <div class="container">
  
          <header class="section-header">
            <h3 class="section-title">Our Portfolio</h3>
          </header>
  
          <div class="row">
            <div class="col-lg-12">
              <ul id="portfolio-flters">
                <li data-filter="*" class="filter-active">All</li>
                <li data-filter=".filter-app">App</li>
                <li data-filter=".filter-card">Card</li>
                <li data-filter=".filter-web">Web</li>
              </ul>
            </div>
          </div>
  
          <div class="row portfolio-container">
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp">
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
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/card2.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/card2.jpg" class="link-preview" data-lightbox="portfolio" data-title="Card 2" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">Card 2</a></h4>
                  <p>Card</p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.1s">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/web2.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/web2.jpg" class="link-preview" data-lightbox="portfolio" data-title="Web 2" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">Web 2</a></h4>
                  <p>Web</p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp" data-wow-delay="0.2s">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/app3.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/app3.jpg" class="link-preview" data-lightbox="portfolio" data-title="App 3" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">App 3</a></h4>
                  <p>App</p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/card1.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/card1.jpg" class="link-preview" data-lightbox="portfolio" data-title="Card 1" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">Card 1</a></h4>
                  <p>Card</p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp" data-wow-delay="0.1s">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/card3.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/card3.jpg" class="link-preview" data-lightbox="portfolio" data-title="Card 3" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">Card 3</a></h4>
                  <p>Card</p>
                </div>
              </div>
            </div>
  
            <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.2s">
              <div class="portfolio-wrap">
                <figure>
                  <img src="img/portfolio/web1.jpg" class="img-fluid" alt="">
                  <a href="img/portfolio/web1.jpg" class="link-preview" data-lightbox="portfolio" data-title="Web 1" title="Preview"><i class="ion ion-eye"></i></a>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </figure>
  
                <div class="portfolio-info">
                  <h4><a href="#">Web 1</a></h4>
                  <p>Web</p>
                </div>
              </div>
            </div>
  
          </div>
  
        </div>
      </section><!-- #portfolio -->
  </main> --}}

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
