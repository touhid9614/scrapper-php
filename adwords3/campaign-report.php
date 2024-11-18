<?php
    require_once('utils.php');

    if(!isset($_GET['data']) || !isset($_GET['cron_name'])) die("Error");

    $cron_name = $_GET['cron_name'];
    $data = unserialize(base64_decode($_GET['data']));
    $top_cars = unserialize(base64_decode($_GET['top_cars']));
    $on15 = isset($_GET['on15'])?$_GET['on15']:false;
    if($on15 == 'false') $on15 = false;
    $custom = isset($_GET['custom'])?$_GET['custom']:false;
    if($custom == 'false') $custom = false;

    $last_index = count($data) - 1;

    $currentMonth = date('F');
    $lastMonth = Date('F, Y', strtotime($currentMonth . " last month"));
    
    if($on15)
    {
        if(date('j') > 14)
        {
            $lastMonth = Date('F', strtotime($currentMonth . " last month"));
            $lastMonth = $lastMonth . ' - ' . date('F, Y'); 
        }
        else
        {
            $lastLastMonth = Date('F', strtotime(Date('F', strtotime($currentMonth . " last month")) . " last month"));
            $lastMonth = $lastLastMonth . ' - ' . $lastMonth; 
        }
    }

    if($data[$last_index]['Impressions'] == "0" && $data[$last_index]['clicks'] == "0") die();

    $pattern = $cron_name . '_';

    $selectedCampaigns = array();
    $total_impressions = 0;
    $total_clicks = 0;
    
    $y_selectedCampaigns = array();
    $y_total_impressions = 0;
    $y_total_clicks = 0;

    foreach ($data as $campaign)
    {
        if((startsWith($campaign['Campaign'], $pattern) || $custom) && !endsWith($campaign['Campaign'], '--'))
        {
            if(stripos($campaign['Campaign'], 'youtube') === false)
            {
                $total_impressions += $campaign['Impressions'];
                $total_clicks += $campaign['Clicks'];
                $selectedCampaigns[] = $campaign;
            }
            else
            {
                $y_total_impressions += $campaign['Impressions'];
                $y_total_clicks += $campaign['Clicks'];
                $y_selectedCampaigns[] = $campaign;
            }
        }
    }
