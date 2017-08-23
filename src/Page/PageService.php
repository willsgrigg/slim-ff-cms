<?php declare(strict_types=1);

namespace App\Page;

class PageService
{
    public function getRequestBody($request, $page = null)
    {
        if(!$request->getUploadedFiles())
        {
            return $request->getParams();
        }

        $files = $request->getUploadedFiles();

        return $this->handleFileUpload($files, $page);
    }

    private function handleFileUpload($files, $page)
    {
        foreach($files as $key => $file)
        {
            $key = str_replace('_', '.', $key);

            if ($file->getError() === UPLOAD_ERR_OK) {
                $uploadFileName = $file->getClientFilename();

                $pagesPath = PageRepository::PAGES_PATH;

                $file->moveTo("$pagesPath$page/$uploadFileName");

                return [
                    'field' => "$key.src",
                    'value' => $uploadFileName,
                ];
            }
        }
    }
}