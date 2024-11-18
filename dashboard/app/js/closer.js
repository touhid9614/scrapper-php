
$(document).ready(function(){
    
    $('.edit-lead-button').click(function(){
        scrubber_edit_button_click(this);
    });
    
    $('.push-lead-button').click(function(){
        scrubber_push_button_click(this);
        return false;
    });
    
    $('.notes-lead-button').click(function(){
        scrubber_notes_button_click(this);
        return false;
    });
});

function scrubber_edit_button_click(sender)
{
    show_progress('Please wait . . . ');

    id = $(sender).attr('lead-id');

    url = 'ajax.php?act=get_dealership&id=' + id;
    
    var request = $.ajax({
        cache: false,
        url: url
    });

    request.done(function(data) {
        hide_progress();
        if(typeof(data.error) != "undefined" && data.error !== null) {
            alert(data.error.message);
        }
        else
        {
            $('#dealership_id').val(data.id);
            $('#job_title').val(data.job_title);
            $('#contact_name').val(data.contact_name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#website').val(data.website);
            $('#dealership_name').val(data.dealership_name);
            $('#status option[value="' + data.status + '"]').attr('selected', 'selected');
            $('#accountid').val(data.accountid);
            $('#geographic_targets').val(data.geographic_targets);
            $('#promotions').val(data.promotions);
            $('#start_type option[value="' + data.start_type + '"]').attr('selected', 'selected');
            $('#budget').val(data.budget);
            
            if(data.new_campaigns == 1) $('#new_campaigns').prop('checked', true);
            else $('#new_campaigns').prop('checked', false);
            if(data.used_campaigns == 1) $('#used_campaigns').prop('checked', true);
            else $('#used_campaigns').prop('checked', false);
            
            
            scrubber_open_editor();
        }
    });

    request.fail(function( jqXHR, textStatus ) {
        hide_progress();
        alert('Unable to load lead details');
    });
}

function scrubber_push_button_click(sender)
{
    var id = $(sender).attr('lead-id');
    var result = confirm('Do you really want to push it to Adwords?');
    
    if(result)
    {
        show_progress('Pushing to Adwords . . . ');

        url = 'ajax.php?act=push_lead&id=' + id;

        var request = $.ajax({
            cache: false,
            url: url
        });

        request.done(function(data) {
            hide_progress();
            if(typeof(data.error) != "undefined" && data.error !== null) {
                alert(data.error.message);
            }
            else
            {
                var id = data.id;
                var line_id = '#dealer-' + id;
                var done_id = '#done-dealer-' + id;

                $(line_id).remove();

                html = '<tr id="done-dealer-' + data.id + '">\n' +
                       '<td>' + data.id + '</td>\n' +
                       '<td>' + data.contact_name + '</td>\n' +
                       '<td>' + data.email + '</td>\n' +
                       '<td>' + data.phone + '</td>\n' +
                       '<td>' + website_to_url(data.website) + '</td>\n' +
                       '<td>' + data.dealership_name + '</td>\n' +
                       '<td>' + data.status + '</td>\n' +
                       '<td>\n' +
                       '<a id="edit-' + data.id + '" class="button edit-lead-button" href="#" lead-id="' + data.id + '">Edit</a>\n' +
                       '<a id="notes-' + data.id + '" class="button notes-lead-button" href="#" lead-id="' + data.id + '">Notes</a>\n' +
                       '</td>\n' +
                       '</tr>\n';
                $('.done-container').append(html);
                
                $(done_id).click(function(){
                    scrubber_edit_button_click(this);
                });
                
                $('#notes-' + data.id).click(function(){
                    scrubber_notes_button_click(this);
                    return false;
                });
            }
        });

        request.fail(function( jqXHR, textStatus ) {
            hide_progress();
            alert('Unable to push lead');
        });
    }
}

function scrubber_notes_button_click(sender)
{
    show_progress('Please wait . . . ');

    id = $(sender).attr('lead-id');

    url = 'ajax.php?act=get_dealership&id=' + id;
    
    var request = $.ajax({
        cache: false,
        url: url
    });

    request.done(function(data) {
        hide_progress();
        if(typeof(data.error) != "undefined" && data.error !== null) {
            alert(data.error.message);
        }
        else
        {
            if(data.notes.length > 0)
            {
                $('.notes-container').html('');
                $.each(data.notes, function(i, note){
                    show_note(note);
                });
            }
            else
            {
                $('.notes-container').html('<div class="note-none">(Empty)</div>');
            }
            $('#note_id').val('');
            $('#note_dealership_id').val(data.id);
            $('#note').val('');
            $('#note-for-dealership').text(data.dealership_name);
            
            open_note_editor();
        }
    });

    request.fail(function( jqXHR, textStatus ) {
        hide_progress();
        alert('Unable to load lead details');
    });
}

function open_note_editor()
{
    $('.notes-editor').dialog({
        resizable: false,
        modal: true,
        width: 500,
        buttons: {
            "Add Note": function() {
                
                var post_data = $('#note-editor').serialize();
                
                show_progress('Saving . . . ');

                url = 'ajax.php?act=save_note';

                var request = $.ajax({
                    cache: false,
                    url: url,
                    data: post_data,
                    type: 'POST'
                });
                
                request.done(function(data) {
                    hide_progress();
                    if(typeof(data.error) != "undefined" && data.error !== null) {
                        alert(data.error.message);
                    }
                    else
                    {
                        show_note(data);
                        $('#note_id').val('');
                        $('#note').val('');
                    }
                });

                request.fail(function( jqXHR, textStatus ) {
                    hide_progress();
                    alert('Unable to save note, ' + textStatus);
                });
            },
            "Close": function() {
                $(this).dialog("close");
            }
        },
        close: function(event, ui) {
            
        }
    });
}

function scrubber_open_editor()
{
    $('.scrubber-editor').dialog({
        resizable: false,
        modal: true,
        width: 500,
        buttons: {
            "Save": function() {
                
                var post_data       = $('#lead-editor').serialize();
                
                show_progress('Saving . . . ');

                url = 'ajax.php?act=save_closer';

                var request = $.ajax({
                    cache: false,
                    url: url,
                    data: post_data,
                    type: 'POST'
                });
                
                request.done(function(data) {
                    hide_progress();
                    if(typeof(data.error) != "undefined" && data.error !== null) {
                        alert(data.error.message);
                    }
                    else
                    {
                        $('.scrubber-editor').dialog("close");
                        
                        var id = data.id;
                        var line_id = '#dealer-' + id;
                        var done_id = '#done-dealer-' + id;
                        
                        if($(done_id).length > 0)
                        {
                            html = '<td>' + data.id + '</td>\n' +
                                   '<td>' + data.contact_name + '</td>\n' +
                                   '<td>' + data.email + '</td>\n' +
                                   '<td>' + data.phone + '</td>\n' +
                                   '<td>' + website_to_url(data.website) + '</td>\n' +
                                   '<td>' + data.dealership_name + '</td>\n' +
                                   '<td>' + data.status + '</td>\n' +
                                   '<td>\n' +
                                   '<a id="edit-' + data.id + '" class="button edit-lead-button" href="#" lead-id="' + data.id + '">Edit</a>\n' +
                                   '<a id="notes-' + data.id + '" class="button notes-lead-button" href="#" lead-id="' + data.id + '">Notes</a>\n' +
                                   '</td>\n';
                            $(done_id).html(html);
                        }
                        else if($(line_id).length > 0)
                        {
                            html = '<td>' + data.id + '</td>\n' +
                                   '<td>' + data.contact_name + '</td>\n' +
                                   '<td>' + data.email + '</td>\n' +
                                   '<td>' + data.phone + '</td>\n' +
                                   '<td>' + website_to_url(data.website) + '</td>\n' +
                                   '<td>' + data.dealership_name + '</td>\n' +
                                   '<td>' + data.status + '</td>\n' +
                                   '<td>\n' +
                                   '<a id="edit-' + data.id + '" class="button edit-lead-button" href="#" lead-id="' + data.id + '">Edit</a>\n' +
                                   '<a id="push-' + data.id + '" class="button push-lead-button" href="#" lead-id="' + data.id + '">Push</a>\n' +
                                   '<a id="notes-' + data.id + '" class="button notes-lead-button" href="#" lead-id="' + data.id + '">Notes</a>\n' +
                                   '</td>\n';
                            $(line_id).html(html);
                        }
                        else
                        {
                            html = '<tr id="dealer-' + data.id + '">\n' +
                                   '<td>' + data.id + '</td>\n' +
                                   '<td>' + data.contact_name + '</td>\n' +
                                   '<td>' + data.email + '</td>\n' +
                                   '<td>' + data.phone + '</td>\n' +
                                   '<td>' + website_to_url(data.website) + '</td>\n' +
                                   '<td>' + data.dealership_name + '</td>\n' +
                                   '<td>' + data.status + '</td>\n' +
                                   '<td>\n' +
                                   '<a id="edit-' + data.id + '" class="button edit-lead-button" href="#" lead-id="' + data.id + '">Edit</a>\n' +
                                   '<a id="push-' + data.id + '" class="button push-lead-button" href="#" lead-id="' + data.id + '">Push</a>\n' +
                                   '<a id="notes-' + data.id + '" class="button notes-lead-button" href="#" lead-id="' + data.id + '">Notes</a>\n' +
                                   '</td>\n' +
                                   '</tr>\n';
                            $('.todo-container').append(html);
                        }
                        $('#edit-' + data.id).click(function(){
                            scrubber_edit_button_click(this);
                            return false;
                        });
                        $('#push-' + data.id).click(function(){
                            scrubber_push_button_click(this);
                            return false;
                        });
                        $('#notes-' + data.id).click(function(){
                            scrubber_notes_button_click(this);
                            return false;
                        });
                    }
                });

                request.fail(function( jqXHR, textStatus ) {
                    hide_progress();
                    alert('Unable to save lead details');
                });
            },
            "Cancel": function() {
                $(this).dialog("close");
            }
        },
        close: function(event, ui) {
            
        }
    });
}