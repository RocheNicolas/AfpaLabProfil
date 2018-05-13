<?php

// SESSION
session_start();
// Destroy the cookies
setcookie('courriel_utilisateur','',time()-3600);
setcookie('mdp_utilisateur','',time()-3600);
// Destroy the session
session_destroy();
// Redirects the user to the home page
header('Location: route.php?page=accueil');
// Make the page inaccessible
exit;