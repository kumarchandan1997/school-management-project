
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

<script>
    $msg = $('#msg').val();
    if($msg !='' && $msg != undefined)
    {

            iziToast.success({
            message: $msg,
            position: "topCenter"
        })

    }
    $msg=$('#error').val();
    if($msg !='' && $msg != undefined)
    {
            iziToast.error({
            message: $msg,
            position: "topCenter"

        });
    }
  </script>

<script src="{{ asset('student/parsley/parsley.min.js') }}"></script>
<script src="{{ asset('student/timeTable.js') }}"></script>
<script src="{{ asset('student/app.js') }}"></script>
</body>
</html>