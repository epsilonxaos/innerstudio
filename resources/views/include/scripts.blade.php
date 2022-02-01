<script>
    var PATH = "{{url('/')}}";
</script>

<script src="{{asset('js/app.js')}}"></script>

@if(session()->has('message_login'))
    <script type="text/javascript">
    console.log(session()->get('message_login'))
        $('#mdLogin').modal('show');
    </script>
@endif

@if(session()->has('message_reset'))
    <script type="text/javascript">
        $('#mdReset').modal('show');
    </script>
@endif
