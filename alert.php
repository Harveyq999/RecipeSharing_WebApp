<?php
  if(isset($_SESSION['message_display'])){
    echo'<div id="messageAlert" class="alert bg-gray alert-dismissible fade show text-center" style="border-color: #494949 !important; padding: .1rem; border: 2px solid; border-radius: 5px; line-height: 40px; font-weight: bold;"  role="alert">'.$_SESSION['message_display'].'<button type="button" class="btn-close mx-2 " style="background-color: transparent; border: 0; color:white; font-size:25px; padding-left: 5px;" data-bs-dismiss="alert" aria-label="Close">&times</button
    </div>';
    unset($_SESSION['message_display']);
  }
?>


<?php
  if(isset($_SESSION['message_displayprofile'])){
    echo'<div id="messageAlert" class="alert bg-gray alert-dismissible fade show text-center" style="border-color: #494949 !important; padding: .1rem; border: 2px solid; border-radius: 5px; line-height: 40px; font-weight: bold;"  role="alert">'.$_SESSION['message_displayprofile'].'<button type="button" class="btn-close mx-2 " style="background-color: transparent; border: 0; color:white; font-size:25px; padding-left: 5px;" data-bs-dismiss="alert" aria-label="Close">&times</button
    </div>';
    unset($_SESSION['message_displayprofile']);
  }
?>


<?php
  if(isset($_SESSION['message_display2'])){
    echo'<div id="messageAlert" class="alert bg-gray alert-dismissible fade show text-center" style="border-color: #494949 !important; padding: .1rem; border: 2px solid; border-radius: 5px; line-height: 40px; font-weight: bold;"  role="alert">'.$_SESSION['message_display2'].'<button type="button" class="btn-close mx-2 " style="background-color: transparent; border: 0; color:white; font-size:25px; padding-left: 5px;" data-bs-dismiss="alert" aria-label="Close">&times</button
    </div>';
    unset($_SESSION['message_display2']);
  }
?>


<?php
  if(isset($_SESSION['message_display3'])){
    echo'<div id="messageAlert" class="alert bg-gray alert-dismissible fade show text-center" style="border-color: #494949 !important; padding: .1rem; border: 2px solid; border-radius: 5px; line-height: 40px; font-weight: bold;"  role="alert">'.$_SESSION['message_display3'].'<button type="button" class="btn-close mx-2 " style="background-color: transparent; border: 0; color:white; font-size:25px; padding-left: 5px;" data-bs-dismiss="alert" aria-label="Close">&times</button
    </div>';
    unset($_SESSION['message_display3']);
  }
?>

