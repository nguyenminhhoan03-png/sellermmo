@php use App\Models\User; @endphp
<!DOCTYPE html>
<html lang="vn">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Giải pháp công nghệ toàn diện – Mã nguồn, Tên miền, Cronjobs!</title>

     <!--=====FAB ICON=======-->
    <link rel="shortcut icon" href="landing/assets/img/logo/fav-logo7.png" type="image/x-icon">

    <!--===== CSS LINK =======-->
    <link rel="stylesheet" href="landing/assets/css/plugins/bootstrap.min.css">
    <link rel="stylesheet" href="landing/assets/css/plugins/aos.css">
    <link rel="stylesheet" href="landing/assets/css/plugins/fontawesome.css">
    <link rel="stylesheet" href="landing/assets/css/plugins/magnific-popup.css">
    <link rel="stylesheet" href="landing/assets/css/plugins/mobile.css">
    <link rel="stylesheet" href="landing/assets/css/plugins/owlcarousel.min.css">
    <link rel="stylesheet" href="landing/assets/css/plugins/sidebar.css">
    <link rel="stylesheet" href="landing/assets/css/plugins/slick-slider.css">
    <link rel="stylesheet" href="landing/assets/css/plugins/nice-select.css">
    <link rel="stylesheet" href="landing/assets/css/main.css">

    <!--=====  JS SCRIPT LINK =======-->
    <script src="landing/assets/js/plugins/jquery-3-6-0.min.js"></script>
</head>
<body class="homepage8-body">

<!--===== PRELOADER STARTS =======-->
<div class="preloader preloader8">
  <div class="loading-container">
    <div class="loading"></div>
    <div id="loading-icon"><img src="landing/assets/img/logo/preloader7.png" alt=""></div>
  </div>
</div>
<!--===== PRELOADER ENDS =======-->

<!--===== PROGRESS STARTS=======-->
<div class="paginacontainer">
     <div class="progress-wrap">
       <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
       </svg>
     </div>
   </div>
 <!--===== PROGRESS ENDS=======-->
<style>
    .muabanwebsite {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  width: 100%;
  max-width: 250px;
}
</style>
   <!--=====HEADER START=======-->
   <header>
    <div class="header-area homepage8 header header-sticky d-none d-lg-block " id="header">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="header-elements">
              <div class="site-logo">
                <a href="/"><img src="{{ setting_asset('logo_light') }}" alt=""></a>
              </div>
              <div class="main-menu">
                <ul>
                  <li><a href="#">Mã Nguồn <i class="fa-solid fa-angle-down"></i></a>
                    <div class="tp-submenu">
                      <div class="row">
                         <div class="col-lg-12">
                            @foreach($seach->take(12) as $index => $seachs)
    @if($index % 4 == 0)
        <div class="all-images-menu">
    @endif

    <div class="images">
        <div class="homemenu-thumb">
            <div class="img1">
                <img src="{{ $seachs->images }}" alt="">
            </div>
            <div class="homemenu-btn">
                <a class="header-btn15" href="/view/{{ $seachs->slug ?? $seachs->id }}" target="_blank">Xem <span><i class="fa-solid fa-arrow-right"></i></span></a>
            </div>
            <div class="homemenu-content muabanwebsite">
                <a href="/view/{{ $seachs->slug ?? $seachs->id }}">{{ $seachs->name }}</a>
            </div>
        </div>
        <div class="space20"></div>
    </div>

    @if(($index + 1) % 4 == 0 || $loop->last)
        </div>
    @endif
