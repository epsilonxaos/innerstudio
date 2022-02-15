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
@if(str_contains(url()->current(), '/compra/paquete/'))
<script type="text/javascript" src="https://pay.conekta.com/v1.0/js/conekta-checkout.min.js"></script>
@endif

@if(session()->has('message_reset'))
    <script type="text/javascript">
        $('#mdReset').modal('show');
    </script>
@endif
