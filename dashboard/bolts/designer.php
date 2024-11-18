<?php

global $dealerships;

$todo = $dealerships['todo'];
$done = $dealerships['done'];

add_script('designer', 'app/js/designer.js');
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
        <label for="website"><span>Website</span><input id="website" type="text" class="input-field" name="website" value="" disabled/></label>
        <label for="promotions"><span>Promotions</span><textarea id="promotions" name="promotions" class="textarea-field" disabled></textarea></label>
        <label for="campaigns"><span>Campaigns</span><input id="new_campaigns" type="checkbox" name="new_campaigns" value="true" disabled/><span class="field-tag">New</span><input id="used_campaigns" type="checkbox" name="used_campaigns" value="true" disabled/><span class="field-tag">Used</span></label>
        <label for="border_color"><span>Border Colour</span><input id="border_color" type="text" class="input-field" name="border_color" value="" /></label>
        <label for="text_color"><span>Text Colour</span><input id="text_color" type="text" class="input-field" name="text_color" value="" /></label>
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