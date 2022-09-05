<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Janelas</title>
<link href="css/bootstrap-3.4.1.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<div role="tabpanel">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home1" data-toggle="tab" role="tab" aria-controls="tab1">Tab 1</a></li>
    <li role="presentation"><a href="#paneTwo1" data-toggle="tab" role="tab" aria-controls="tab2">Tab 2</a></li>
    <li role="presentation" class="dropdown"><a href="#" id="tabDropOne1" class="dropdown-toggle" data-toggle="dropdown" role="tab" aria-controls="tab3" aria-haspopup="true" aria-expanded="false">Tab 3 Dropdown<span class="caret"></span></a>
      <ul class="dropdown-menu" aria-labelledby="tabDropOne1">
        <li><a href="#tabDropDownOne1" tabindex="-1" data-toggle="tab">Dropdown Link 1</a></li>
        <li><a href="#tabDropDownTwo1" tabindex="-1" data-toggle="tab">Dropdown Link 2</a></li>
      </ul>
    </li>
  </ul>
  <div id="tabContent1" class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home1">
      <p>Content in <b>Tab Panel 1</b></p>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="paneTwo1">
      <p>Content 2</p>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="tabDropDownOne1">
      <p>Dropdown content#1</p>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="tabDropDownTwo1">
      <p>Dropdown content#2 </p>
    </div>
  </div>
</div>
<script src="js/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap-3.4.1.js"></script>
</body>
</html>