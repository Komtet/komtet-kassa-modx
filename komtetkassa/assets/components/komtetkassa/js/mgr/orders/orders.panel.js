miniShop2.panel.Orders = function (config) {
    config = config || {};

    Ext.apply(config, {
        cls: 'container',
        items: [{
            xtype: 'modx-tabs',
            id: 'komtet-order-status-tabs',
            stateful: true,
            stateId: 'komtet-order-status-tabs',
            stateEvents: ['tabchange'],
            getState: function () {
                return {
                    activeTab: this.items.indexOf(this.getActiveTab())
                };
            },
            deferredRender: false,
            items: [{
                title: 'Статусы фискализации заказов',
                layout: 'anchor',
                items: [{
                    xtype: 'komtet-order-status-grid',
                    id: 'komtet-order-status-grid',
                }],
            }]
        }]
    });
    miniShop2.panel.Orders.superclass.constructor.call(this, config);
};
Ext.extend(miniShop2.panel.Orders, MODx.Panel);
Ext.reg('komtet-order-status-panel', miniShop2.panel.Orders);