@endforeach

                          
                         </div>
                      </div>
                   </div>
                  </li>
                  <li><a href="#">Dịch Vụ <i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-padding">
                      <li><a href="/">Mã Nguồn</a></li>
                      <li><a href="/domain">Tên Miền</a></li>
                      <li><a href="/cronjob">CronJobs</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Tiện Ích <i class="fa-solid fa-angle-down"></i></a>
                  <ul class="dropdown-padding">
                    <li><a href="/upanh">Link Ảnh</a></li>
                    <li><a href="/whois">Whois Domain</a></li>
                    <li><a href="/info-fb">FIND ID FB</a></li>
                    <li><a href="/tiktok">Tải Video TIKTOK</a></li>
                  </ul>
                  </li>
                  <li><a href="contact.html">Contact Us</a></li>
                </ul>
              </div>
              <div class="btn-area">
                <div class="search-icon header__search header-search-btn">
                  <a href="#"><img src="landing/assets/img/icons/search-icons2.svg" alt=""></a>
                </div>
                <a href="/login" class="header-btn15">Đăng Nhập <span><i class="fa-solid fa-arrow-right"></i></span></a>
              </div>

              <div class="header-search-form-wrapper">
                <div class="tx-search-close tx-close"><i class="fa-solid fa-xmark"></i></div>
                <div class="header-search-container">
                    <form role="search" class="search-form" >
                    <input type="search"  class="search-field" placeholder="Search …" value="" name="s">
                    <button type="submit" class="search-submit"><img src="landing/assets/img/icons/search-icons2.svg" alt=""></button>
                    </form>
                </div>
            </div>
            <div class="body-overlay"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!--=====HEADER END =======-->

  <!--===== MOBILE HEADER STARTS =======-->
 <div class="mobile-header mobile-haeder8 d-block d-lg-none">
  <div class="container-fluid">
    <div class="col-12">
      <div class="mobile-header-elements">
        <div class="mobile-logo">
          <a href="/"><img src="{{ setting_asset('logo_light') }}" alt=""></a>
        </div>
        <div class="mobile-nav-icon dots-menu">
          <i class="fa-solid fa-bars"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mobile-sidebar mobile-sidebar8">
  <div class="logosicon-area">
    <div class="logos">
      <img src="{{ setting_asset('logo_light') }}" alt="">
    </div>
    <div class="menu-close">
      <i class="fa-solid fa-xmark"></i>
    </div>
   </div>
  <div class="mobile-nav mobile-nav1">
    <ul class="mobile-nav-list nav-list1">
      <li><a href="#" >Dịch Vụ </a>
        <ul class="sub-menu">
            <li><a href="/">Mã Nguồn</a></li>
            <li><a href="/domain">Tên Miền</a></li>
            <li><a href="/cronjob">CronJobs</a></li>
          </li>
        </ul>
      </li>
      <li><a href="#">Tiện Ích</a>
        <ul class="sub-menu">
            <li><a href="/upanh">Link Ảnh</a></li>
            <li><a href="/whois">Whois Domain</a></li>
            <li><a href="/info-fb">FIND ID FB</a></li>
            <li><a href="/tiktok">Tải Video TIKTOK</a></li>
        </ul>
      </li>
      <li><a href="contact.html">Contact Us</a></li>
    </ul>

    <div class="allmobilesection">
      <a href="/login"  class="header-btn15">Đăng Nhập <span><i class="fa-solid fa-arrow-right"></i></span></a>
      <div class="single-footer">
        <h3>Contact Info</h3>
        <div class="footer1-contact-info">
          <div class="contact-info-single">
            <div class="contact-info-icon">
              <i class="fa-solid fa-phone-volume"></i>
            </div>
            <div class="contact-info-text">
              <a href="tel:{{ setting('sdt') }}">{{ setting('sdt') }}</a>
            </div>
          </div>

          <div class="contact-info-single">
            <div class="contact-info-icon">
              <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="contact-info-text">
              <a href="mailto:{{ setting('email') }}">{{ setting('email') }}</a>
            </div>
          </div>

          <div class="single-footer">
            <h3>Our Location</h3>
            
            <div class="contact-info-single">
              <div class="contact-info-icon">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <div class="contact-info-text">
                <a href="mailto:{{ setting('email') }}" >VietNam</a>
              </div>
            </div>

          </div>
          <div class="single-footer">
            <h3>Social Links</h3>
            
            <div class="social-links-mobile-menu">
              <ul>
                <li><a href="{{ setting('link_fb') }}"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
     </div>
  </div>
</div>
<!--===== MOBILE HEADER STARTS =======-->

