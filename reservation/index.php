<?php
session_start();
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");

// Récupérer les réservations
$sql = "SELECT * FROM reservations";
$statement = $connect->prepare($sql);

if ($statement->execute()) {
    $reservations = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Erreur lors de la récupération des réservations.";
    $reservations = [];
}
?>

<h2 class="mt-4 text-center text-primary fw-bold">GESTION DES RÉSERVATIONS</h2>
<div class="container my-5">
    <div class="card shadow-lg" style="max-width: 1100px; margin: 0 auto;">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Liste des réservations</h4>
            <a href="create.php" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle"></i> Ajouter
            </a>
        </div>
        <div class="card-body bg-light">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date de Réservation</th>
                        <th scope="col">Client</th>
                        <th scope="col">Utilisateur</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($reservations) > 0) {
                        foreach ($reservations as $reservation) {
                            // Récupérer le client
                            $sql = "SELECT * FROM clients WHERE id = :client_id";
                            $statementclient = $connect->prepare($sql);
                            $statementclient->bindValue(':client_id', $reservation['client_id'], PDO::PARAM_INT);
                            $statementclient->execute();
                            $client = $statementclient->fetch(PDO::FETCH_ASSOC);

                            // Récupérer l'utilisateur
                            $sql = "SELECT * FROM utilisateurs WHERE id = :utilisateur_id";
                            $statementuser = $connect->prepare($sql);
                            $statementuser->bindValue(':utilisateur_id', $reservation['utilisateur_id'], PDO::PARAM_INT);
                            $statementuser->execute();
                            $utilisateur = $statementuser->fetch(PDO::FETCH_ASSOC);

                            // Récupérer la destination
                            $sql = "SELECT * FROM destinations WHERE id = :destination_id";
                            $statementDestination = $connect->prepare($sql);
                            $statementDestination->bindValue(':destination_id', $reservation['destination_id'], PDO::PARAM_INT);
                            $statementDestination->execute();
                            $destination = $statementDestination->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr class="text-center">
                        <th scope="row"><?= htmlspecialchars($reservation["id"]) ?></th>
                        <td><?= htmlspecialchars($reservation["date_reservation"]) ?></td>
                        <td><?= htmlspecialchars($client["nom"]) ?></td>
                        <td>
                            <?php
                            if ($utilisateur) {
                                echo '<span class="badge bg-primary">' . htmlspecialchars($utilisateur["nom"]) . '</span>';
                            } else if (!empty($reservation["utilisateur_id"])) {
                                echo "<span class='text-danger'>Utilisateur introuvable (ID: " . htmlspecialchars($reservation["utilisateur_id"]) . ")</span>";
                            } else {
                                echo "<span class='text-danger'>Aucun utilisateur associé</span>";
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars($destination["ville"]) ?></td>
                        <td>
                            <a href="show.php?id=<?= $reservation["id"] ?>" class="btn btn-outline-primary btn-sm" title="Détails">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="edit.php?id=<?= $reservation["id"] ?>" class="btn btn-outline-info btn-sm" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="delete.php?id=<?= $reservation["id"] ?>" class="btn btn-outline-danger btn-sm" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette réservation ?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Aucune réservation trouvée.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN (à placer dans le <head> de ton layout principal si pas déjà fait) -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> -->

<?php include('../include/footer.php'); ?>
