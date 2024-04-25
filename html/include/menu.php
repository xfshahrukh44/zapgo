<header>
     <div class="container">
          <div class="row">
               <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                         <div class="container-fluid">
                              <a class="navbar-brand" id="logo-main" href="index.php"><img src="images/logo_1.png"
                                        class="img-fluid" alt=""></a>
                              <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                   data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                   aria-expanded="false" aria-label="Toggle navigation">
                                   <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                   <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                        <li class="nav-item <?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<?= ($activePage == 'index') ? 'active' : ''; ?>">
                                             <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                                        </li>
                                        <li class="nav-item <?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<?= ($activePage == 'product') ? 'active' : ''; ?>">
                                             <a class="nav-link" href="product.php"> All Products</a>
                                        </li>
                                        <li class="nav-item <?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<?= ($activePage == 'contact-us') ? 'active' : ''; ?>">
                                             <a class="nav-link" href="contact-us.php">
                                                  Contact Us
                                             </a>
                                        </li>
                                        <li class="nav-item <?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<?= ($activePage == 'about') ? 'active' : ''; ?>">
                                             <a class="nav-link" href="about.php">About Us</a>
                                        </li>
                                   </ul>
                                   <form class="d-flex custom-c">
                                        <a class="btn blue-custom black-btn" href="sign-in.php">Sign in</a>
                                        <a class="btn blue-custom" href="free-account.php">Sign up</a>
                                        <a href="#"><img src="images/12.png" class="img-fluid" alt=""></a>
                                   </form>
                              </div>
                         </div>
                    </nav>
               </div>
          </div>
     </div>
</header>