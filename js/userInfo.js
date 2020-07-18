$(document).ready(function() {
    var choices = $('.choice');
    
    choices.on('click', function(event) {
        var choice = $(event.target);
        var input = choice.find('[type="checkbox"]');
        input
            .prop('checked', !input.is(':checked'))
            .trigger('change');
    });
    
    var inputs = $('.choice input');
    inputs.on('change', function(event) {
        var input = $(event.target);
        var choice = $(this).closest('.choice');
        
        if (input.is(':checked')) {
            choice.addClass('active');
        }
        else {
            choice.removeClass('active');
        }
    });
});