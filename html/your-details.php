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
                              <div class="order-check detail-check">
                                   <div class="main-check-div">
                                        <span><i class="fa-solid fa-check"></i></span>
                                        <h4>Order details</h4>
                                   </div>

                                   <div class="f-left">
                                        <a href="checkout-page.php" class="edit-back">Edit <i class="fa-solid fa-pencil"></i></a>

                                   </div>
                              </div>
                              <div class="pickup-main">
                                   <div class="comp-order">
                                        <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <rect x="3" y="3" width="18" height="18" rx="1" stroke="#0B3E21"
                                                  stroke-width="2"></rect>
                                             <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M12 18a1 1 0 0 1-1-1v-5.585l-1.293 1.292a1 1 0 0 1-1.32.083l-.094-.083a1 1 0 0 1-.083-1.32l.083-.094 3-3 .044-.042.068-.055.11-.071.114-.054.105-.035.149-.03L12 8l.075.003.126.017.111.03.111.044.098.052.096.067c.031.025.062.051.09.08l3 3a1 1 0 0 1-1.32 1.497l-.094-.083L13 11.415V17a1 1 0 0 1-1 1Z"
                                                  fill="#0B3E21"></path>
                                             <path fill="#0B3E21" d="M10 2h4v4h-4z"></path>
                                        </svg>
                                        <div class="info-comp">
                                             <h5>In-store Pickup</h5>
                                             <p>10005 Oakton Crossing Court
                                                  Oakton, VA 22124</p>
                                        </div>
                                   </div>
                                   <div class="comp-order">
                                        <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M17 2a1 1 0 0 1 1 1v1h1a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h1V3a1 1 0 0 1 2 0v1h8V3a1 1 0 0 1 1-1Zm3 10H4v7a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-7ZM6 6H5a1 1 0 0 0-1 1v3h16V7a1 1 0 0 0-1-1h-1v1a1 1 0 1 1-2 0V6H8v1a1 1 0 0 1-2 0V6Z"
                                                  fill="#0B3E21"></path>
                                             <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M7 16c0-.55.45-1 1-1s1 .45 1 1-.45 1-1 1-1-.45-1-1Zm5-1h4c.55 0 1 .45 1 1s-.45 1-1 1h-4c-.55 0-1-.45-1-1s.45-1 1-1Z"
                                                  fill="#0B3E21"></path>
                                        </svg>
                                        <div class="info-comp">
                                             <h5>Nov 28, 2023 - Nov 29, 2023</h5>
                                        </div>
                                   </div>
                              </div>

                         </div>
                 <div class="main-check-one">
                              <div class="order-check">
                                   <span>2</span>
                                   <h4>How To Get Your Order</h4>

                              </div>
                              <div class="pickup-main">
                                   <form>
                                        <div class="row">
                                             <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Start Date</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">End Date</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                                             <div class="form-group col-12">
                                                  <label>Address</label>
                                                  <input type="text" name="name" class="form-control" placeholder="2 Stasen place" required="">
                                             </div>
                                             
                                             <div class="form-group col-12">
                                                  <label>Address Line 2</label>
                                                  <input type="text" name="name" class="form-control" placeholder="Optional" required="">
                                             </div>
                                             <div class="form-group col-12">
                                                  <label>City</label>
                                                  <input type="text" name="number" class="form-control" placeholder="Zionsvilla" required="">
                                             </div>
                                             

                                             <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">State</label>
                                <select class="form-control" id="exampleFormControlSelect1">
      <option>Indiana</option>
      <!--<option>Americans</option>-->
      <!--<option>African</option>-->
      <!--<option>European</option>-->
      <option>Others</option>
    </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Zip Code</label>
                                <input type="number" placeholder="46077" class="form-control">
                            </div>
                        </div>

                                             <div class="btn-last">
                                                  <a href="how-to-get-your-order.php" class="btn blue-custom">Save and
                                                       continue </a>
                                             </div>
                                        </div>
                                   </form>
                              </div>
                         </div>
                              </div>
                         <!--</div>-->
                         <div class="main-chck-two">
                              <span>3</span>
                              <h4>Select Delivery And Recovery Time</h4>
                         </div>
                         <!--<div class="main-chck-two">-->
                         <!--     <span>4</span>-->
                         <!--     <h4>Optional plans</h4>-->
                         <!--</div>-->
                         <div class="main-chck-two">
                              <span>4</span>
                              <h4>Who's Receiving The Order?</h4>
                         </div>
                         <div class="main-chck-two">
                              <span>5</span>
                              <h4>Payment</h4>
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