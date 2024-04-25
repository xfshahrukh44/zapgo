<?php include "include/header.php" ?>
<?php include "include/menu.php" ?>

<section class="check-sec">
     <div class="container-fluid">
          <div class="row">
               <div class="col-lg-6">
                    <div class="check-form-s">
                         <div class="check-form-p">
                              <h1>Checkout</h1>
                         </div>
                         <div class="main-check-one">
                              <div class="order-check">
                                   <span>1</span>
                                   <h4>Order details</h4>
                              </div>

                              <div class="tabs-sign">
                                   <ul id="myTabs" class="nav nav-pills nav-justified" role="tablist" data-tabs="tabs">
                                        <li>
                                             <a data-toggle="tab" href="#Videos">Round-trip
                                                  delivery</a>
                                        </li>
                                   </ul>
                                   <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade fade in active" id="Videos">
                                            <div class="pickup-main">
                                             <div class="second-menu">
                                                  <p>Delivery is only available with a Zap Go Rentals account.</p>
                                                  <a href="#" class="btn blue-custom" data-bs-toggle="modal"
                                                       data-bs-target="#sign_tabs_poppup">Sign in</a>
                                                  <a href="#" class="btn blue-custom" data-bs-toggle="modal"
                                                       data-bs-target="#sign-UP_tabs_poppup">Create a free accounts</a>
                                                  
                                                  
                                             </div>
                                                <div class="btn-last">
                                                                 <a href="your-details.php" class="btn blue-custom">Save
                                                                      and
                                                                      continue </a>
                                                </div>
                                        </div>
                                        </div>
                                      
                                   </div>
                                  
                              </div>
                            
                         </div>
                         <div class="main-chck-two">
                              <span>2</span>
                              <h4>How To Get Your Order</h4>
                         </div>
                         <div class="main-chck-two">
                              <span>3</span>
                              <h4>
Select Delivery And Recovery Time</h4>
                         </div>
                         <div class="main-chck-two">
                              <span>4</span>
                              <h4>Who's Receiving The Order?</h4>
                         </div>
                         <div class="main-chck-two">
                              <span>5</span>
                              <h4>Payment</h4>
                         </div>

                    </div>
               </div>
                <div class="col-lg-6">
                    <div class="side-summary">
                         <div class="summary-main">
                              <h2>Order summary</h2>
                         </div>
                         <div class="drop-menu" id="main-layout">
                              <div class="itme-main">
                                   <div class="main-box">
                                        <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                             class="cmp-RentalReviewList__rentalreviewlist__cartIconStyle"
                                             data-testid="checkout_itemscounts_label">
                                             <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M16.382 14H8.764L7.127 8h12.255l-3 6Zm4.701-7.052A1.986 1.986 0 0 0 19.382 6h-12.8l-.617-2.263A1 1 0 0 0 5 3H2a1 1 0 1 0 0 2h2.236l2.799 10.263A1 1 0 0 0 8 16h9c.379 0 .725-.214.895-.553l3.276-6.553a1.986 1.986 0 0 0-.088-1.946ZM7.75 17.5a1.75 1.75 0 1 0 0 3.5 1.75 1.75 0 0 0 0-3.5ZM16 19.25a1.75 1.75 0 1 1 3.5 0 1.75 1.75 0 0 1-3.5 0Z"
                                                  fill="#0B3E21"></path>
                                        </svg>
                                        <p>1 items</p>
                                   </div>
                                   <span><i class="fa-solid fa-chevron-down"></i></span>
                              </div>
                              <div class="Rentals-bottom" id="main-box-layout">
                                   <h6>Rentals</h6>
                                   <p>Additional Dry Ice Blast Nozzle</p>
                                   <p class="para">Qty: 1 <span>$81
                                             </span></p>
                              </div>
                         </div>
                         <ul>
                              <li>
                                   <p>Taxes and fees will be calculated before rental confirmation.</p>
                              </li>
                              <li>
                                   <p>Rental subtotal<span>$2,315.10</span></p>
                              </li>
                              <li>
                                   <p>Round-trip delivery <span>$410</span></p>
                              </li>
                              <li>
                                   <p>Other fees <span>$86.10</span></p>
                              </li>
                              <li>
                                   <hr class="dropdown-divider">
                              </li>
                              <li>
                                   <p>Subtotal<span>$2,849.56</span></p>
                              </li>
                              <li>
                                   <p>Taxes<span>$252.90</span></p>
                              </li>

                              <li>
                                   <hr class="dropdown-divider">
                              </li>
                              <li>
                                   <p><span>Estimated total</span><span>$3,102.46</span></p>
                              </li>
                         </ul>
                    </div>
               </div>
          </div>
     </div>
</section>

















