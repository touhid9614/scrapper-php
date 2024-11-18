<!DOCTYPE html>
<html>
    <head>
        <title>AdSync :: Tag Status Checker</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
        
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="assets/css/tag-checker.css" />
        <script type="text/javascript" src="assets/js/tag-checker.js"></script>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Dealership</th>
                        <th>Domain</th>
                        <th>Tag Installed</th>
                        <th>Banner Installed</th>
                        <th>Phone Tracker</th>
                        <th>Conversion Tracker</th>
                    </tr>
                </thead>
                <tbody class="list-body">
                </tbody>
            </table>
        </div>
        
        <div class="overlay">
            <div class="loading-section">
                <div class="loading-anim"></div>
                <div class="loading-text">Loading . . .</div>
            </div>
        </div>
    </body>
</html>