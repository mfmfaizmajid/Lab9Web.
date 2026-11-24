<?php
unset($_SESSION['user_logged_in'], $_SESSION['username']);
setFlashMessage('success', 'Anda telah keluar dari sesi Administrator.');
header('Location: index.php?page=dashboard');
exit;
?>
