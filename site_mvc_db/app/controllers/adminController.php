<?php
require_once __DIR__ . '/../controllers/authController.php';
require_once __DIR__ . '/../models/peintureModel.php';
require_once __DIR__ . '/../models/coutureModel.php';
require_once __DIR__ . '/../models/evenementModel.php';

function adminHandleImageUpload(array $data) {
    if (empty($_FILES['image_file']) || $_FILES['image_file']['error'] === UPLOAD_ERR_NO_FILE) {
        return $data;
    }

    if ($_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
        return $data;
    }

    $tmpPath = $_FILES['image_file']['tmp_name'];
    $imageInfo = getimagesize($tmpPath);
    if ($imageInfo === false) {
        return $data;
    }

    $extensions = [
        IMAGETYPE_JPEG => 'jpg',
        IMAGETYPE_PNG => 'png',
        IMAGETYPE_GIF => 'gif',
        IMAGETYPE_WEBP => 'webp'
    ];
    $imageType = $imageInfo[2] ?? null;
    if (!isset($extensions[$imageType])) {
        return $data;
    }
    $extension = $extensions[$imageType];

    $uploadDir = __DIR__ . '/../../storage/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    $filename = 'upload_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
    $destination = $uploadDir . '/' . $filename;

    if (move_uploaded_file($tmpPath, $destination)) {
        $data['image'] = 'uploads/' . $filename;
        $data['media_original_name'] = $_FILES['image_file']['name'] ?? $filename;
        $data['media_extension'] = $extension;
        $data['media_mime_type'] = $imageInfo['mime'] ?? null;
        $data['media_size_bytes'] = $_FILES['image_file']['size'] ?? null;
        $data['media_width'] = $imageInfo[0] ?? null;
        $data['media_height'] = $imageInfo[1] ?? null;
    }

    return $data;
}

function admin() {
    requireAdmin();
    $peintures = getPeintures();
    require __DIR__ . '/../views/admin.php';
}

function adminAddPeinture(array $data) {
    requireAdmin();
    $data = adminHandleImageUpload($data);
    $data['author_id'] = currentAdminId();
    addPeinture($data);
    header('Location: /site_mvc_db/public/admin');
    exit;
}

function adminDeletePeinture(int $id) {
    requireAdmin();
    deletePeinture($id);
    header('Location: /site_mvc_db/public/admin');
    exit;
}

function adminUpdatePeinture(array $data) {
    requireAdmin();
    $data = adminHandleImageUpload($data);
    $data['author_id'] = currentAdminId();
    $id = $data['id'] ?? null;
    if ($id) {
        updatePeinture((int)$id, $data);
    }
    header('Location: /site_mvc_db/public/admin');
    exit;
}

function adminCoutures() {
    requireAdmin();
    $coutures = getCoutures();
    require __DIR__ . '/../views/admin_coutures.php';
}

function adminAddCouture(array $data) {
    requireAdmin();
    $data = adminHandleImageUpload($data);
    $data['author_id'] = currentAdminId();
    addCouture($data);
    header('Location: /site_mvc_db/public/admin/coutures');
    exit;
}

function adminDeleteCouture(int $id) {
    requireAdmin();
    deleteCouture($id);
    header('Location: /site_mvc_db/public/admin/coutures');
    exit;
}

function adminUpdateCouture(array $data) {
    requireAdmin();
    $data = adminHandleImageUpload($data);
    $data['author_id'] = currentAdminId();
    $id = $data['id'] ?? null;
    if ($id) {
        updateCouture((int)$id, $data);
    }
    header('Location: /site_mvc_db/public/admin/coutures');
    exit;
}

function adminEvenements() {
    requireAdmin();
    $evenements = getEvenements();
    require __DIR__ . '/../views/admin_evenements.php';
}

function adminAddEvenement(array $data) {
    requireAdmin();
    $data = adminHandleImageUpload($data);
    $data['author_id'] = currentAdminId();
    addEvenement($data);
    header('Location: /site_mvc_db/public/admin/evenements');
    exit;
}

function adminDeleteEvenement(int $id) {
    requireAdmin();
    deleteEvenement($id);
    header('Location: /site_mvc_db/public/admin/evenements');
    exit;
}

function adminUpdateEvenement(array $data) {
    requireAdmin();
    $data = adminHandleImageUpload($data);
    $data['author_id'] = currentAdminId();
    $id = $data['id'] ?? null;
    if ($id) {
        updateEvenement((int)$id, $data);
    }
    header('Location: /site_mvc_db/public/admin/evenements');
    exit;
}
