<!DOCTYPE html>
<html>
    <head>
        <title>AdSync :: Car List Editor</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
        
        <link rel="stylesheet" href="assets/css/linkedlist.css" />
        <script src="assets/js/linkedlist.js"></script>
        
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="assets/css/carlist-editor.css" />
        <script type="text/javascript" src="assets/js/carlist-editor.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div class="container clearfix">
            <div class="left-container">
                <h3>Unmatched Titles</h3>
                <div class="left-inner-container">
                    
                </div>
            </div>
            <div class="right-container">
                <h3>Car Details</h3>
                <div class="right-inner-container">
                    <div class="top-container">
                        <iframe id="car-details" src=""></iframe>
                    </div>
                    <div class="bottom-container">
                        <table>
                            <tr>
                                <th>Year</th>
                                <th>Make</th>
                                <th>Model</th>
                                <th><a id="page-open-link" href="#" target="_blank">Open URL</a></th>
                            </tr>
                            <tr>
                                <td><input type="text" id="year-field" name="year"/></td>
                                <td><input type="text" id="make-field" name="make"/></td>
                                <td><input type="text" id="model-field" name="model"/></td>
                                <td><button id="insert-button">Insert</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overlay">
            <div class="loading-section">
                <div class="loading-anim"></div>
                <div class="loading-text">Loading . . .</div>
            </div>
        </div>
    </body>
</html>
