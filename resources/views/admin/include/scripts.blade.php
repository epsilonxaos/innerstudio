<!-- BEGIN VENDOR JS-->
<script src={{asset("admin/js/vendors.min.js")}} type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN THEME  JS-->

@if(request()->is('pacientes'))
    {{--<script src={{asset("assets/vendors/tinymce/tinymce.min.js")}} type="text/javascript"></script>--}}
@endif
<script src={{asset("admin/js/plugins.js")}} type="text/javascript"></script>
@if(request()->is('admin/calendario'))
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endif
<!-- END THEME  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->
