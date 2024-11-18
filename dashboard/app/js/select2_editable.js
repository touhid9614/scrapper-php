$(document).ready(function() 
{
    $('.sMedia_dropdown').select2(
    {
        theme: 'bootstrap',
        tags: true,
        selectOnClose: true,

        //Allow manually entered text in drop down.
        createSearchChoice: function(term, data) 
        {
            if ($(data).filter(function() 
            {
                return this.text.localeCompare(term) === 0;
            }).length === 0) 
            {
                return { id: term, text: term };
            }
        },
    });
});