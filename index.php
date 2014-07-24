<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
        <style>
            .strong{font-weight:700;} label.label-control{padding-top:6px;} body,html{height:100%;} #wrap{min-height:100%;height:auto!important;margin:0 auto -60px;} #push,#footer{height:60px;} #footer{line-height:60px;background:#f0f0f0;}
        </style>
    </head>
    <body>
        <a href="https://github.com/nkahoang/wpplugintemplate"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>
        <div id="wrap">
            <div class="container">
                <br/>
                <div class="jumbotron">
                    <h1><span class="strong">Wordpress</span> custom plugin creator</h1>
                    <p>This is a simple tool to create the base for your custom plugin</p>
                </div>

                <form action="download.php" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 label-control">
                            Plugin Name
                        </label>
                        <div class="col-sm-10 input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-file"></span>
                            </span>
                            <input class="form-control" type="text" name="name" value="My custom plugin">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 label-control">
                            Plugin Prefix
                        </label>
                        <div class="col-sm-10 input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-tag"></span>
                            </span>
                            <input type="text" name="prefix" class="form-control" value="Custom">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 label-control">
                            Plugin URI
                        </label>
                        <div class="col-sm-10 input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-link"></span>
                            </span>
                            <input type="text" name="uri" class="form-control" value="www.webmarketingexperts.com.au">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <div class="col-sm-offset-2">
                            <button type="submit" class="btn btn-primary">
                                <span class="glyphicon glyphicon-flash"></span>&emsp;
                                <span class="strong">Build my plugin</span>
                            </button>
                            <button type="reset" class="btn btn-default">
                                <span class="glyphicon glyphicon-repeat"></span>
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="push"></div>
        </div>
        <div id="footer">
            <div class="container">
                <p class="text-muted credit">Original author <a href="https://github.com/nkahoang">Hoang Nguyen</a> | Licensed under <a href="http://www.gnu.org/licenses/gpl-2.0.html">GPL v2</a></p>
            </div>
        </div>
        <!-- Latest compiled and minified JavaScript -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>