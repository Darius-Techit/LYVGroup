
<?php

// $page = isset($_GET['page']) ? $_GET['page'] : 'home';
// $file = "pages/$page.php";

// if (file_exists($file)) {
//     include $file;
// } else {
//     include "pages/404.php";
// }

include "layouts/header.php";

include "pages/home.php";

include "layouts/footer.php";

?>