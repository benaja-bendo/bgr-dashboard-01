<?php

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @param Request $request
 * @param string $key_name
 * @param string $name_directory_storage
 * @return string
 */
function saveFileToStorageDirectory(Request $request, string $key_name, string $name_directory_storage = ""): string
{
    $imageName = time() . '_' . trim(str_replace(" ", "_", $request->file($key_name)->getClientOriginalName()));
    return DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . $request->file($key_name)->storeAs($name_directory_storage, $imageName, 'public');
}

/**
 * @param Request $request
 * @param string $key_name
 * @param string $name_directory_storage
 * @return string
 */
function tenantSaveFileToStorageDirectory(Request $request, string $key_name, string $name_directory_storage = ""): string
{
    $imageName = time() . '_' . trim(str_replace(" ", "_", $request->file($key_name)->getClientOriginalName()));
    $tenant = 'tenants' . DIRECTORY_SEPARATOR . tenant()->tenancy_db_name;
    return DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . $tenant . DIRECTORY_SEPARATOR . $request->file($key_name)->storeAs($name_directory_storage, $imageName, 'tenant');
}

/**
 * Get the file url
 *
 * @param string $path
 * @return string
 */
function fileUrl(string $path): string
{
    $tenant = tenant()->tenancy_db_name;
    return url(Storage::url($tenant . DIRECTORY_SEPARATOR . $path));
}


/**
 * @param UploadedFile|null $file
 * @param string $disk
 * @param string|null $fileName
 * @return string|null
 */
function uploadFile(?UploadedFile $file, string $disk = 'public', ?string $fileName = null): ?string
{
    if (!$file) {
        return null;
    }

    if (!$fileName) {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
    }

    return Storage::disk($disk)->putFileAs('', $file, $fileName);
}

/**
 * Récupère l'URL d'un fichier à partir de son chemin.
 *
 * @param string $path Le chemin du fichier dans le disque de stockage.
 * @param string $disk Le disque de stockage où le fichier est stocké. Par défaut, il s'agit du disque 'public'.
 * @return string|null L'URL du fichier si le fichier existe, sinon null.
 */
function getFileUrl(string $path, string $disk = 'public'): ?string
{
    if (!Storage::disk($disk)->exists($path)) {
        return null;
    }

    return url($path);
}
