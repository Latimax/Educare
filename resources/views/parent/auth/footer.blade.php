
 <!-- jQuery library js -->
 <script src="{{ asset('adminpage/assets/js/lib/jquery-3.7.1.min.js') }}"></script>
 <!-- Bootstrap js -->
 <script src="{{ asset('adminpage/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
 <!-- Apex Chart js -->
 <!-- <script src="{{ asset('adminpage/assets/js/lib/apexcharts.min.js') }}"></script> -->
 <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
 <!-- Data Table js -->
 <script src="{{ asset('adminpage/assets/js/lib/dataTables.min.js') }}"></script>
 <!-- Iconify Font js -->
 <script src="{{ asset('adminpage/assets/js/lib/iconify-icon.min.js') }}"></script>
 <!-- jQuery UI js -->
 <script src="{{ asset('adminpage/assets/js/lib/jquery-ui.min.js') }}"></script>
 <!-- Vector Map js -->
 <script src="{{ asset('adminpage/assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
 <script src="{{ asset('adminpage/assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
 <!-- Popup js -->
 <script src="{{ asset('adminpage/assets/js/lib/magnifc-popup.min.js') }}"></script>
 <!-- Slick Slider js -->
 <script src="{{ asset('adminpage/assets/js/lib/slick.min.js') }}"></script>
 <!-- prism js -->
 <script src="{{ asset('adminpage/assets/js/lib/prism.js') }}"></script>
 <!-- file upload js -->
 <script src="{{ asset('adminpage/assets/js/lib/file-upload.js') }}"></script>
 <!-- audioplayer -->
 <script src="{{ asset('adminpage/assets/js/lib/audioplayer.js') }}"></script>
 
 <!-- main js -->
 <script src="{{ asset('adminpage/assets/js/app.js') }}"></script>

<script>
     // ================== Password Show Hide Js Start ==========
     function initializePasswordToggle(toggleSelector) {
       $(toggleSelector).on('click', function() {
           $(this).toggleClass("ri-eye-off-line");
           var input = $($(this).attr("data-toggle"));
           if (input.attr("type") === "password") {
               input.attr("type", "text");
           } else {
               input.attr("type", "password");
           }
       });
   }
   // Call the function
   initializePasswordToggle('.toggle-password');
 // ========================= Password Show Hide Js End ===========================
</script>