<!--===== HERO AREA STARTS =======-->
<div class="hero8-section-area">
    <img src="landing/assets/img/elements/elements16.png" alt="" class="elements16 keyframe5">
    <img src="landing/assets/img/elements/elements17.png" alt="" class="elements17 aniamtion-key-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="hero8-header text-center heading1">
                    <h1 class="text-anime-style-3">Code, Domains, Cronjobs – All in One!</h1>
                    <p>Cung cấp mã nguồn, tên miền, cronjobs – tối ưu giải pháp công nghệ!.</p>
                    <div class="space32"></div>
                    <form method="GET" action="/domain">
                        <span class="global"><i class="fa-solid fa-globe"></i></span>
                        <input type="text" name="dvr" placeholder="Tên miền muốn đăng ký">
                        <div class="btn-area1">
                            <button class="header-btn15" type="submit">Đăng Ký <span><i class="fa-solid fa-arrow-right"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <img src="landing/assets/img/elements/star8.png" alt="" class="star8 keyframe6">
    <img src="landing/assets/img/elements/star8.png" alt="" class="star9 keyframe6">
    <div class="space80"></div>
    <div class="bottom-img reveal">
        <img src="landing/assets/img/all-images/header-img11.png" alt="">
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== ABOUT AREA STARTS =======-->
<div class="about8-section-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2">
                <div class="counter-area heading13">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-6" data-aos="fade-left" data-aos-duration="800">
                            <div class="counter-box">
                                <h3><span>500</span>+</h3>
                                <p>Campaigns</p>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-6 col-6" data-aos="fade-left" data-aos-duration="900">
                            <div class="counter-box">
                                <h3><span>98</span>%</h3>
                                <p>Client Satisfaction</p>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-6 col-6"data-aos="fade-left" data-aos-duration="1000">
                            <div class="counter-box">
                                <h3><span>25</span>+</h3>
                                <p>Country Reach</p>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-6 col-6" data-aos="fade-left" data-aos-duration="1200">
                            <div class="counter-box after">
                                <h3><span>15</span>+</h3>
                                <p>Certified Experts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="images" data-aos="zoom-in" data-aos-duration="1000">
                    <img src="landing/assets/img/all-images/about-img9.png" alt="">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about8-header heading13">
                    <h5 data-aos="fade-right" data-aos-duration="800">About Us</h5>
                    <h2 class="text-anime-style-3">Hãy Đến Với Chúng Tôi</h2>
                    <p data-aos="fade-right" data-aos-duration="1000">Nâng cao nhận thức thương hiệu và tạo ra doanh số bằng cách kết hợp chiến lược sáng tạo và tiếp cận đích đáng để thu hút khách hàng.</p>
                    <div class="space32"></div>
                    <div class="btn-area1" data-aos="fade-right" data-aos-duration="1200">
                        <a href="/home" class="header-btn15">Home <span><i class="fa-solid fa-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== ABOUT AREA ENDS =======-->

<!--===== SERVICE AREA STARTS =======-->
<div class="service8-section-area sp1">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 m-auto">
        <div class="service-header-area heading13 text-center">
            <h5>Our Service</h5>
          <h2 class="text-anime-style-3">Dịch Vụ Toàn Diện của Chúng Tôi!</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="service-all-boxes-area">
          <div class="service-boxarea" data-aos="zoom-in" data-aos-duration="800">
            <a href="service5.html">Search Engine Optimization ( SEO)</a>
            <div class="space40"></div>
            <img src="landing/assets/img/icons/service-icons19.svg" alt="">
            <div class="space40"></div>
            <p>Enhance your online visibility & drive organic traffic with our advanced SEO techniques. We optimize your website to rank higher.</p>
          </div>

          <div class="service-boxarea box2" data-aos="zoom-in" data-aos-duration="1000">
            <a href="service3.html">Pay-Per-Click (PPC) Advertising</a>
            <div class="space40"></div>
            <img src="landing/assets/img/icons/service-icons20.svg" alt="">
            <div class="space40"></div>
            <p>Reach your audience instantly and drive qualified leads with targeted PPC campaigns. Our experts craft compelling ad copy and optimize.</p>
          </div>

          <div class="service-boxarea box3" data-aos="zoom-in" data-aos-duration="1200">
            <a href="service2.html">Social Media Marketing</a>
            <div class="space66"></div>
            <img src="landing/assets/img/icons/service-icons21.svg" alt="">
            <div class="space40"></div>
            <p>Build a strong brand presence and engage with your audience on social media platforms. We create strategic social media campaigns to boost brand.</p>
          </div>

          <div class="service-boxarea box4" data-aos="zoom-in" data-aos-duration="1400">
            <a href="service4.html">Website Design and Development</a>
            <div class="space40"></div>
            <img src="landing/assets/img/icons/service-icons22.svg" alt="">
            <div class="space40"></div>
            <p>Make a lasting impression with a professionally designed and user-friendly website. Our web design and development services ensure website.</p>
          </div>
        </div>
        <div class="space40"></div>
        <div class="btn-area1 text-center">
            <a href="/home" class="header-btn15">View More Service <span><i class="fa-solid fa-arrow-right"></i></span></a>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== SERVICE AREA ENDS =======-->

