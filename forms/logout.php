<?php
session_start();

session_unset(); 
session_destroy(); 

header("Location: /laundry/index.html"); 
exit();

