<?php

// hapus session
session_start();
session_destroy();

echo "<script>location.href = '/pengaduan/index.php'</script>";