<!--===== WORK AREA STARTS =======-->
<div class="work8-section-area sp1">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 m-auto">
        <div class="work-header text-center heading13">
          <h5>Work Process</h5>
          <h2 class="text-anime-style-3">Why Partner With SEOC Your Path To <br class="d-lg-block d-none"> SEO & Digital Marketing Success</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="img1 reveal">
          <img src="landing/assets/img/all-images/work-img6.png" alt="">
        </div>
      </div>
      <div class="col-lg-1"></div>
      <div class="col-lg-5">
        <div class="head">
          <h4>Quy trình làm việc của SEOC</h4>
        </div>
        <div class="works-boxarea" data-aos="fade-left" data-aos-duration="800">
          <div class="list">
            <h3>01</h3>
          </div>
          <div class="content">
            <a href="#">Phát triển chiến lược</a>
            <p>Dựa trên những phát hiện của mình, chúng tôi phát triển <br class="d-lg-block d-none"> chiến lược tiếp thị kỹ thuật số phù hợp với mục tiêu cụ thể.</p>
          </div>
        </div>

        <div class="works-boxarea auhtor" data-aos="fade-left" data-aos-duration="1000">
          <div class="list">
            <h3>02</h3>
          </div>
          <div class="content">
            <a href="#">Giám sát & Tối ưu hóa</a>
            <p>Chúng tôi tin vào sức mạnh của <br class="d-lg-block d-none"> việc ra quyết định dựa trên dữ liệu. Trong suốt chiến dịch.</p>
          </div>
        </div>

        <div class="works-boxarea" data-aos="fade-left" data-aos-duration="1200">
          <div class="list">
            <h3>03</h3>
          </div>
          <div class="content">
            <a href="#">Cải tiến liên tục</a>
            <p>Tiếp thị kỹ thuật số là một lĩnh vực không ngừng phát triển và <br class="d-lg-block d-none"> chúng tôi cam kết luôn đi đầu.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== WORK AREA ENDS =======--> 

