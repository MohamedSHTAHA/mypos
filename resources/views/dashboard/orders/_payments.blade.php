<script>
var wpwlOptions = {
     locale: "{{ LaravelLocalization::getCurrentLocale() }}",
    style:"card",
    onReady:function(){
    $(".wpwl-brand-SOFORTUEBERWEISUNG").click(function(){$(".wpwl-form-onlineTransfer-SOFORTUEBERWEISUNG .wpwl-group-country, .wpwl-form-onlineTransfer-SOFORTUEBERWEISUNG .wpwl-wrapper-submit").slideToggle()});
   $(".wpwl-brand-GIROPAY").click(function(){$(".wpwl-form-onlineTransfer-GIROPAY .wpwl-group-accountBankBic, .wpwl-form-onlineTransfer-GIROPAY .wpwl-wrapper-submit").slideToggle()})
   }
}

</script>
<style>

.wpwl-form {background:#f8f8f8}
.wpwl-label-brand {display:none}
.wpwl-form-card { background: #f8f8f8; border:0px} 
.wpwl-control, input.wpwl-control{
    background: white;
    border: 1px solid #ddd;
    box-shadow: none;
    border-radius: 0px;
    font-family:"ff-good-headline-web-pro-con", "Pathway Gothic One", sans-serif;
    text-transform:none;
    padding:10px;
    font-size: 18px;
    height: 50px;
}
.input-text:focus, input[type=text]:focus, input[type=tel]:focus, input[type=url]:focus, input[type=password]:focus, input[type=search]:focus, textarea:focus {background-color: white;}
.wpwl-brand-SOFORTUEBERWEISUNG, .wpwl-brand-GIROPAY{cursor:pointer}
.wpwl-brand, .wpwl-img { margin: 0 0 0 auto;}


</style>

<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$responseData['id']}}"></script>
<!--<form action="{{route('dashboard.orders.checkoutfinal',$id)}}" class="paymentWidgets" data-brands="VISA MASTER MADA PAYPAL"></form>-->
<form action="{{route('dashboard.orders.checkoutfinal',$id)}}" class="paymentWidgets" data-brands="VISA MASTER PAYPAL SOFORTUEBERWEISUNG GIROPAY"></form>