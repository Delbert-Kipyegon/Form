<?php
session_start();
include 'php/db.php';
$unique_id = $_SESSION['unique_id'];
$email = $_SESSION['email'];
if (empty($unique_id)) {
    header("Location: login_page.html");
}
$qry = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
if (mysqli_num_rows($qry) > 0) {
    $row = mysqli_fetch_assoc($qry);
    $first_name = $row['fname'];
    $phone = $row['phone'];
    $role = $row['Role'];
    $data = "20";
    $amount = "20";

    if ($row) {
        $_SESSION['Role'] = $row['Role'];
        if ($row['verification_status'] != 'Verified') {
            header("Location: verify.html");
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <link rel="stylesheet" href="css1/owl.carousel.min.css">
    <link rel="stylesheet" href="css1/fontAwsome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css1/style.css">
</head>

<body>

    <!-- preloader start -->
    <!-- <div class="preloader">
        <span></span>
    </div> -->
    <!-- preloader End -->
    <!--Navbar-->
    <nav style="background: #a200ff; " class="navbar navbar-expand-lg fixed-top">
        <!-- Brand -->
        <div class="container">
            <a class="navbar-brand" href="#">Welcome:
                <?php echo $first_name; ?>
            </a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" data-scroll-nav="0" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        // Check if the user is an admin and set the dashboard link accordingly
                        if ($_SESSION['Role'] === 'admin') {
                            echo '<a class="nav-link" href="./task/admin_dashboard.php">Dashboard</a>';
                        } else {
                            echo '<a class="nav-link" href="./task/user_dashboard.php">Dashboard</a>';
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-scroll-nav="2" href="#screenshots">Screenshots</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-scroll-nav="3" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-scroll-nav="4" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-scroll-nav="5" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item logout-btn">
                        <a class="nav-link" href="php/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Home section start-->
    <section class="home d-flex align-items-center" id="home" data-scroll-index="0">
        <div class="effect-wrap">
            <i class="fas fa-plus effect effect-1"></i>
            <i class="fas fa-plus effect effect-2"></i>
            <i class="fas fa-circle-notch effect effect-3"></i>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="home-text">
                        <h1>Best Mobile App For Your Business</h1>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia, possimus ipsam ullam
                            itaque commodi voluptatem aliquid dignissimos blanditiis, iste at impedit, velit earum harum
                            corrupti odio non? Facere, sequi repellat. </p>
                        <div class="home-btn">
                            <a href="<?php echo ($_SESSION['Role'] === 'admin') ? './task/admin_dashboard.php' : './task/user_dashboard.php'; ?>"
                                target="_blank" class="btn btn-1">Dashboard</a>
                            <button type="button" class="btn btn-1 video-play-button" onclick="video_play()"><i
                                    class="fas fa-play"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-center">
                    <div class="home-img">
                        <div class="circle"></div>
                        <img class="landing-img" src="./zoom-fatique1.png" alt="Landing">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Home section End-->

    <!-- Features section Start -->
    <section class="features section-padding" id="features" data-scroll-index="1">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>Awesome <span>Features</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel features-carousel">
                    <div class="features-item">
                        <div class="icon"><i class="fas fa-code"></i></div>
                        <h3>Clean Code</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia, possimus ipsam ullam
                            itaque commodi </p>
                    </div>
                    <div class="features-item">
                        <div class="icon"><i class="fas fa-edit"></i></div>
                        <h3>Auto Install System</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia, possimus ipsam ullam
                            itaque commodi </p>
                    </div>
                    <div class="features-item">
                        <div class="icon"><i class="fas fa-paint-brush"></i></div>
                        <h3>Pixel perfect Design</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia, possimus ipsam ullam
                            itaque commodi </p>
                    </div>
                    <div class="features-item">
                        <div class="icon"><i class="fas fa-check"></i></div>
                        <h3>Fast Load App</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia, possimus ipsam ullam
                            itaque commodi </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Features section End -->

    <!-- fun factes section start -->
    <section class="fun-facts section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-5">
                    <div class="fun-facts-img text-center">
                        <img src="img1/app-screenshots/2.png" alt="Fun Facts">
                    </div>
                </div>
                <div class="col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2>Fun <span>Facts</span> </h2>
                    </div>
                    <div class="fun-facts-text">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio quibusdam ex ea dolorum
                            laudantium asperiores consequuntur et maiores cupiditate repellendus. Architecto expedita
                            sit at ad sed aliquid suscipit obcaecati vero?</p>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="fun-fact-item style-1">
                                    <h3>
                                        <?php echo $data; ?>
                                    </h3>
                                    <span>Downloads</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fun-fact-item style-2">
                                    <h3>
                                        <?php echo $amount; ?>
                                    </h3>
                                    <span>Likes</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fun-fact-item style-3">
                                    <h3>500</h3>
                                    <span>Star Rate</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="fun-fact-item style-4">
                                    <h3>150</h3>
                                    <span>AWARDS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- fun factes section End -->


    <!-- App screenshots section start -->
    <section class="app-screenshots section-padding" data-scroll-index="2" id="screenshots">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>App <span>Screenshots</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel screenshots-carousel">
                    <div class="screenshot-item">
                        <img src="img1/app-screenshots/1.png" alt="screenshots">
                    </div>
                    <div class="screenshot-item">
                        <img src="img1/app-screenshots/2.png" alt="screenshots">
                    </div>
                    <div class="screenshot-item">
                        <img src="img1/app-screenshots/3.png" alt="screenshots">
                    </div>
                    <div class="screenshot-item">
                        <img src="img1/app-screenshots/1.png" alt="screenshots">
                    </div>
                    <div class="screenshot-item">
                        <img src="img1/app-screenshots/2.png" alt="screenshots">
                    </div>
                    <div class="screenshot-item">
                        <img src="img1/app-screenshots/3.png" alt="screenshots">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- App screenshots section End -->


    <!-- video pupup start -->
    <div class="video-popup" onclick="video_play()">
        <div class="video-popup-inner">
            <i class="fas fa-times video-popup-close"></i>
            <div class="iframe-box">
                <iframe id="player-1" src="https://www.youtube.com/embed/45izX9pkiiw"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <!-- video pupup End -->

    <!-- App Download Section Start -->
    <section class="app-download section-padding" data-scroll-index="3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>Download <span>App</span> </h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="app-download-item">
                        <i class="fab fa-google-play"></i>
                        <h3>Google Play</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum exercitationem deleniti quia
                            excepturi dicta. Ipsum adipisci veniam ullam assumenda, vero vitae iusto dolore! Esse
                            voluptatem soluta maxime iure eaque doloremque!</p>
                        <a href="#" class="btn btn-2">Download Now</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="app-download-item">
                        <i class="fab fa-apple"></i>
                        <h3>Apple Store</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum exercitationem deleniti quia
                            excepturi dicta. Ipsum adipisci veniam ullam assumenda, vero vitae iusto dolore! Esse
                            voluptatem soluta maxime iure eaque doloremque!</p>
                        <a href="#" class="btn btn-2">Download Now</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="app-download-item">
                        <i class="fab fa-windows"></i>
                        <h3>Microsoft Store</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum exercitationem deleniti quia
                            excepturi dicta. Ipsum adipisci veniam ullam assumenda, vero vitae iusto dolore! Esse
                            voluptatem soluta maxime iure eaque doloremque!</p>
                        <a href="#" class="btn btn-2">Download Now</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- App Download Section End -->

    <!-- how it works section start -->
    <section class="how-it-works section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>How It <span>Works</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="how-it-works-item line-right">
                        <div class="step">1</div>
                        <h3>Download</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="how-it-works-item line-right">
                        <div class="step">2</div>
                        <h3>Create Profile</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="how-it-works-item line-right">
                        <div class="step">3</div>
                        <h3>Search Product</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="how-it-works-item">
                        <div class="step">4</div>
                        <h3>Order</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- how it works section End -->

    <!-- Testimonials section start -->
    <section class="testimonials section-padding" data-scroll-index="3" id="testimonials">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>What Our <span>Client</span> Say </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel testimonials-carousel">
                    <div class="testimonials-item">
                        <div class="img-box">
                            <img src="img1/testimonial/1.jpg" alt="testimonials">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam delectus at nemo possimus
                            quibusdam. Odit, blanditiis, sunt tempore aut dolor </p>
                        <h3>Hatem Saadany</h3>
                        <span>UI Designer</span>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>

                    </div>
                    <div class="testimonials-item">
                        <div class="img-box">
                            <img src="img1/testimonial/1.jpg" alt="testimonials">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam delectus at nemo possimus
                            quibusdam. Odit, blanditiis, sunt tempore aut dolor </p>
                        <h3>Hatem Saadany</h3>
                        <span>UI Designer</span>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>

                    </div>
                    <div class="testimonials-item">
                        <div class="img-box">
                            <img src="img1/testimonial/3.jpg" alt="testimonials">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam delectus at nemo possimus
                            quibusdam. Odit, blanditiis, sunt tempore aut dolor </p>
                        <h3>Hatem Saadany</h3>
                        <span>UI Designer</span>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>

                    </div>
                    <div class="testimonials-item">
                        <div class="img-box">
                            <img src="img1/testimonial/3.jpg" alt="testimonials">
                            <i class="fas fa-quote-right"></i>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam delectus at nemo possimus
                            quibusdam. Odit, blanditiis, sunt tempore aut dolor </p>
                        <h3>Hatem Saadany</h3>
                        <span>UI Designer</span>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials section End -->

    <!-- Pricing section start -->
    <section class="pricing section-padding" data-scroll-index="4" id="pricing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>pricing <span>Plan</span> </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-plan">
                        <div class="pricing-header">
                            <h3>Basic</h3>
                        </div>
                        <div class="pricing-price">
                            <span class="currency">$</span>
                            <span class="price">99</span>
                            <span class="period">/monthly</span>
                        </div>
                        <div class="pricing-body">
                            <ul>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="" class="btn btn-2">Get started</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="pricing-plan">
                        <div class="pricing-header">
                            <h3>Basic</h3>
                        </div>
                        <div class="pricing-price">
                            <span class="currency">$</span>
                            <span class="price">99</span>
                            <span class="period">/monthly</span>
                        </div>
                        <div class="pricing-body">
                            <ul>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="" class="btn btn-2">Get started</a>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-md-6">
                    <div class="pricing-plan">
                        <div class="pricing-header">
                            <h3>Premium</h3>
                        </div>
                        <div class="pricing-price">
                            <span class="currency">$</span>
                            <span class="price">99</span>
                            <span class="period">/monthly</span>
                        </div>
                        <div class="pricing-body">
                            <ul>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                                <li><i class="fas fa-check"></i>5 GB Bandwidth</li>
                            </ul>
                        </div>
                        <div class="pricing-footer">
                            <a href="" class="btn btn-2">Get started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing section End -->

    <!-- Team Section Start -->
    <section class="team section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>Team <span>Member</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel team-carousel">
                    <div class="team-item">
                        <img src="img1/team/3.jpg" alt="Team">
                        <h3>Hatem Bassem</h3>
                        <span>UI Designer</span>
                    </div>
                    <div class="team-item">
                        <img src="img1/team/4.jpg" alt="Team">
                        <h3>Hatem Bassem</h3>
                        <span>UI Designer</span>
                    </div>
                    <div class="team-item">
                        <img src="img1/team/3.jpg" alt="Team">
                        <h3>Hatem Bassem</h3>
                        <span>UI Designer</span>
                    </div>
                    <div class="team-item">
                        <img src="img1/team/4.jpg" alt="Team">
                        <h3>Hatem Bassem</h3>
                        <span>UI Designer</span>
                    </div>
                    <div class="team-item">
                        <img src="img1/team/3.jpg" alt="Team">
                        <h3>Hatem Bassem</h3>
                        <span>UI Designer</span>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Faq section Start -->
    <section class="faq section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>Frequently <span>Asked</span> Queries</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div id="accordion">
                        <div class="accordion-item">
                            <div class="accordion-header" data-toggle="collapse" data-target="#collapse-01">
                                <h3>100% Fluid Responsive - Fits any device perfectly</h3>
                            </div>
                            <div class="collapse show" id="collapse-01" data-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum laudantium eum
                                        ipsum ipsam quae vitae aspernatur autem unde praesentium? Ea incidunt animi quod
                                        amet voluptates deserunt? Esse voluptatum sint enim.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <div class="accordion-header collapsed" data-toggle="collapse" data-target="#collapse-02">
                                <h3>Clean Code</h3>
                            </div>
                            <div class="collapse" id="collapse-02" data-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum laudantium eum
                                        ipsum ipsam quae vitae aspernatur autem unde praesentium? Ea incidunt animi quod
                                        amet voluptates deserunt? Esse voluptatum sint enim.</p>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <div class="accordion-header collapsed" data-toggle="collapse" data-target="#collapse-03">
                                <h3>Flat, modern and clean Design</h3>
                            </div>
                            <div class="collapse" id="collapse-03" data-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum laudantium eum
                                        ipsum ipsam quae vitae aspernatur autem unde praesentium? Ea incidunt animi quod
                                        amet voluptates deserunt? Esse voluptatum sint enim.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header collapsed" data-toggle="collapse" data-target="#collapse-04">
                                <h3>Custom Font support</h3>
                            </div>
                            <div class="collapse" id="collapse-04" data-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum laudantium eum
                                        ipsum ipsam quae vitae aspernatur autem unde praesentium? Ea incidunt animi quod
                                        amet voluptates deserunt? Esse voluptatum sint enim.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Faq section End -->

    <!-- Contact section start -->
    <section class="contact section-padding" data-scroll-index="5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2>Get in <span>Touch</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="contact-info">
                        <h3>For Any Queries an d Support</h3>
                        <div class="contact-info-item">
                            <i class="fas fa-location-arrow"></i>
                            <h4>Company Location</h4>
                            <p>199 xyz mm, mmmmmm</p>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <h4>Write to us at </h4>
                            <p>info@gmail.com</p>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <h4>Call us on</h4>
                            <p>
                                <?php echo $phone; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="contact-form">
                        <form method="post" action="php/contact.php">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Your Name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Your Email" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" name="phone" placeholder="Your Phone" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" name="subject" placeholder="Your subject"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea placeholder="Your message" name="message"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-2">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact section End -->


    <!-- Footer section start -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h3>About Us</h3>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et nihil, quasi provident saepe,
                            omnis commodi voluptatibus fugiat eaque fuga eveniet inventore </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h3>Company</h3>
                        <ul>
                            <li>
                                <a href="#">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#">Term & condition</a>
                            </li>
                            <li>
                                <a href="#">lates blogs</a>
                            </li>
                            <li>
                                <a href="#">App services</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h3>Quik LInks</h3>
                        <ul>
                            <li>
                                <a href="#" data-scroll-nav="0">Home</a>
                            </li>
                            <li>
                                <a href="#" data-scroll-nav="1">Fearutes</a>
                            </li>
                            <li>
                                <a href="#" data-scroll-nav="2">Screenshots</a>
                            </li>

                            <li>
                                <a href="#" data-scroll-nav="3">Testimonials</a>
                            </li>
                            <li>
                                <a href="#" data-scroll-nav="4">Pricing</a>
                            </li>
                            <li>
                                <a href="#" data-scroll-nav="5">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h3>Social Pages</h3>
                        <ul>
                            <li>
                                <a href="#">Facebook</a>
                            </li>
                            <li>
                                <a href="#">Twitter</a>
                            </li>
                            <li>
                                <a href="#">instegram</a>
                            </li>
                            <li>
                                <a href="#">Linkedin</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright-text">&copy;2021 @saadany</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer section End -->

    <!-- Toggle Theme start ligt and dark mode  -->
    <div class="toggle-theme">
        <i class="fas">

        </i>
    </div>
    <!-- Toggle Theme End ligt and dark mode-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js1/owl.carousel.min.js"></script>
    <script src="js1/scrollIt.min.js"></script>
    <script src="js1/script.js"></script>


</body>

</html>