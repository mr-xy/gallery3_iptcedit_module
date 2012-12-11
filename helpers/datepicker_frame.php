<!doctype html>
<html lang="en" style="overflow:hidden;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>G3 datepicker</title>
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
    <style>
        * {-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;}
        html, body, .demo {
            margin: 0;
            padding: 0;
            border: 0;
            width: 388px;
            height:246px;
        }
    </style>
</head>
<body>
    <script>
    $(function() {
        $('.demo').datepicker({
            onSelect: function(e){
                dateFormat: 
                parent.setDate(e);
            }
        });
        $('.demo').datepicker( "option", "dateFormat", "yymmdd" );
    });
    </script>
    <div class="demo"></div>
</body>
</html>