
var rc = {
    sendCommand(rcId, commandId) {
        var url = '/api/command/send/' + rcId + '/' + commandId;

        $.get(url);
    },
    runScenario(scId) {
        var url = '/api/scenario/run/' + scId;

        $.get(url);
    }
};

$('.rc-command').on('click', function () {
    rc.sendCommand($(this).data('rc'), $(this).data('cmd'));
});

$('.sc-command').on('click', function () {
    rc.runScenario($(this).data('sc'));
});

$('.tab-btn').on('click', function () {
    $('.tab-btn').removeClass('tab-btn-active');
    $(this).addClass('tab-btn-active');

    var tabId = $(this).data('tab-id');

    $('.tab-cnt').each(function () {
        if ($(this).attr('id') === tabId) {
            $(this).removeClass('tab-hidden');
        } else {
            $(this).addClass('tab-hidden');
        }
    });
});
