<?php

use Illuminate\Http\Request;

/**
 * @param Request $request
 * @param string $key_name
 * @param string $name_directory_storage
 * @return string
 */
function saveFileToStorageDirectory(Request $request, string $key_name, string $name_directory_storage = ""): string
{
    $imageName = time() . '_' . trim(str_replace(" ", "_", $request->file($key_name)->getClientOriginalName()));
    return  DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . $request->file($key_name)->storeAs($name_directory_storage, $imageName, 'public');
}
