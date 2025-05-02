<?php

require_once 'CMS.php';
require_once '../../config.php';

class Novice extends CMS {


    

    public function add(array $data) {
        $title = $this->sanitizeInput($data['title']);
        $content = $this->sanitizeInput($data['content']);
        $shown = (int) $data['shown'];
        $id_admin = 1;

        if (!$this->validateSQL($title)) {
            return "Invalid input detected!";
        }

        $stmt = $conn->prepare("INSERT INTO news (title, content, shown, id_admin) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $content, $shown, $id_admin]);
    }

    public function change(int $id, array $data) {
        $title = $this->sanitizeInput($data['title']);
        $content = $this->sanitizeInput($data['content']);
        $shown = (int) $data['shown'];

        if (!$this->validateSQL($title)) {
            return "Invalid input detected!";
        }

        $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, shown = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $shown, $id]);
    }

    public function delete(int $id) {
        $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
        return $stmt->execute([$id]);
    }
}


?>