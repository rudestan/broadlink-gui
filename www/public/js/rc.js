
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
