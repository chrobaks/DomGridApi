<?php

class AppRequest extends BaseRequest
{
    protected static function setPdfPreview ()
    {
        // Get request route param
        $requestParam = AppRoute::getUrlList();

        // Check $requestParam has 3 values and last is pdf filename
        if (count($requestParam) > 2 && file_exists(INVOICE_DISPATCH_PATH.$requestParam[2])) {

            $pdf = file_get_contents(INVOICE_DISPATCH_PATH.$requestParam[2]);
       
            header('Content-Type: application/pdf');
            header('Cache-Control: public, must-revalidate, max-age=0');
            header('Pragma: public');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
            header('Content-Length: '.strlen($pdf));
            header('Content-Disposition: inline; filename="'.basename($requestParam[2]).'";');

            ob_clean(); 
            flush(); 

            echo $pdf;
        }
    }
}
