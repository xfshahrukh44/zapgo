<?php include "include/header.php" ?>
<?php include "include/menu.php" ?>




<section class="rent-sec about-inner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="equipment">
                    <h1><span class="d-block">Sign In</span></h1>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="sec-free-acc">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="sec-text-form-free-acc">
                    <h4>
                        Sign In to your ZapGO Rentals
                    </h4>
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
                           
                            <input class="form-check-input position-static" type="checkbox" name="blankRadio"
                                id="blankRadio1" value="option1" aria-label="...">
                                <label for="">Remember me </label>
                        </div>
                        
                        <div class="form-group">
                            <label><a href="#" >forgot password</a> </label>
                        </div>

                        <div class="acc-free-sign-up-button">
                        <button class="btn blue-custom" type="submit">Sign in</button>
                        </div>

                    </form>
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




<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="week-and-day">
                    <div class="h-p d-flex">
                        <div>
                            <img src="images/prosucts-inner/2.png" class="img-fluid" alt="">
                        </div>
                        <p> 1. Quantity. </p>
                        <div class="quantity">
                            <a href="#" class=" minus-1"><span>-</span></a>
                            <input name="quantity" type="text" class="quantity__input input-1" readonly="" value="0">
                            <a href="#" class=" plus-1"><span>+</span></a>
                        </div>
                    </div>

                    <ul>
                        <li>
                            <h5>1Day <span>$58 </span></h5>
                        </li>
                        <li>
                            <h5>1Week <span>$225 </span></h5>
                        </li>
                        <li>
                            <h5>1Month <span>$710 </span></h5>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="modal-footer">
                <a href="checkout-page.php" class="btn blue-custom">Checkout</a>
                <a href="product.php" class="btn blue-custom">Keep Shoppimg</a>
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


<script src="js/script.js"></script>
<script>
    AOS.init();
</script>
</body>

</html>