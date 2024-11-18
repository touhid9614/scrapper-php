<?php

global $dealerships;

$todo = $dealerships['todo'];
$done = $dealerships['done'];

add_script('adwords', 'app/js/adwords.js');
add_script('jquery_ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js');

?>

<div class="col-md-12">
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
            </div>
            <h2 class="panel-title">To Do</h2>
        </header>
        <div class="panel-body">
            <table class="dealerships-container todo-container">
                <tr>
                    <th><?php print_header('id') ?></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Website</th>
                    <th>Dealership</th>
                    <th></th>
                </tr>
                <?php foreach($todo as $dealer) { 
                    $url = $dealer['website'];

                    if($url)
                    {
                        if(!startsWith($url, 'http://') && !startsWith($url, 'https://'))
                        {
                            $url = 'https://' . $url;
                        }

                        $url = "<a href=\"$url\" target=\"_blank\">{$dealer['website']}</a>";
                    }
                    ?>
                <tr id="dealer-<?php echo $dealer['id'] ?>">
                    <td><?php echo $dealer['id'] ?></td>
                    <td><?php echo $dealer['contact_name'] ?></td>
                    <td><?php echo $dealer['email'] ?></td>
                    <td><?php echo $dealer['phone'] ?></td>
                    <td><?php echo $url ?></td>
                    <td><?php echo $dealer['dealership_name'] ?></td>
                    <td>
                        <a id="edit-<?php echo $dealer['id'] ?>" class="button edit-lead-button" href="#" lead-id="<?php echo $dealer['id'] ?>">Edit</a>
                        <a id="push-<?php echo $dealer['id'] ?>" class="button push-lead-button" href="#" lead-id="<?php echo $dealer['id'] ?>">Push</a>
                        <a id="notes-<?php echo $dealer['id'] ?>" class="button notes-lead-button" href="#" lead-id="<?php echo $dealer['id'] ?>">Notes</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </section>
</div>

<div class="col-md-12">
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="fa fa-caret-down"></a>
            </div>
            <h2 class="panel-title">Done</h2>
        </header>
        <div class="panel-body">
            <table class="dealerships-container done-container">
                <tr>
                    <th><?php print_header('id') ?></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Website</th>
                    <th>Dealership</th>
                    <th></th>
                </tr>
                <?php foreach($done as $dealer) { 
                    $url = $dealer['website'];
                    if($url)
                    {
                        if(!startsWith($url, 'http://') || !startsWith($url, 'https://'))
                        {
                            $url = 'https://' . $url;
                        }

                        $url = "<a href=\"$url\" target=\"_blank\">{$dealer['website']}</a>";
                    }
                    ?>
                <tr id="done-dealer-<?php echo $dealer['id'] ?>">
                    <td><?php echo $dealer['id'] ?></td>
                    <td><?php echo $dealer['contact_name'] ?></td>
                    <td><?php echo $dealer['email'] ?></td>
                    <td><?php echo $dealer['phone'] ?></td>
                    <td><?php echo $url ?></td>
                    <td><?php echo $dealer['dealership_name'] ?></td>
                    <td>
                        <a id="edit-<?php echo $dealer['id'] ?>" class="button edit-lead-button" href="#" lead-id="<?php echo $dealer['id'] ?>">Edit</a>
                        <a id="notes-<?php echo $dealer['id'] ?>" class="button notes-lead-button" href="#" lead-id="<?php echo $dealer['id'] ?>">Notes</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </section>
</div>

<div class="scrubber-editor" title="Lead Editor" style="display: none">
<div class="form-style-2">
<div class="form-style-2-heading">Create/Edit Lead Details</div>
    <form id="lead-editor">
        <input id="dealership_id" type="hidden" name="id" value="" />
        <label for="job_title"><span>Job Title </span><input id="job_title" type="text" class="input-field" name="job_title" value="" /></label>
        <label for="contact_name"><span>Name </span><input id="contact_name" type="text" class="input-field" name="contact_name" value="" /></label>
        <label for="email"><span>Email </span><input id="email" type="text" class="input-field" name="email" value="" /></label>
        <label for="phone"><span>Phone <span class="required">*</span></span><input id="phone" type="text" class="input-field" name="phone" value="" /></label>
        <label for="website"><span>Website <span class="required">*</span></span><input id="website" type="text" class="input-field" name="website" value="" /></label>
        <label for="dealership_name"><span>Dealership <span class="required">*</span></span><input id="dealership_name" type="text" class="input-field" name="dealership_name" value="" /></label>
        <label for="dealership_name_id"><span>Dealership Id <span class="required">*</span></span><input id="dealership_name_id" type="text" class="input-field" name="dealership_id" value="" /></label>
        <label for="accountid"><span>Account ID <span class="required">*</span></span><input id="accountid" type="text" class="input-field" name="accountid" value="" /></label>
        <label for="geographic_targets"><span>Geo Targets </span><input id="geographic_targets" type="text" class="input-field" name="geographic_targets" value="" /></label>
        <label for="promotions"><span>Promotions </span><textarea id="promotions" name="promotions" class="textarea-field"></textarea></label>
        <label for="campaigns"><span>Campaigns </span><input id="new_campaigns" type="checkbox" name="new_campaigns" value="true" /><span class="field-tag">New</span><input id="used_campaigns" type="checkbox" name="used_campaigns" value="true" /><span class="field-tag">Used</span></label>
        <label for="start_type"><span>Start On</span><select id="start_type" name="start_type" class="select-field">
        <option value="1st">1st</option>
        <option value="15th">15th</option>
        </select></label>
        <label for="budget"><span>Budget <span class="required">*</span></span><input id="budget" type="text" class="input-field" name="budget" value="0.00" /></label>
    </form>
</div>
</div>

<div class="notes-editor" title="Notes" style="display: none">
<div class="form-style-2">
    <div class="form-style-2-heading">Notes for <span id="note-for-dealership"></span></div>
<div class="notes-container">
    
</div>
<div class="form-style-2-heading">Add Note</div>
<form id="note-editor">
    <input id="note_id" type="hidden" name="id" value="" />
    <input id="note_dealership_id" type="hidden" name="dealership_id" value=""/>
    <label for="field5"><span>Note <span class="required">*</span></span><textarea id="note" name="note" class="textarea-field"></textarea></label>
</form>
</div>
</div>