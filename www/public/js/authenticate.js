var auth = {
    selectors: {
        device_add_container: '#device-add-container-',
        device_card: '#device-card-',
        device_icon: '#discovered-icon-'
    },
    templates: {
        device_add: '#template-device-add',
        modal_success: '#template-modal-success'
    },
    icons: {
        authorized: 'fa-check-circle device-authorized',
        not_authorized: 'fa-question-circle device-not-authorized'
    },
    authenticate: function (el) {
        $(el).attr('disabled', 'disabled');
        var deviceInfo = $(el).data('device-info');
        var deviceId = $(el).data('device-id');

        $(this.selectors.device_card + deviceId).find('.alert').removeClass('alert-warning').empty();

        var postData = {
            'internalId': deviceInfo.internalId,
            'ip': deviceInfo.ip,
            'mac': deviceInfo.mac
        };

        $.ajax({
            url: "/api/device/authenticate",
            data: postData,
            dataType: "json",
            method: "POST",
            success: function (data) {
                $(el).removeAttr('disabled');

                if (data.authenticated === true) {
                    auth.authenticatedSuccess(deviceId, deviceInfo);
                }
            }
        });
    },
    authenticatedSuccess: function (deviceId, deviceInfo) {
        $(this.selectors.device_icon + deviceId)
            .removeClass(this.icons.not_authorized)
            .addClass(this.icons.authorized)
        ;

        this.appendDataWithTemplate(
            $(this.selectors.device_add_container + deviceId),
            this.templates.device_add,
            {
                'id': deviceId,
                'device_info': JSON.stringify(deviceInfo)
            },
            true
        );
    },
    addDevice(el) {
        var deviceId = $(el).data('device-id');
        var deviceInfo = $(el).data('device-info');
        var deviceName = $(this.selectors.device_card + deviceId + ' .device-name').val();

        if (deviceName.length > 0) {
            var postData = deviceInfo;
            postData.name = deviceName;

            $.ajax({
                url: "/api/device/add",
                data: postData,
                dataType: "json",
                method: "POST",
                success: function (data) {
                    if (data.success === true) {
                        auth.addedSuccess(el);
                    }
                }
            });
        }
    },
    addedSuccess: function(el)
    {
        $(el).text('Edit');

        this.showModal(this.templates.modal_success, {
            'title': 'Device added/edited',
            'body': 'Device was successfully added/edited! You can edit it\'s name if you want.'
        });
    },
    appendDataWithTemplate: function(containerId, templateId, data, clear = false)
    {
        var template = _.template($(templateId).html());

        if (clear === true) {
            $(containerId).empty();
        }

        $(containerId).append(template(data));
    },
    showModal: function (templateId, data)
    {
        var template = _.template($(templateId).html());

        $(template(data)).modal();
    }
};
