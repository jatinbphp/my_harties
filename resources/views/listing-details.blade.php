<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing Details</title>
    <script src="{{ URL('assets/plugins/jquery/jquery.min.js')}}"></script>
</head>
<body style="text-align: center;">
    <img src="{{asset('assets/dist/img/logo.png')}}?{{ time() }}">
</body>
<script type="text/javascript">    
$(function(){
    setTimeout(function(){ 
        window.location.href = "mytownonline://mytownonline.app/mtportal/<?php echo $listing->id;?>"; 
    }, 2000);    
});
</script>
</html>