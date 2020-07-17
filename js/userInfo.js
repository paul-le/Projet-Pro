$(document).ready(function() {
    var choices = $('.choice');

    choices.on('click', function(event) {
        var choice = $(event.target);
        choice
            .find('[name="choice"]')
            .prop('checked', true)
            .trigger('change');
    });

    var inputs = $('.choice input');
    inputs.on('change', function(event) {
        var input = $(event.target);
        var choice = $(this).closest('.choice');

        $('.choice.active').removeClass('active');
        choice.addClass('active');
    });
});​
