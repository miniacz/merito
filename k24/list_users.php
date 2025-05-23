<?php
	require_once 'db_connect.php';

	$selectedUser = null;

	$sql = "SELECT * FROM `users`;";
	$result = $mysqli->query($sql);
	// print_r($result);

	function calculateAge($birthDate){
		$dob = new DateTime($birthDate);
		$today = new DateTime();
		$age = $today->diff($dob)->y;
		return $age;
	}

	if (isset($_GET['user_id'])) {
		$id = (int) $_GET['user_id'];
		$stmt = $mysqli->prepare("Select * FROM users WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$selectedUser = $stmt->get_result()->fetch_object();
		$stmt->close();
	}
	?>
	
	<!DOCTYPE html>
	<html lang="pl">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lista użytkowników</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
			<div class="alert alert-success">
				&#x2705; Użytkownik został pomyślnie usunięty
			</div>
		<?php endif; ?>
		<h2>Lista użytkowników</h2>
		<table>
			<tr>
				<th>ID</th><th>Imię</th><th>Email</th><th>Data urodzenia</th><th>Płeć</th><th>Wiek</th><th>Opis</th><th>Utworzono</th><th>Akcje</th>
			</tr>
			<?php while($row = $result->fetch_object()): ?>
				<tr>
					<td><?= $row->id ?></td>
					<td><?= htmlspecialchars($row->name) ?></td>
					<td><?= htmlspecialchars($row->email) ?></td>
					<td><?= $row->birth_date ?></td>
					<td><?= $row->gender ?></td>
					<td><?= calculateAge($row->birth_date) ?></td>
					<td><?= nl2br(htmlspecialchars($row->description)) ?></td>
					<td><?= $row->created_at ?></td>
					<td>
						<a class="detail-link" href="?user_id=<?= $row->id ?>">Szczegóły</a>
						<a class="delete-link" href="delete_user.php?id=<?= $row->id ?>" onclick="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">Usuń</a>
					</td>
				</tr>
			<?php endwhile; ?>
		</table>

		
		<?php if ($selectedUser): ?>
			<div class="details">
				<h3>Szczegóły użytkownika: <?= htmlspecialchars($selectedUser->name) ?></h3>
				<p>Email: <?= htmlspecialchars($selectedUser->email) ?></p>
				<p>Data urodzenia: <?= $selectedUser->birth_date ?></p>
				<p>Wiek: <?= calculateAge($selectedUser->birth_date) ?></p>
				<p>Płeć: <?= $selectedUser->gender ?></p>
				<p>Opis: <?= nl2br(htmlspecialchars($selectedUser->description)) ?></p>
				<p>Utworzono: <?= $selectedUser->created_at ?></p>

				<h4>Adresy użytkownika</h4>
				<ul>
					<?php 
						$stmt = $mysqli->prepare("SELECT * FROM addresses WHERE user_id = ?");
						$stmt->bind_param("i", $selectedUser->id);
						$stmt->execute();
						$addresses = $stmt->get_result();
						if ($addresses->num_rows > 0):
							while($addr = $addresses->fetch_object()):
								?>
								<li>
									<?= htmlspecialchars($addr->type) ?>:
									<?= htmlspecialchars($addr->street) ?>,
									<?= htmlspecialchars($addr->postal_code) ?>,
									<?= htmlspecialchars($addr->city) ?>,
									<?= htmlspecialchars($addr->country) ?>
								</li>
							<?php endwhile;
						else: 
							echo "Brak adresu";
						endif;
						$mysqli->close();
					?>
				</ul>
				<p><a href="list_users.php">Ukryj szczegóły</a></p>
			</div>
		<?php endif; ?>
		<p><a href="add_user.php"><span style="color:purple; font-family: Arial, sans-serif;">&#x2795;</span>Dodaj nowego użytkownika</a></p>

	</body>
	</html>