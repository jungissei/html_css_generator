<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HTML・CSSコードジェネレーター</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <style>
    code{
      background-color: #ccc;
      border: 1px solid #666;
      padding: 1em;
      border-radius: 30px;
      display: block;
    }

    .code_row{
      display: flex;
      justify-content: space-between;
    }
    .code_col{
      width: 48%;
    }
  </style>
</head>
<body>
<div>http://localhost:8084/generate_html/backup_files</div>
<div>alt + w：コードをwrapできる</div>
<div>Ctrl + Shift + F</div>


<?php

include("functions.php");

$lines = file("data.csv");


//クラス名関連
$prefix = create_prefix($lines);
$arr_suffix = create_arr_suffix($lines);
$arr_suffix = form_arr_suffix($arr_suffix);

$code = create_inner_tags($arr_suffix, $prefix);

//layer1
$code = create_tag($prefix, $code);
?>


<div class="code_row">
<div class="code_col">
<h2>HTML</h2>
<section id="copy">
<pre><code>
<?php echo htmlspecialchars($code, ENT_QUOTES); ?>
</code></pre>
</section>

<section id="code">
<?php echo $code; ?>
</section>


</div>
<div class="code_col">
<h2>CSS</h2>
<section id="css">
<pre><code id="css_code">

</code></pre>
</section>

</div>
</div>




<script type="text/javascript">
  var row = $(".<?php echo $prefix; ?>>[class*=\"<?php echo $prefix; ?>_row\"]");
  var css = $("#css_code");
  var css_code = "";

  //prefix要素
  css_code += `.<?php echo $prefix; ?>{\n}\n`;

  //suffixのrowとcolの要素
  for(var i = 0; i <= row.length-1; i++){
    var obj_row = $(row[i]);
    var class_name_row = obj_row.attr("class");
    css_code += `.${class_name_row}{\n`;

    var obj_col = $(`.${class_name_row}>[class*=\"<?php echo $prefix; ?>_col\"]`);

    if(obj_col.length >= 1){
      css_code += `  .<?php echo $prefix; ?>_col{\n`;
    }

    for(var j = 0; j <= obj_col.length-1; j++){
      var nth_num = j+1;
      css_code += `    &:nth-child(${nth_num}){\n    }\n`;

    }

    if(obj_col.length >= 1){
      css_code += `  }\n`;
    }

    css_code += `}\n`;
  }


  //suffixの各要素
  var obj_elem = $(`.<?php echo $prefix; ?> div:not([class*="row"])`);
  console.log(obj_elem);
  for(var i = 0; i <= obj_elem.length-1; i++){
    var elem = $(obj_elem[i]);
    var class_name_elem = elem.attr("class");
    if(class_name_elem.indexOf("col") === -1){
      css_code += `.${class_name_elem}{\n}\n`;
    }
  }

  css.append(css_code);
</script>
</body>
</html>