?>
<br><u></u>

    <div marginwidth="0" marginheight="0" style="margin:0;padding:0;background-color:#363636;width:100%!important">
    	<center>
        	<table style="margin:0;padding:0;background-color:#363636;height:100%!important;width:100%!important" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            	<tbody><tr>
                	<td style="height:100%!important;margin:0!important;padding:0!important;width:100%!important;border-collapse:collapse" align="center" valign="top">

                    	
                        <table style="background-color:#ffffff" border="0" cellpadding="10" cellspacing="0" width="100%">
                        	<tbody><tr>
                            	<td style="border-collapse:collapse" align="center" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="560">
                                    	<tbody><tr>
                                            <td style="padding-right:20px;border-collapse:collapse;color:#707070;font-family:Helvetica;font-size:11px;line-height:100%;text-align:left" valign="top">Check out the performance of your Adwords Campaigns.</td>

                                            
                                            <td style="border-collapse:collapse;color:#707070;font-family:Helvetica;font-size:11px;line-height:100%;text-align:left" valign="top" width="200">
                                                <!-- Email not displaying correctly?<br><a href="http://us6.campaign-archive2.com/?u=f79940d8ce3b529c9aa486257&amp;id=a5dcb18255&amp;e=89da14222f" style="color:#26abe2;font-weight:normal;text-decoration:none" target="_blank">View it in your browser</a-->.
                                            </td>
                                            
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    	
                        <table style="background-color:#eeeeee" border="0" cellpadding="40" cellspacing="0" width="100%">
                        	<tbody><tr>
                            	<td style="padding-bottom:20px;border-collapse:collapse" align="center" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="560">
                                    	<tbody><tr>
                                            <td style="border-collapse:collapse;color:#363636;font-family:Helvetica;font-size:20px;font-weight:bold;line-height:100%;text-align:left;vertical-align:top">
                                                <img src="https://smedia.ca/smedia/wp-content/uploads/2014/05/logo1.png" alt="smedia.ca" border="0" height="80" width="200">
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    	

                    	
                        <table style="background-color:#eeeeee" border="0" cellpadding="20" cellspacing="0" width="100%">
                        	<tbody><tr>
                            	<td style="border-collapse:collapse" align="center" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="560">
                                        <tbody><tr>
                                                <td style="padding-bottom:20px;border-collapse:collapse;color:#505050;font-family:Helvetica;font-size:12px;line-height:150%;text-align:left" valign="top"><span style="font-size:24px">Your&nbsp;Monthly&nbsp;Statistics&nbsp;for&nbsp;<wbr><?php echo $lastMonth?>&nbsp;</span></td>

                                        </tr>
                                    	<tr>
                                        	<td colspan="2" style="padding-bottom:20px;border-collapse:collapse" align="center">
                                            	
                                                    <table style="background-color:#ffffff;border:1px solid #e5e5e5" border="0" cellpadding="20" cellspacing="0" width="560">
                                                    <tbody><tr>
                                                        <td style="border-collapse:collapse" align="left" valign="top">
                                                        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                    <thead style="background-color: #eee; text-align: center;">
                                                                        <tr>
                                                                            <th style="padding: 4px 0px; width:40%">Campaign Name</th>
                                                                            <th style="padding: 4px 0px; width:30%">Impressions</th>
                                                                            <th style="padding: 4px 0px; width:30%">Clicks</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="text-align: center;">
                                                                        <?php foreach ($selectedCampaigns as $value)
                                                                        {
                                                                            if(!($value['Impressions'] == "0" && $value['Clicks'] == "0"))
                                                                            {
                                                                            ?>
                                                                        <tr>
                                                                            <td style="padding: 4px 0px;"><?php echo $value['Campaign']?></td>
                                                                            <td style="padding: 4px 0px;"><?php echo $value['Impressions']?></td>
                                                                            <td style="padding: 4px 0px;"><?php echo $value['Clicks']?></td>
                                                                        </tr>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                    <tfoot style="background-color: #444; color:#fff; text-align: center;">
                                                                        <tr>
                                                                            <th style="padding: 4px 0px;">Total</th>
                                                                            <th style="padding: 4px 0px;"><?php echo $total_impressions?></th>
                                                                            <th style="padding: 4px 0px;"><?php echo $total_clicks?></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                        </td>
                                                    </tr>

                                                    <?php if(count($y_selectedCampaigns) > 0): ?>
                                                    <tr>
                                                        <td style="border-collapse:collapse" align="left" valign="top">
                                                            <h3>Youtube Campaigns</h3>
                                                        	<table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                    <thead style="background-color: #eee; text-align: center;">
                                                                        <tr>
                                                                            <th style="padding: 4px 0px; width:40%">Campaign Name</th>
                                                                            <th style="padding: 4px 0px; width:30%">Impressions</th>
                                                                            <th style="padding: 4px 0px; width:30%">Clicks</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="text-align: center;">
                                                                        <?php foreach ($y_selectedCampaigns as $value)
                                                                        {
                                                                            if(!($value['Impressions'] == "0" && $value['Clicks'] == "0"))
                                                                            {
                                                                            ?>
                                                                        <tr>
                                                                            <td style="padding: 4px 0px;"><?php echo $value['Campaign']?></td>
                                                                            <td style="padding: 4px 0px;"><?php echo $value['Impressions']?></td>
                                                                            <td style="padding: 4px 0px;"><?php echo $value['Clicks']?></td>
                                                                        </tr>
                                                                        <?php }
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                    <tfoot style="background-color: #444; color:#fff; text-align: center;">
                                                                        <tr>
                                                                            <th style="padding: 4px 0px;">Total</th>
                                                                            <th style="padding: 4px 0px;"><?php echo $y_total_impressions?></th>
                                                                            <th style="padding: 4px 0px;"><?php echo $y_total_clicks?></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>

    <?php if(count($top_cars['new']) > 0){?>
    <tr>
        <td style="border-collapse:collapse" align="left" valign="top">
            <h3>Top New Cars</h3>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead style="background-color: #eee; text-align: center;">
                        <tr>
                            <th style="padding: 4px 0px; width:60%">Car</th>
                            <th style="padding: 4px 0px; width:40%">Impressions</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <?php foreach ($top_cars['new'] as $value){?>
                        <tr>
                            <td style="padding: 4px 0px;"><?php echo $value['year'] . ' ' . $value['make'] . ' ' . $value['model'] ?></td>
                            <td style="padding: 4px 0px;"><?php echo $value['impressions']?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                    <tfoot style="background-color: #444; color:#fff; text-align: center;">
                        <tr>
                            <th style="padding: 4px 0px;"><span>&nbsp;</span></th>
                            <th style="padding: 4px 0px;"><span>&nbsp;</span></th>
                        </tr>
                    </tfoot>
                </table>
        </td>
    </tr>
    <?php }?>
    <?php if(count($top_cars['used']) > 0){?>
    <tr>
        <td style="border-collapse:collapse" align="left" valign="top">
            <h3>Top Used Cars</h3>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead style="background-color: #eee; text-align: center;">
                        <tr>
                            <th style="padding: 4px 0px; width:60%">Car</th>
                            <th style="padding: 4px 0px; width:40%">Impressions</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <?php foreach ($top_cars['used'] as $value){?>
                        <tr>
                            <td style="padding: 4px 0px;"><?php echo $value['year'] . ' ' . $value['make'] . ' ' . $value['model'] ?></td>
                            <td style="padding: 4px 0px;"><?php echo $value['impressions']?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                    <tfoot style="background-color: #444; color:#fff; text-align: center;">
                        <tr>
                            <th style="padding: 4px 0px;"><span>&nbsp;</span></th>
                            <th style="padding: 4px 0px;"><span>&nbsp;</span></th>
                        </tr>
                    </tfoot>
                </table>
        </td>
    </tr>
    <?php }?>
                                                    
                                               
                                                </tbody></table>
                                                <img src="https://ci4.googleusercontent.com/proxy/Zz7ul0YHMoZj-kxk7NibFWbYBK_GsXZ8uFncQAzEsFgZqdgXGVJa89VgpyGhK5wv4uNpaQeGO8_Q4eeJrcDsAXMomsUxWJjUx78IigrTXAYNVv4bYgHCRu5aK4SzPqkWwnH0yoD1yQ=s0-d-e1-ft#http://gallery.mailchimp.com/27aac8a65e64c994c4416d6b8/images/coupon_shadow_b.png" style="display:block;border:0;min-height:auto;line-height:100%;outline:none;text-decoration:none" height="15" width="560">
                                                
                                                </td>
                                        </tr>
                                        <tr>
                                        	<td style="padding-bottom:20px;border-collapse:collapse" align="center" valign="top">
                                            	<table border="0" cellpadding="0" cellspacing="0">
                                                	<tbody><tr>
                                                        <td style="padding-right:25px;border-collapse:collapse;color:#707070;font-family:Helvetica;font-size:13px;line-height:150%;text-align:left" valign="top" width="170">

                                                        	
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    	

                    	
                        <table style="border-top:0" border="0" cellpadding="20" cellspacing="0" width="100%">
                        	<tbody><tr>
                            	<td style="border-collapse:collapse" align="center" valign="top">
                                	<table border="0" cellpadding="0" cellspacing="0" width="560">
                                    	<tbody><tr>
                                            <td style="padding-right:20px;border-collapse:collapse;color:#909090;font-family:Helvetica;font-size:11px;line-height:125%;text-align:left" valign="top">
                                                <em>Copyright © 2015 sMedia.ca, All rights reserved.</em>
                                                <br>
                                                You are our valued client, thanks for your business.
                                                <br>
                                                <br>
                                                <strong>Our mailing address is:</strong>
                                                <br>
                                                <div><span>sMedia.ca</span><div><div>755 Broad Street, Regina, SK, Canada</div><span>Regina</span>, <span>SK</span>  <span>S4R 8H2</span> <div>Canada</div></div>

                                            </div></td>
                                            <td style="border-collapse:collapse;color:#909090;font-family:Helvetica;font-size:11px;line-height:125%;text-align:left" valign="top" width="200"></td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    	

                    </td>
                </tr>
            </tbody></table>
        </center>