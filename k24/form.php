<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notatki z plikiem</title>
</head>
<body>
  <h2>&#x1F4DD; Dodaj notatkę</h2>
  <form method="post">
    <label>Treść notatki:</label>
    <textarea name="note" id="" cols="40" rows="5" placeholder="Wpisz coś..."></textarea><br><br>

    <label>Kategorie:</label>
    <select name="category">
      <option value="Praca">Praca</option>
      <option value="Prywatne">Prywatne</option>
      <option value="Inne">Inne</option>
    </select><br><br>

    <label>Ważność:</label>
    <div>
      <input type="radio" name="importance" value="Ważne" checked>Ważne
      <input type="radio" name="importance" value="Nieważne" required>Nieważne
    </div><br><br>
    <input type="submit" value="Zapisz do pliku">
  </form>
    <?php
      $filename = "notes.txt";

      chmod($filename, 0777);

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $note = trim($_POST["note"]);
        $category = $_POST["category"] ?? 'Brak';
        $importance = $_POST["importance"] ?? 'Brak';

        if (!empty($note)) {
          $timestamp = date("Y-m-d H:i:s");
          $entry = "[$timestamp] Kategoria: $category | Ważność: $importance" . PHP_EOL;
          $entry .= "Notatka: $note" . PHP_EOL;
          $entry .= str_repeat("-", 50) . PHP_EOL;

          file_put_contents($filename, $entry, FILE_APPEND);

          echo "<p style='color: green';>&#x2705; Notatka została zapisana</p>";
        } else {
          echo "<p style='color: red';>&#x26A0;&#xFE0F;Treść notatki nie może być pusta</p>";
        }

        if (file_exists($filename)) {
          echo "<h3>&#x1F4C2; Zawartość pliku:</h3><pre>";
          echo htmlspecialchars(file_get_contents($filename));
          echo "</pre>";
        } else {
          echo "<p>Plik nie został utworzony<?p>";
        }
      } 
    ?>

</body>
</html>