<?php
	require_once 'db_connect.php';

	$sql = "SELECT * FROM `users`;";
	$result = $mysqli->query($sql);
	// print_r($result);

	function calculateAge($birthDate){
		$dob = new DateTime($birthDate);
		$today = new DateTime();
		$age = $today->diff($dob)->y;
		return $age;
	}

	if ($result->num_rows > 0) {
		echo "<h2>Lista użytkowników</h2>";
		echo "<table><tr><th>Id</th><th>Imię</th><th>Email</th><th>Data urodzenia</th><th>Płeć</th><th>Wiek</th><th>Opis</th><th>Utworzono</th></tr>";
		while ($row = $result->fetch_object()) {
			$age = $row->birth_date ? calculateAge($row->birth_date) : '-';
			echo <<<USER
				<tr>
					<td>$row->id</td>
					<td>$row->name</td>
					<td>$row->email</td>
					<td>$row->birth_date</td>
					<td>$row->gender</td>
					<td>$age</td>
					<td>$row->description</td>
					<td>$row->created_at</td>
				</tr>
USER;
		}
		echo "</table>";
	}else{
		echo "Brak danych w tabeli użytkowników";
	}
	$mysqli->close();