<div class="bottom-div">
     <div class="container-fluid">
          <div class="row">
               <div class="col-lg-12">
                    <div class="right-reserved">
                         <p>© 2023 Demolink. All Rights Resereved.</p>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="modal fade" id="sign_tabs_poppup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Sign In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">

                    <div class="pickup-main">
                         <form>
                        <div class="form-group">
                            <label for="inputAddress">Email</label>
                            <input type="email" class="form-control" id="inputAddress">
                        </div>


                        <div class="form-group">
                            <label for="inputAddress">password</label>
                            <input type="password" class="form-control" id="inputAddress">
                        </div>



                        <div class="form-check">
                           
                            <input class="form-check-input position-static" type="checkbox" name="blankRadio" id="blankRadio1" value="option1" aria-label="...">
                                <label for="">Remember me </label>
                        </div>
                        
                        <div class="form-group">
                            <label><a href="#">forgot password</a> </label>
                        </div>

                        <div class="acc-free-sign-up-button">
                        <button class="btn blue-custom" type="submit">Sign in</button>
                        </div>

                    </form>
                    </div>
               </div>

          </div>
     </div>
</div>



<div class="modal fade" id="sign-UP_tabs_poppup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Sign In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">

                    <div class="pickup-main">
                         <form>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">First Name</label>
                                <input type="text" class="form-control" id="inputEmail4" fdprocessedid="psjzpg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Last Name </label>
                                <input type="text" class="form-control" id="inputPassword4" fdprocessedid="sivb2d">
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="inputAddress">Email</label>
                            <input type="email" class="form-control" id="inputAddress" fdprocessedid="2uhckb">
                        </div>


                        <div class="form-group">
                            <label for="inputAddress">password</label>
                            <input type="password" class="form-control" id="inputAddress" fdprocessedid="3qd7yj">
                        </div>

                        <div class="para-text-form">
                            <!--<p>Your password must contain at least one uppercase letter (A-Z), one lowercase letter-->
                            <!--    (a-z), one number (0-9), be at least eight characters long and can’t contain your-->
                            <!--    first name, last name, or email.-->
                            <!--</p>-->

                        </div>

                        <div class="form-group">
                            <label for="inputAddress">Company Name* why do we need your company name? ZapGO Rentals
                                only provides.
                                equipment rental to other Business.</label>
                            <input type="text" class="form-control" id="inputAddress" fdprocessedid="gmd40g">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Phone #</label>
                            <input type="text" class="form-control" id="inputAddress" fdprocessedid="buh3ho">
                        </div>

                        <div class="para-text">
                            <p>Address Information:
                            </p>

                        </div>

                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" fdprocessedid="p54q">
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">City</label>
                                <input type="text" class="form-control" id="inputCity" fdprocessedid="zzebrw">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">State</label>
                                <select id="inputState" class="form-control" fdprocessedid="p062zx">
                                    <option selected="">Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputZip">Zip</label>
                                <input type="text" class="form-control" id="inputZip" fdprocessedid="pu5s1p">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <p class="age">Are You 18 +</p>
                                <label for="">Yes</label>
                                <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">
                            </div>
                            <div class="form-check">
                                <label for="">No</label>
                                <input class="form-check-input position-static" type="checkbox" name="blankRadio" id="blankRadio1" value="option1" aria-label="...">
                            </div>
                        </div>

                        <div class="para-text-form">
                            <p>State ID/ Driver’s License*
                            </p>

                            <!--<p>-->
                            <!--    Why do you need my ID information? For safety and security, you must be 18 years or-->
                            <!--    older and have a valid state issued ID or Driver’s License to accept ZapGO Rentals-->
                            <!--    equipment.-->
                            <!--</p>-->
                        </div>

                        <div class="form-group">
                            <label for="inputAddress">Chose State ID/ Driver’s License state*</label>
                            <input type="text" class="form-control" id="inputAddress" fdprocessedid="4r0x3i">
                        </div>

                        <div class="form-group">
                            <label for="inputAddress">State ID/ Driver’s License number*</label>
                            <input type="text" class="form-control" id="inputAddress" fdprocessedid="ovvet9">
                        </div>

                        <div class="form-check">
                                <label for="">Terms </label>
                                <input class="form-check-input position-static" type="checkbox" name="blankRadio" id="blankRadio1" value="option1" aria-label="...">
                            </div>

                            <div class="acc-free-sign-up-button">
                            
                            <button class="btn blue-custom" type="submit" fdprocessedid="f5nq7f">Sign up</button>
                            </div>

                    </form>
                    </div>
               </div>

          </div>
     </div>
</div>



<!-- Optional JavaScript; choose one of the two! -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
     integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
     crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
     integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
     AOS.init();
</script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
<script>
     AOS.init();
</script>
</body>

</html>