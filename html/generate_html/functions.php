<?php


function create_tag($class_name, $tag_inner = "")
{
  $tag_start = "<div class=\"{$class_name}\">";
  $tag_end = "</div>";

  if(empty($tag_inner))
    return "{$tag_start}\n{$tag_end}\n";

  return "{$tag_start}\n{$tag_inner}\n{$tag_end}\n";
}


function create_prefix($lines){
  return explode(',',$lines[0])[0];
}

function create_arr_suffix($lines){
  for($i = 1; $i <= count($lines)-1; $i++){

    $data_arr = explode(',',$lines[$i]);

    foreach($data_arr as $key => $data){

      if(empty($data))
        continue;

      if(
        $data === ""
        ||$data === " "
        ||$data === "\n"
        ||$data === "\r"
        ||$data === "\r\n"
        ||$data === 0
        ||empty($data)
        ||is_null($data)
      )
        continue;

      $filtered_data_arr[$i][] = $data;
    }
  }

  return $filtered_data_arr;
}

function form_arr_suffix($arr_suffix){
  $row = -1;
  foreach($arr_suffix as $key => $arr){
    foreach($arr as $suffix){
      if($suffix === "row"){
        $row ++;
        $col = -1;
        continue;
      }

      if($suffix === "col"){
        $col ++;
        continue;
      }

      if($col >= 0){
        $formed_arr_suffix[$row][$col][] = $suffix;
        continue;
      }

      $formed_arr_suffix[$row][] = $suffix;
    }
  }
  return $formed_arr_suffix;
}


function create_inner_tags($arr_suffix, $prefix){
  $code_row = "";
  $row_num = 0;
  foreach($arr_suffix as $key => $row){
    $code_inner = "";
    foreach($row as $row_key => $row_value){
      if(is_array($row_value)){
        $code_col = "";
        foreach($row_value as $elem_key => $elem_value){
          $code_col .= create_tag("{$prefix}_{$elem_value}");
        }
        $code_inner .= create_tag("{$prefix}_col", $code_col);
      }else{
        $code_row .= create_tag("{$prefix}_{$row_value}");
      }
    }

    if($code_inner){
      $code_row .= create_tag("{$prefix}_row{$row_num}", $code_inner);
      $row_num ++;
    }
  }

  return $code_row;
}
