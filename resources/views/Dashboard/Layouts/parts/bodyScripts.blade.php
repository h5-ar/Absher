 <!-- BEGIN: Vendor JS-->
 <script src="{{ asset('app-assets/vendors/js/jquery/jquery.min.js') }}"></script>
 <script>
     function getThemeFromSession() {
         var theme = '{{ Session::get('theme') }}';
         return theme;
     }

     function setThemeToSession(theme) {
         $.ajax({
             type: "POST",
             url: "{{ route('set.theme') }}",
             data: {
                 _token: '{{ csrf_token() }}',
                 theme: theme,
             },
         });
     }
 </script>
 <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
 <!-- BEGIN Vendor JS-->

 {{-- select form --}}

 <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>

 {{-- end select form --}}


 <!-- BEGIN: Page Vendor JS-->
 {{-- <script src="{{ asset('app-assets/vendors/js/charts/apexcharts.min.js') }}"></script> --}}
 <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
 <!-- END: Page Vendor JS-->

 <!-- BEGIN: Theme JS-->
 <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
 <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/filepond/filepond.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/filepond/filepond-plugin-image-preview.js') }}"></script>
 <script src="{{ asset('app-assets/js/scripts/filepond/filepond-plugin-file-validate-type.js') }}"></script>
 <!-- END: Theme JS-->

 <!-- BEGIN: Page JS-->
 {{-- <script src="{{ asset('app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script> --}}
 <!-- END: Page JS-->
 <script>
     $(window).on('load', function() {
         if (feather) {
             feather.replace({
                 width: 14,
                 height: 14
             });
         }

     })
     @if ($errors->any())
         toastr['error'](
             '{{ $errors->first() }}',
             '{{ translate('Error') }}', {
                 closeButton: true,
                 tapToDismiss: false,
                 rtl: true
             }
         );
     @endif

     @if (Session::has('successMessage'))
         toastr['success']('', '{{ Session::get('successMessage') }}', {
             closeButton: true,
             tapToDismiss: false,
             rtl: true
         });
     @endif
     @if (Session::has('infoMessage'))
         toastr['info']('', '{{ Session::get('infoMessage') }}', {
             closeButton: true,
             tapToDismiss: false,
             rtl: true
         });
     @endif

     $("#reset-btn").click(function(e) {
         e.preventDefault();
         var inputs = document.querySelectorAll('input');
         $.each(inputs, function(indexInArray, valueOfElement) {
             valueOfElement.value = '';
         });
         @if (app()->getLocale() == 'ar')
             $("form img").attr('src',
                 '{{ asset('app-assets/images/clickToAddAr.png') }}'
             );
         @else
             $("form img").attr('src',
                 '{{ asset('app-assets/images/clickToAddEn.png') }}'
             );
         @endif
     });

     function remove(elment) {
         $(elment).hide(500);
         setTimeout(() => {
             $(elment).remove();
         }, 500);
     }

     function generateId() {
         const timestamp = new Date().getTime();
         const random = Math.floor(Math.random() * 1000000); // Adjust the range as needed
         return `${timestamp}-${random}`;
     }

     function isNumberKey(evt, max = null, maxValue = null) {
         let charCode = (evt.which) ? evt.which : event.keyCode;

         if (charCode > 31 && (charCode < 48 || charCode > 57)) {
             return false;
         }

         if (max !== null && maxValue !== null && evt.target.value > maxValue) {
             $(evt.target).val(maxValue);
             return false;
         }

         if (max !== null && maxValue === null && evt.target.value.length > max - 1)
             return false;


         return true;
     }

     function validateWeightInput(inputValue) {
         let weightPattern = /^(kg|g|l|ml|cm)$/;
         return weightPattern.test(inputValue);
     }

     function errorToast(header = '', message = '') {
         toastr['error'](
             `${message}`,
             `${header}`, {
                 closeButton: true,
                 tapToDismiss: false,
                 rtl: true
             }
         );
     }

     function successToast(header = '', message = '') {
         toastr['success'](`${message}`, `${header}`, {
             closeButton: true,
             tapToDismiss: false,
             rtl: true
         });
     }

     function successToast(header = '', message = '') {
         toastr['info'](`${message}`, `${header}`, {
             closeButton: true,
             tapToDismiss: false,
             rtl: true
         });
     }

     function isEmpty(obj) {
         return Object.keys(obj).length === 0;
     }

     function arrayDiff(arr1, arr2) {
         return arr1.filter(item => !arr2.includes(item));
     }

     @if (asset('') == url()->previous())
         // Add a new entry to the history stack when the page loads
         window.onload = function() {
             history.pushState(null, null, window.location.href);
         };

         // Listen for the popstate event to handle when the user navigates back
         window.onpopstate = function(event) {
             // Replace the current URL in the history stack to prevent going back
             history.pushState(null, null, window.location.href);
         };
     @endif
     $("#switch-lang").click(function(e) {
         $.ajax({
             type: "post",
             url: "{{ route('dashboard.set.lang') }}",
             data: {
                 _token: "{{ csrf_token() }}"
             },
             success: function(response) {
                 window.location.reload();
             }
         });
     });
 </script>
 @stack('scripts')