<!--===== TESTIMONIAL AREA STARTS =======-->
<div class="testimonial8-section-area sp1">
  <div class="container">
      <div class="row">
          <div class="col-lg-5 m-auto">
              <div class="testimonia4-header text-center heading13">
                  <h5 data-aos="fade-up" data-aos-duration="1000">Testimonials</h5>
                  <h2 class="text-anime-style-3">What Our Client Say</h2>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12" data-aos="zoom-out" data-aos-duration="1200">
              <div class="testimonial4-slider-area owl-carousel">
                  <div class="testimonial-boxarea">
                      <img src="landing/assets/img/icons/quito5.svg" alt="" class="quito">
                      <p>"Là một công ty khởi nghiệp, chúng tôi cần một đối tác tiếp thị kỹ thuật số có thể hiểu được nhu cầu riêng của chúng tôi và cung cấp các giải pháp tiết kiệm chi phí. SEOC chính là đối tác đó của chúng tôi."</p>
                      <div class="space48"></div>
                      <div class="auhtor-logo">
                          <div class="text">
                              <a href="team.html">MuaBanWebsite.</a>
                              <ul>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                              </ul>
                          </div>
                          <div class="logo">
                              <img src="landing/assets/img/icons/google1.svg" alt="">
                          </div>
                      </div>
                  </div>

                  <div class="testimonial-boxarea">
                      <img src="landing/assets/img/icons/quito5.svg" alt="" class="quito">
                      <p>“Chúng tôi đã hợp tác với SEOC trong hơn một năm nay và kết quả đã nói lên tất cả. Các giải pháp tiếp thị kỹ thuật số toàn diện của họ đã giúp chúng tôi đạt được mức tăng trưởng có thể đo lường được."</p>
                      <div class="space48"></div>
                      <div class="auhtor-logo">
                          <div class="text">
                              <a href="team.html">David LTC.</a>
                              <ul>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                              </ul>
                          </div>
                          <div class="logo">
                              <img src="landing/assets/img/icons/google1.svg" alt="">
                          </div>
                      </div>
                  </div>
                  <div class="testimonial-boxarea">
                      <img src="landing/assets/img/icons/quito5.svg" alt="" class="quito">
                      <p>Làm việc với SEOC đã thay đổi cuộc chơi cho doanh nghiệp của chúng tôi. Cách tiếp cận chiến lược của họ đối với tiếp thị kỹ thuật số SEO đã làm tăng đáng kể khả năng hiển thị trực tuyến và tạo khách hàng tiềm năng của chúng tôi.”</p>
                      <div class="space48"></div>
                      <div class="auhtor-logo">
                          <div class="text">
                              <a href="team.html">Sarah L.</a>
                              <ul>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                              </ul>
                          </div>
                          <div class="logo">
                              <img src="landing/assets/img/icons/google1.svg" alt="">
                          </div>
                      </div>
                  </div>

                  <div class="testimonial-boxarea">
                      <img src="landing/assets/img/icons/quito5.svg" alt="" class="quito">
                      <p>“We've been partnering with SEOC for over a year now, and the results speak for themselves. Their comprehensive digital marketing solutions have helped us achieve measurable growth."</p>
                      <div class="space48"></div>
                      <div class="auhtor-logo">
                          <div class="text">
                              <a href="team.html">David M.</a>
                              <ul>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                              </ul>
                          </div>
                          <div class="logo">
                              <img src="landing/assets/img/icons/google1.svg" alt="">
                          </div>
                      </div>
                  </div>

                  <div class="testimonial-boxarea">
                      <img src="landing/assets/img/icons/quito5.svg" alt="" class="quito">
                      <p>"As a startup, we needed a digital marketing partner that could understand our unique needs and deliver cost-effective solutions. SEOC has been that partner for us.”</p>
                      <div class="space48"></div>
                      <div class="auhtor-logo">
                          <div class="text">
                              <a href="team.html">Emily R.</a>
                              <ul>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                                  <li><i class="fa-solid fa-star"></i></li>
                              </ul>
                          </div>
                          <div class="logo">
                              <img src="landing/assets/img/icons/google1.svg" alt="">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<!--===== TESTIMONIAL AREA ENDS =======-->

<!--===== BLOG AREA STARTS =======-->
<div class="blog8-scetion-area sp2">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 m-auto">
        <div class="blog-hedaer-area heading13 text-center">
          <h5>Source Code</h5>
          <h2 class="text-anime-style-3">Featured Source Code</h2>
        </div>
      </div>
    </div>
    <div class="row">
        @foreach($seach->take(3) as $index => $seachsz)
        @php
          $user = User::where('id', $seachsz->user_id)->first();
          @endphp
      <div class="col-lg-4 col-md-6">
        <div class="blog-author-boxarea" data-aos="fade-right" data-aos-duration="800">
          <div class="img1">
            <img src="{{ $seachsz->images }}" alt="">
          </div>
          <div class="content-area">
            <div class="tags-area">
              <ul>
                <li><a href="#"> # SEO</a></li>
                <li><a href="#"> # Web Design</a></li>
                <li><a href="#"> # SRC</a></li>
                <li><a href="#"><img src="landing/assets/img/icons/contact1.svg" alt="">{{ $user->name }}</a></li>
              </ul>
            </div>
            <a href="#" class="muabanwebsite">{{ $seachsz->name }}</a>
            <p>Mã nguồn đã được kiểm tra trước khi đăng tải</p>
            <a href="/view/{{ $seachsz->slug ?? $seachsz->id }}" class="header-btn15">Read More <i class="fa-solid fa-arrow-right"></i></a>
            <div class="date">
              <a href="#">{{ $seachsz->created_at->diffForHumans() }}</a>
            </div>
          </div>
        </div>
        <div class="space30 d-lg-none d-block"></div>
    </div>
        @endforeach
      
    </div>
  </div>
</div>
<!--===== BLOG AREA ENDS =======-->

