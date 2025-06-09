<?php
session_start();
include("../connexion.php");
include("../include/header.php");
include("../include/sidebar.php");
?>

<?php
    // Récupérer toutes les destinations
    $sql = "SELECT * FROM destinations";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $destinations = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="mt-4 text-center text-primary fw-bold">GESTION DES DESTINATIONS</h2>
<div class="container my-5">
    <div class="card shadow-lg" style="max-width: 1100px; margin: 0 auto;">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Liste des destinations</h4>
            <a href="create.php" class="btn btn-success btn-sm">
                <i class="bi bi-plus-circle"></i> Ajouter
            </a>
        </div>
        <div class="card-body bg-light">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pays</th>
                        <th scope="col">Ville</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Date de Départ</th>
                        <th scope="col">Date de Retour</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($statement->rowCount() > 0) {
                        foreach ($destinations as $destination) {
                    ?>
                    <tr class="text-center">
                        <th scope="row"><?= htmlspecialchars($destination['id']) ?></th>
                        <td><?= htmlspecialchars($destination['pays']) ?></td>
                        <td><?= htmlspecialchars($destination['ville']) ?></td>
                        <td><?= htmlspecialchars($destination['prix']) ?></td>
                        <td><?= htmlspecialchars($destination['date_depart']) ?></td>
                        <td><?= htmlspecialchars($destination['date_retour']) ?></td>
                        <td>
                            <span class="badge bg-<?= $destination['statut'] === 'active' ? 'success' : 'secondary' ?>">
                                <?= htmlspecialchars(ucfirst($destination['statut'])) ?>
                            </span>
                        </td>
                        <td>
                            <a href="show.php?id=<?= $destination['id'] ?>" class="btn btn-outline-primary btn-sm" title="Détails">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="edit.php?id=<?= $destination['id'] ?>" class="btn btn-outline-info btn-sm" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="delete.php?id=<?= $destination['id'] ?>" class="btn btn-outline-danger btn-sm" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer cette destination ?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>Aucune destination trouvée.</td></tr>";
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
