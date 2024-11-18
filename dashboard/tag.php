<?php

include 'includes/tag.php';
include 'bolts/header.php';

global $website_tag, $website_tag_new, $facebook_pixel_id, $analytics_tracking_id, $snapchat_pixel_id, $adwords_tracking_id, $bing_tag_id;
?>

<div class="inner-wrapper">
    <?php
    $select = 'Site Tag';
    include 'bolts/sidebar.php';
    ?>
    <script>
        var site_tag = true;
    </script>

    <section role="main" class="content-body">
        <header class="page-header">
        </header>

        <!-- start: website tag -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <form method="GET" class="form-inline">
                        <label class="mb-2 mr-sm-2 mb-sm-0 ml-md" for="dealership"> Dealership </label>
                        &nbsp; &nbsp;
                        <select class="form-control populate mb-2 mr-sm-2 mb-sm-0" name="dealership" id="dealership" data-plugin-selectTwo>
                            <?php
                            if ($user['type'] == 'a') {
                                foreach ($all_dealerships as $dealer) {
                                    $selected = ($user['cron_name'] == $dealer['dealership']) ? ' selected' : '';
                            ?>
                                    <option value="<?=$dealer['dealership']?>"<?=$selected?>><?=$dealer['dealership']?></option>
                            <?php
                                }
                            } else {
                                ?>
                                <option value="<?=$user['cron_name']?>"<?=' selected'?>><?=$user['cron_name']?> </option>
                            <?php
                            }
                            ?>
                        </select>
                        &nbsp; &nbsp;
                        <button class="btn btn-primary ml-md">Submit</button>
                    </form>
                </div>
            </div>
		</div>
		<div class="row">
            <div class="col-md-6 col-lg-12">
                <section class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Website Tag</h4>
                                <i>Place it anywhere in the website preferably before the closing &lt;/body&gt; tag</i>
                                <div>
                                    <pre class="col-lg-12"><code><?= trim(htmlspecialchars($website_tag_new)) ?></code></pre>
                                </div>

                                <div>
                                    <button type="button" class="btn btn-default m-xs"><?= $tag_text ?></button>
                                    <button type="button" class="btn btn-default m-xs"><?= $last_loaded ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer class="panel-footer clearfix">
                        <form method="POST" class="form-horizontal form-bordered">
                            <input type="hidden" name="action" value="clear_tag_cache"/>
                            <input type="hidden" name="cron_name" value="<?=$user['cron_name'];?>"/>
                            <button class="btn btn-primary pull-right">Clear Tag Cache</button>
                        </form>
                    </footer>
                </section>
            </div>
        </div>

        <!-- start: Feed links -->
        <div class="row">
            <div class="col-md-6 col-lg-12">
                <section class="panel panel-info">
					<div class="panel-heading">
						<h2 class="panel-title">Facebook Feeds Option</h2>
						<i>Link for facebook feeds</i>
					</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4>Retargeting Feeds</h4>

                                <div>
                                    <table class="table">

										<tr>
											<td colspan="3">
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>" target="_blank">All Car</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new" target="_blank">All New Car</a>
											</td>
											<td colspan="2">
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used" target="_blank">All Used Car</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>" target="_blank">All Desktop</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&format=mobile" target="_blank">All Mobile</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&format=instagram" target="_blank">All Instagram</a>
											</td>
										</tr>
                                        <tr>
                                            <td>
                                                <a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new" target="_blank">New Desktop</a>
                                            </td>
                                            <td>
                                                <a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new&format=mobile" target="_blank">New Mobile</a>
                                            </td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new&format=instagram" target="_blank">New Instagram</a>
											</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used" target="_blank">Used Desktop</a>
                                            </td>
                                            <td>
                                                <a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used&format=mobile" target="_blank">Used Mobile</a>
                                            </td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used&format=instagram" target="_blank">Used Instagram</a>
											</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

							<div class="col-lg-6">
								<h4>Look-Alike Feeds</h4>

								<div>
									<table class="table">
										<tr>
											<td colspan="3">
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&feed_type=lookalike" target="_blank">All Car</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new&feed_type=lookalike" target="_blank">All New Car</a>
											</td>
											<td colspan="2">
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used&feed_type=lookalike" target="_blank">All Used Car</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&feed_type=lookalike" target="_blank">All Desktop</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&format=mobile&feed_type=lookalike" target="_blank">All Mobile</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&format=instagram&feed_type=lookalike" target="_blank">All Instagram</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new&feed_type=lookalike" target="_blank">New Desktop</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new&format=mobile&feed_type=lookalike" target="_blank">New Mobile</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new&format=instagram&feed_type=lookalike" target="_blank">New Instagram</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used&feed_type=lookalike" target="_blank">Used Desktop</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used&format=mobile&feed_type=lookalike" target="_blank">Used Mobile</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used&format=instagram&feed_type=lookalike" target="_blank">Used Instagram</a>
											</td>
										</tr>
									</table>
										</div>
							</div>

							<div class="col-lg-6">
								<h4>AIA Feeds</h4>

								<div>
									<table class="table">

										<tr>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>" target="_blank">All Car</a>
											</td>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new" target="_blank">All New Car</a>
											</td>
											<td colspan="2">
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used" target="_blank">All Used Car</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>" target="_blank">All Desktop</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&format=mobile" target="_blank">All Mobile</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&format=instagram" target="_blank">All Instagram</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new" target="_blank">New Desktop</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new&format=mobile" target="_blank">New Mobile</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=new&format=instagram" target="_blank">New Instagram</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used" target="_blank">Used Desktop</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used&format=mobile" target="_blank">Used Mobile</a>
											</td>
											<td>
												<a href="https://tm.smedia.ca/aia-feed.php?view=live&dealership=<?=$user['cron_name']?>&type=used&format=instagram" target="_blank">Used Instagram</a>
											</td>
										</tr>
										</tr>
									</table>
								</div>
							</div>
						</div>

					</div>
                </section>
            </div>
        </div>
    </section>
</div>

<?php
include 'bolts/footer.php';