<!--===== CTA AREA STARTS =======-->
<div class="cta8-section-area sp1">
  <img src="landing/assets/img/bg/cta-bg1.png" alt="" class="cta-bg1 aniamtion-key-2">
  <img src="landing/assets/img/bg/cta-bg2.png" alt="" class="cta-bg2 aniamtion-key-1">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 m-auto">  
        <div class="cta-header-area text-center heading2">
          <h2 class="text-anime-style-3">Start Your Journey To Online Success Today</h2>
          <p data-aos="fade-up" data-aos-duration="1000">Your business deserves to shine in the digital world. SEOC is here to make that happen. Our proven <br class="d-lg-block d-none"> strategies and personalized approach ensure that your unique needs are met.</p>
          <div class="btn-area text-center" data-aos="fade-up" data-aos-duration="1200">
          <a href="/home" class="header-btn15">Get Started Today <span><i class="fa-solid fa-arrow-right"></i></span></a>
          <a href="{{ setting('link_fb') }}" class="header-btn15 btn2">Request a Consultation <span><i class="fa-solid fa-arrow-right"></i></span></a>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== CTA AREA ENDS =======-->

<!--===== FOOTER AREA STARTS =======-->
<div class="footer8-section-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="footer-logo-area">
          <img src="{{ setting_asset('logo_light') }}" alt="" class="logo">
          <p>Hãy đến với chúng tôi , chúng tôi sẽ mang đến cho bạn một trải nghiệm tốt</p>
          <ul>
            <li><a href="{{ setting('link_fb') }}"><img src="landing/assets/img/icons/facebook7.svg" alt=""></a></li>
            <li><a href="#"><img src="landing/assets/img/icons/instagram7.svg" alt=""></a></li>
            <li><a href="#"><img src="landing/assets/img/icons/linkedin7.svg" alt=""></a></li>
            <li><a href="#"><img src="landing/assets/img/icons/youtube7.svg" alt=""></a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-2 col-md-6">
        <div class="footer-logo-area1">
          <h3>About Link</h3>
          <ul>
            <li><a href="/">Mã Nguồn</a></li>
            <li><a href="/domain">Tên Miền</a></li>
            <li><a href="/cronjob">CronJobs</a></li>
          </ul>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="footer-logo-area2">
          <h3>Thông Tin</h3>
          <ul>
            <li><a href="mailto"><img src="landing/assets/img/icons/email.svg" alt=""><span>{{ setting('email') }}</span></a></li>
            <li><a href="#"><img src="landing/assets/img/icons/location.svg" alt=""><span>VietNam</span></a></li>
            <li><a href="tel:{{ setting('sdt') }}"><img src="landing/assets/img/icons/phone.svg" alt=""><span>{{ setting('sdt') }}</span></a></li>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="footer-logo-area3">
          <h3>Subscribe Our Newsletter</h3>
          <form action="#">
            <input type="text" placeholder="Enter Your email">
            <button class="header-btn15"> Subscribe <span><i class="fa-solid fa-arrow-right"></i></span></button>
          </form>
        </div>
      </div>
    </div>
    <div class="space80 d-lg-block d-none"></div>
    <div class="space40 d-lg-none d-block"></div>
    <div class="row">
      <div class="col-lg-12">
        <div class="copyright-area">
          <div class="pera">
            <p>ⓒCopyright 2024 DVR LTC . All rights reserved</p>
          </div>
          <ul>
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#" class="m-0"> Privacy  Policy </a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== FOOTER AREA ENDS =======-->

<!--===== JS SCRIPT LINK =======-->
<script src="landing/assets/js/plugins/bootstrap.min.js"></script>
<script src="landing/assets/js/plugins/fontawesome.js"></script>
<script src="landing/assets/js/plugins/aos.js"></script>
<script src="landing/assets/js/plugins/counter.js"></script>
<script src="landing/assets/js/plugins/gsap.min.js"></script>
<script src="landing/assets/js/plugins/ScrollTrigger.min.js"></script>
<script src="landing/assets/js/plugins/Splitetext.js"></script>
<script src="landing/assets/js/plugins/sidebar.js"></script>
<script src="landing/assets/js/plugins/magnific-popup.js"></script>
<script src="landing/assets/js/plugins/mobilemenu.js"></script>
<script src="landing/assets/js/plugins/owlcarousel.min.js"></script>
<script src="landing/assets/js/plugins/gsap-animation.js"></script>
<script src="landing/assets/js/plugins/nice-select.js"></script>
<script src="landing/assets/js/plugins/waypoints.js"></script>
<script src="landing/assets/js/plugins/slick-slider.js"></script>
<script src="landing/assets/js/plugins/circle-progress.js"></script>
<script src="landing/assets/js/main.js"></script>

</body>
</html>