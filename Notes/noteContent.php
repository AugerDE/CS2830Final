<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getNotes(){
    return "<div class='notes'>
              <button class='btn btn-sm btn-danger closeNote'></button>
              <textarea spellcheck='false'></textarea>
            </div>
            <div class='notes'>
              <button class='btn btn-sm btn-danger closeNote'></button>
              <textarea spellcheck='false'></textarea>
            </div>
            <div class='notes'>
              <button class='btn btn-sm btn-danger closeNote'></button>
              <textarea spellcheck='false'></textarea>
            </div>";
  }
?>
