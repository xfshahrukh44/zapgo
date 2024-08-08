<!-- Optional JavaScript; choose one of the two! -->
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->


<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/zebra_datepicker.min.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>

	function editableContent(){
		$('.editable').each(function(){
			$(this).append('<div class="editable-wrapper"><a href="javascript:" class="edit" title="Edit" onclick="editContent(this)"><i class="far fa-edit"></i></a><a href="javascript:" class="update" title="Update" onclick="updateContent(this)"><i class="far fa-share-square"></i></a></div>');
		});
	}

	function editContent(a){
		$(a).closest('.editable').attr('contenteditable', true);;
		$(a).closest('.editable-wrapper').attr('contenteditable', false);
		$(a).closest('.editable').focus();
	}

	function updateContent(a){
		var editableDiv = $(a).closest('.editable');
		var id = $(editableDiv).attr('data-id');
		var keyword = $(editableDiv).attr('data-name');
		var htmlcontent = $(editableDiv).clone(true);
		$(htmlcontent).find('.editable-wrapper').remove();
		sendData(id, keyword, $(htmlcontent).html());
	}

	function sendData(id, keyword, htmlContent){
		console.log(id);
		console.log(keyword);
		console.log(htmlContent);
		$.ajax({
	        url: "update-content",
	        type: "POST",
	        data: {
	            "_token": "{{ csrf_token() }}",
	            id: id,
	            keyword: keyword,
	            htmlContent:htmlContent,
	        },
	        success: function(response) {
	            if (response.status) {
	            	toastr.success(response.message);
	            } else {
	                toastr.success(response.error);
	            }
	        },
	    });
	}

</script>
<script type="text/javascript">
    function validateSearch() {
        var searchInput = document.querySelector('input[name="search"]');
        if (searchInput.value.trim() === "") {
            // Display an error message or handle it in any way you prefer
            toastr.error("Please enter a search query");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>





<script type="text/javascript">

$('#newForm').on('submit',function(e){
  $('#newsresult').html('');
    e.preventDefault();

    let email = $('#newemail').val();

    $.ajax({
      url: "newsletter-submit",
      type:"POST",
      data:{
        "_token": "{{ csrf_token() }}",
        newsletter_email:email
      },
      success:function(response){
        if(response.status){
          $('#newsresult').html("<div class='alert alert-success'>" + response.message + "</div>");
        }
        else{
          $('#newsresult').html("<div class='alert alert-danger'>" + response.message + "</div>");
        }
      },
     });
    });
  </script>


<script type="text/javascript">

$('#contactform').on('submit',function(e){
  //alert('hogaya');
  $('#contactformsresult').html('');
    e.preventDefault();

    $.ajax({
      url: "{{ route('contactUsSubmit')}}",
      type:"POST",
      data: $("#contactform").serialize(),

      success:function(response){
        if(response.status){
          document.getElementById("contactform").reset();
          $('#contactformsresult').html("<div class='alert alert-success'>" + response.message + "</div>");
        }
        else{
          $('#contactformsresult').html("<div class='alert alert-danger'>" + response.message + "</div>");
        }
      },
     });
    });
    </script>
    {{-- @if (Auth::check() && Auth::user()->role == 2) --}}
<script>
    $('#feedbackform').on('submit',function(e){
  //alert('hogaya');
  $('#feedbackformsresult').html('');
    e.preventDefault();
    console.log($("#feedbackform").serialize());

    $.ajax({
      url: "{{ route('feedbackSubmit')}}",
      type:"POST",
      data: $("#feedbackform").serialize(),

      success:function(response){
        if(response.status){
          document.getElementById("feedbackform").reset();
          $('#feedbackformsresult').html("<div class='alert alert-success'>" + response.message + "</div>");
        }
        else{
          $('#feedbackformsresult').html("<div class='alert alert-danger'>" + response.message + "</div>");
        }
      },
     });
    });

</script>
{{-- @endif --}}
<script>
      $(document).ready(function() {
    $(document).on('click', '.plus', function() {
        // Increase the quantity by 1
        var currentQuantity = parseInt($('.count').val()) || 0;
        $('.count').val(currentQuantity + 1);
    });

    $(document).on('click', '.minus', function() {
        // Decrease the quantity by 1, ensuring it doesn't go below 1
        var currentQuantity = parseInt($('.count').val()) || 0;
        $('.count').val(currentQuantity > 1 ? currentQuantity - 1 : 1);
    });
});
</script>


@if (!Auth::guest())
@if(Auth::user()->isAdmin())
<script>editableContent();</script>
@endif
@endif

@if(Session::has('message'))
<script type="text/javascript">
    toastr.success("{{ Session::get('message') }}");
</script>
@endif

<script>
  AOS.init();

//   $('#date-rent-end').click(function(){
//     $('.total-row').slideUp();
//   })

  $('#updateCartCheck').click(function(){
    $('.total-row').slideDown();
  })

  const ratings = document.querySelectorAll(".rating");
const ratingsContainer = document.querySelector(".ratings-container");
const sendBtn = document.querySelector("#send");
const panel = document.querySelector("#panel");
const feedbackTypeInput = document.querySelector("#type");
let selectedRating = "Satisfied";

ratingsContainer.addEventListener("click", (e) => {
  removeActive();
  if (
    e.target.parentNode.classList.contains("rating") &&
    e.target.nextElementSibling
  ) {
    e.target.parentNode.classList.add("active");
    selectedRating = e.target.nextElementSibling.innerHTML;
  } else if (
    e.target.parentNode.classList.contains("rating") &&
    e.target.previousElementSibling
  ) {
    e.target.parentNode.classList.add("active");
    selectedRating = e.target.innerHTML;
  } else if (e.target.classList.contains("rating")) {
    e.target.classList.add("active");
    selectedRating = e.target.children[1].innerText;
  }
  feedbackTypeInput.value = selectedRating;
  console.log(feedbackTypeInput.value);
});

function removeActive() {
  ratings.forEach((rating) => rating.classList.remove("active"));
}

$(document).ready(function () {
  setTimeout(function () {
    $('.loadermain').fadeOut()
  }, 3500)
})

</script>

@php
    $service_dates = App\Http\Traits\HelperTrait::returnFlag(1978);
    $service_dates_arr = explode(", ", $service_dates);
    // $service_date_formatted = date('Y-m-d', strtotime($service_date));
@endphp

@if (!empty($service_dates_arr))
<script>
    $(document).ready(function() {
        var serviceDates = @json($service_dates_arr); // Convert PHP array to JavaScript array
        var currentDate = new Date().toISOString().split('T')[0];

        if (serviceDates.includes(currentDate)) {
            $("#addCart").prop("disabled", true);
            $(".addCart").prop("disabled", true);
            $("#addQuote").prop("disabled", true);
            $("#outofstock").addClass("disabled");
        }
    });
</script>
@endif


