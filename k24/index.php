<?php
  $file = "dane.txt";
  $text = "WSB Merito";

  file_put_contents($file, $text);
  
  if (file_exists($file)) {
    $contents = nl2br(file_get_contents($file));

    echo <<< DATA
    <strong>Zawartość pliku:</strong>
    $contents
DATA;
  } else {
    echo "Plik nie istnieje";
  }