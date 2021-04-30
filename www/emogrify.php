<?php
    require_once __DIR__ . '/vendor/autoload.php';
    //include 'tempdir.php';
    use Pelago\Emogrifier\HtmlProcessor\HtmlNormalizer;
    use Pelago\Emogrifier\CssInliner;
    use Gajus\Dindent\Indenter;
    use Shopping24\CSSBeautifier\CSSBeautifier;

    function emogrifyUpload($upload){

        $uploadedFile = fopen($upload, "r") or die("Unable to open file!");
        $uploadedHTMLcontent = fread($uploadedFile,filesize($upload));
        fclose($uploadedFile);

        createTempFiles($uploadedHTMLcontent);
    }

    function cleanCSS($css){
        $css = str_replace(addslashes('/*@editable*/'), "", $css);
        $css = preg_replace('!/\*.*?\*/!s', '', $css);
        $css = preg_replace('/\n\s*\n/', "\n", $css);

        return $css;
    }

    function zipFiles($fileArr){
        // echo '<pre>'; print_r($fileArr); echo '</pre>';

        $zip = new ZipArchive;
        if ($zip->open('export.zip', ZipArchive::CREATE) === TRUE)
        {
            foreach($fileArr as $filename => $file){
                //echo "path: ".$filename."</br>";
                // "file: ".$file."</br>";
                // Add files to the zip file inside demo_folder
                if(file_exists($file) && is_readable($file)){
                    $zip->addFile($file, $filename);
                }else{
                    //echo "file does not exist";
                }
            }

            // All files are added, so close the zip file.
            if(!$zip->close()){
                //echo "error adding file to zip";
            }

        }else{
            //echo "error creating zip";
        }

        sendZip();
       
    }

    function createTempFiles($uploadedHTMLcontent){

        //pattern match for style tags, $match[1] excludes surrounding html tags, $match[0] includes surrounding html tags
        preg_match('/<style type="text\/css">(.*?)<\/style>/s', $uploadedHTMLcontent, $match);
        $css = cleanCSS($match[1]);
        //remove style tags from html and save to variable
        $html = str_replace($match[0], "", $uploadedHTMLcontent);

        //emogrify css and html
        $emog = CssInliner::fromHtml($uploadedHTMLcontent)->inlineCss()->render();

        //beautifying/formatting
        $indenter = new Indenter;
        $html = $indenter->indent($html);
        $emog = $indenter->indent($emog);
        $css = CSSBeautifier::run($css);

        $fileArr = [];
        $tmpmailchimppath = tempnam(sys_get_temp_dir(), 'mailchimp.html');
        $tmpmailchimp = fopen($tmpmailchimppath, 'w');
        fwrite($tmpmailchimp, $uploadedHTMLcontent);
        $fileArr["mailchimp.html"] = $tmpmailchimppath;

        $tmpcsspath = tempnam(sys_get_temp_dir(), 'export.css');
        $tmpcss = fopen($tmpcsspath, 'w');
        fwrite($tmpcss, $css);
        $fileArr["export.css"] = $tmpcsspath;

        $tmphtmlpath = tempnam(sys_get_temp_dir(), 'export.html');
        $tmphtml = fopen($tmphtmlpath, 'w');
        fwrite($tmphtml, $html);
        $fileArr["export.html"] = $tmphtmlpath;

        $tmpemogpath = tempnam(sys_get_temp_dir(), 'emog.html');
        $tmpemog = fopen($tmpemogpath, 'w');
        fwrite($tmpemog, $emog);
        $fileArr["emog.html"] = $tmpemogpath;

        zipFiles($fileArr);

        fclose($tmpmailchimp);
        fclose($tmpcss);
        fclose($tmphtml);
        fclose($tmpemog);

        //print htmlspecialchars($indenter->indent($html));
        //echo $html;
        
    }

    function sendZip(){
        $filepath = "";
        $filename = "export.zip";
        // http headers for zip downloads
        ob_clean();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"".$filename."\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($filepath.$filename));
        ob_end_flush();
        @readfile($filepath.$filename);
    }

?>