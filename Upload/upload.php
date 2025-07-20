<?php
class Upload
{
    private $file;
    private $targetDir;
    private $maxSize;
    private $allowedTypes;

    public function __construct($file, $targetDir = "public/uploads/", $maxSize = 2000000, $allowedTypes = ['jpg', 'jpeg', 'png'])
    {
        $this->file = $file;
        $this->targetDir = $targetDir;
        $this->maxSize = $maxSize;
        $this->allowedTypes = $allowedTypes;
    }

    public function uploadFile()
    {
        $fileName = pathinfo($this->file['name'], PATHINFO_FILENAME);
        $fileExt = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
        $fileSize = $this->file['size'];
        $fileTmp = $this->file['tmp_name'];

        if (!in_array($fileExt, $this->allowedTypes)) return ['status' => false, 'message' => 'Invalid file type.'];
        if ($fileSize > $this->maxSize) return ['status' => false, 'message' => 'File too large.'];

        if (!file_exists($this->targetDir)) mkdir($this->targetDir, 0777, true);

        $newName = uniqid() . '.' . $fileExt;
        $destination = $this->targetDir . $newName;

        if (move_uploaded_file($fileTmp, $destination)) {
            return ['status' => true, 'file_name' => $newName];
        }
        return ['status' => false, 'message' => 'Upload failed.'];
    }
}