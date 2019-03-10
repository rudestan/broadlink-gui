var discover = {
    selectors: {
        discovered_container: '#discovered-devices-container',
        discovered_count: '#discovered-count',
        discovering_progress: '#discovering-progress',
        discovering_time: '#discovering-time'
    },
    templates: {
        discovered_device: '#template-discovered-device',
        tip_start_discover: '#template-tip-start-discover',
        spinner_big: '#template-spinner-big',
        found_count: '#template-found-count',
        discovering_progress: '#template-discovering-progress'
    },
    device_images: {
        RM: '/img/devices/rm.jpg',
        SP: '/img/devices/sp.jpg',
        SC: '/img/devices/sc.jpg',
        Unknown: '/img/devices/unknown.png'
    },
    icons: {
        authorized: 'fa-check-circle device-authorized',
        not_authorized: 'fa-question-circle device-not-authorized',
    },
    discoveryDelay: 2,
    discoveryTimeout: 30,
    discoveryInterval: null,
    discoveringProcessInterval: null,
    devicesDiscovered: [],
    counter: 30,

    initDefaultState: function()
    {
        if (this.devicesDiscovered.length === 0) {
            this.appendDataWithTemplate(
                this.selectors.discovered_container,
                this.templates.tip_start_discover,
                {},
                true
            );
        }
    },
    startDiscovery: function()
    {
        this.appendDataWithTemplate(
            this.selectors.discovered_container,
            this.templates.spinner_big,
            {},
            true
        );
        this.appendDataWithTemplate(
            this.selectors.discovering_progress,
            this.templates.discovering_progress,
            {},
            true
        );

        this.devicesDiscovered = [];
        this.discoveryInterval = setInterval(this.discover, this.discoveryDelay * 1000);
        this.discoveringProcessInterval = setInterval(function() {
            discover.discoveringProcess();
        }, 1000);

        setTimeout(function() { $('#btn-discover-stop').click(); }, this.discoveryTimeout * 1000);
    },
    stopDiscovery: function()
    {
        clearInterval(this.discoveryInterval);
        clearInterval(this.discoveringProcessInterval);
        $(this.selectors.discovering_progress).empty();
        $(this.selectors.discovering_time).empty();

        this.counter = this.discoveryTimeout;

        if (this.devicesDiscovered.length === 0) {
            this.appendDataWithTemplate(
                this.selectors.discovered_container,
                this.templates.tip_start_discover,
                {},
                true
            );
        }
    },
    discover: function()
    {
        $.ajax({
            url: "/api/device/discover",
            dataType: "json",
            method: "GET",
            success: function (data) {
                if (data.devices.length > 0) {
                    discover.addDevices(data.devices);
                }
            }
        });
    },
    discoveringProcess: function()
    {
        this.counter--;
        if (this.counter >= 0) {
            $(this.selectors.discovering_time).html('... (' + this.counter + ')');
        } else {
            $(this.selectors.discovering_time).empty();
        }
    },
    addDevices: function(devices)
    {
        if (this.devicesDiscovered.length === 0) {
            $(this.selectors.discovered_container).empty();
        }

        for(idx in devices) {
            var device = devices[idx];
            var id = device.id;

            if (this.devicesDiscovered.indexOf(id) !== -1) {
                continue;
            }

            var data = device;
            data.img = '';

            if (this.device_images.hasOwnProperty(data.type)) {
                data.img = this.device_images[data.type];
            }

            data.device_icon = this.icons.not_authorized;
            data.device_info = JSON.stringify({
                'internalId': data.internalId,
                'ip': data.ip,
                'mac': data.mac
            });

            this.appendDataWithTemplate(
                this.selectors.discovered_container,
                this.templates.discovered_device,
                data
            );

            this.devicesDiscovered.push(id);
        }

        this.appendDataWithTemplate(
            this.selectors.discovered_count,
            this.templates.found_count,
            {'count': this.devicesDiscovered.length},
            true
        );
    },
    appendDataWithTemplate: function(containerId, templateId, data, clear = false)
    {
        var template = _.template($(templateId).html());

        if (clear === true) {
            $(containerId).empty();
        }

        $(containerId).append(template(data));
    }
};

$('#btn-discover-start').on('click', function () {
    $(this).attr('disabled', 'disabled');
    $('#btn-discover-stop').removeClass('invisible');
    discover.startDiscovery();
});

$('#btn-discover-stop').on('click', function () {
    $('#btn-discover-start').removeAttr('disabled');
    $(this).addClass('invisible');
    discover.stopDiscovery();
});

discover.initDefaultState();