<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $baslik; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo YONETIM_SABLON; ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo YONETIM_SABLON; ?>/dist/css/adminlte.min.css">
  <script>
    function resimGoster(input){
        var dosya = $("input[type=file]").get(0).files[0];
 
        if(dosya){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#onizlemeResim").attr("src", reader.result);
            }
 
            reader.readAsDataURL(dosya);
        }
    }
  </script>
    
</head>