<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getNotes(){
    return "<div class='notes'>
              <input type='text' />
              <textarea spellcheck='false'></textarea>
            </div>";
  }
?>
