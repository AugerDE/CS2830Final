<?php
  include("../../secure/connect.php");

  function checkInput($val){
    $val = (isset($val) ? htmlspecialchars($val) : NULL);
    return $val;
  }

  function getNotes(){
    return "<div class='notes'>
              <input class='noteTitle' type='text' spellcheck='false' /><button class='btn btn-sm btn-danger closeNote'></button>
              <textarea spellcheck='false'></textarea>
            </div>
            <div class='notes'>
              <input class='noteTitle' type='text' spellcheck='false' />
              <textarea spellcheck='false'></textarea>
            </div>
            <div class='notes'>
              <input class='noteTitle' type='text' spellcheck='false' />
              <textarea spellcheck='false'></textarea>
            </div>";
  }
?>
