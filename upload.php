<!DOCTYPE html>
<html>
    <head>
        <script>
            function _(el) {
                return document.getElementById(el);
            }
            function uploadFile() {
                var file = _("file1").files[0];
                if (file.size > 5000000) {
                    _("status").innerHTML = "Sorry, your file is too large.";
                    exit();
                }
                var formdata = new FormData();
                formdata.append("file1", file);
                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                ajax.open("POST", "file_upload_parser.php");
                ajax.send(formdata);
            }
            function progressHandler(event) {
                var percent = (event.loaded / event.total) * 100;
                _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
            }
            function completeHandler(event) {
                _("status").innerHTML = event.target.responseText;
                setTimeout(function () {
                    location.reload()
                }, 1500);
            }
            function errorHandler(event) {
                _("status").innerHTML = "Upload Failed";
            }
            function abortHandler(event) {
                _("status").innerHTML = "Upload Aborted";
            }
        </script>
        <!-- Bootstrap core CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <!-- Static navbar -->
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">PHP File Uploader</a>
                </div>
            </div>
        </div>


        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <form class="well" action="showHint" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="file">Select a file to upload</label>
                            <input type="file" name="file1" id="file1">
                            <p class="help-block">Only jpg,jpeg,png and gif file with maximum size of 5 MB is allowed.</p>
                            <h3 id="status"></h3>
                        </div>
                        <input type="button" class="btn btn-lg btn-primary" value="Upload" onclick="uploadFile()">
                    </form>
                </div>
            </div>

            <div class="row">
                <?php
                //scan "uploads" folder and display them accordingly
                $folder = "uploads";
                $results = scandir('uploads');
                foreach ($results as $result) {
                    if ($result === '.' or $result === '..')
                        continue;
                    $path = $folder . '/' . $result;
                    if (is_file($path)) {
                        echo '
                <div class="col-md-3">
                    <div class="thumbnail">
                        <img src="' . $folder . '/' . $result . '" alt="...">
                            <div class="caption text-center">
                            <div class="btn-group">
							<a href="' . $path . '" class="btn btn-primary btn-xs" role="button">Open</a>
							<a href="remove.php?name=' . $result . '" class="btn btn-danger btn-xs" role="button">Remove</a>
							</div>
                        </div>
                    </div>
                </div>';
                    }
                }
                ?>
            </div>

        </div> <!-- /container -->
    </body>
</html>