<?php

global $dealerships;

$todo = $dealerships['todo'];
$done = $dealerships['done'];

add_script('scrubber', 'app/js/scrubber.js');
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
            <div class="button-container clearfix">
                <a class="button add-lead-button" href="#" lead-id="0">Add Lead</a>
            </div>
            <table class="dealerships-container todo-container">
                <tr>
                    <th><?php print_header('id') ?></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Website</th>
                    <th>Dealership</th>
                    <th><?php print_header('status') ?></th>
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
                    <td><?php echo $dealer['status'] ?></td>
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
                    <th><?php print_header('status') ?></th>
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
                    <td><?php echo $dealer['status'] ?></td>
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
        <label for="status"><span>Status</span><select id="status" name="status" class="select-field">
        <option value="Open">Open</option>
        <option value="Contacted">Contacted</option>
        <option value="Qualified">Qualified</option>
        <option value="Unqualified">Unqualified</option>
        <option value="Paused">Paused</option>
        </select></label>
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