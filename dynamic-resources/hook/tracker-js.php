<?php

header('Content-type: text/javascript; charset=UTF-8');

$adwords_dir = dirname(dirname(__DIR__)) . "/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'tag_db_connect.php';

$url = isset($_GET['ref'])?$_GET['ref']:$_SERVER['HTTP_REFERER'];

$vl_regx    = '/vl=(?<loader>[^&\\s#]+)/';
$vl         = null;

if(preg_match($vl_regx, $url, $match))
{
    $vl = $match['loader'];
}

$domain     = GetDomain($url);
$trackers   = get_meta('goal_tracker', $domain);

if($vl == 'smedia-js-hook-editor'):

?>

jQuery.fn.extend({
    getPath: function () {
        var path, node = this;
        while (node.length) {
            var realNode = node[0], name = realNode.localName;
            if (!name) break;
            name = name.toLowerCase();

            var parent = node.parent();

            var sameTagSiblings = parent.children(name);
            if (sameTagSiblings.length > 1) { 
                allSiblings = parent.children();
                var index = allSiblings.index(realNode) + 1;
                if (index > 1) {
                    name += ':nth-child(' + index + ')';
                }
            }

            path = name + (path ? '>' + path : '');
            node = parent;
        }

        return path;
    }
});

(function($){
    $(document).ready(function(){
        
        $('a').click(function(e){
            e.preventDefault();
            url = $(this).prop('href', '#');
        });
        
        $('input[type="image"],input[type="submit"],input[type="button"],button').click(function(e){
            e.preventDefault();
            path = $(this).getPath();
            window.parent.postMessage(path, "*");
        });
        
    });
})(jQuery);

<?php elseif($trackers): ?>

(function($){
    $(document).ready(function(){
        <?php
            foreach($trackers as $path => $statement)
            {
                $statement = str_replace("\'", "'", $statement);
                if(!endsWith($statement, ';'))
                {
                    $statement .= ';';
                }
                echo "$('$path').click(function(){\n\t$statement\n});\n";
            }
        ?>
    });
})(jQuery);

<?php endif;