
var rc = {
    sendCommand(rcId, commandId) {
        console.log('Sending command...');
        console.log(rcId);
        console.log(commandId);

        var url = '/api/command/send/' + rcId + '/' + commandId;
        $.get(url);
    }
};

$('.rc-command').on('click', function () {
    rc.sendCommand($(this).data('rc'), $(this).data('cmd'));
});
