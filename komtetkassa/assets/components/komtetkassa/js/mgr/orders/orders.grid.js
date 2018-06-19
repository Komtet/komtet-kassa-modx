miniShop2.grid.Orders = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'komtet-order-status-grid';
    }

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/orders/getlist',
            sort: 'id',
            dir: 'desc',
        },
        multi_select: true,
        changed: false,
        stateful: true,
        stateId: config.id,
    });
    miniShop2.grid.Orders.superclass.constructor.call(this, config);
};
Ext.extend(miniShop2.grid.Orders, miniShop2.grid.Default, {

    getFields: function () {
        return miniShop2.config['order_grid_fields'];
    },

    getColumns: function () {
        var all = {
            id: {width: 35},
            minishop_order_id: {width: 100, header: 'ID заказа'},
            fisc_status: {width: 100, header: 'Статус заказа'},
        };

        var fields = this.getFields();
        var columns = [];
        for (var i = 0; i < fields.length; i++) {
            var field = fields[i];
            if (all[field]) {
                Ext.applyIf(all[field], {
                    dataIndex: field,
                    sortable: true,
                });
                columns.push(all[field]);
            }
        }

        return columns;
    },

    getTopBar: function () {
        return [];
    },

    getListeners: function () {
        return {
        };
    },

    orderAction: function (method) {
        var ids = this._getSelectedIds();
        if (!ids.length) {
            return false;
        }
        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/orders/multiple',
                method: method,
                ids: Ext.util.JSON.encode(ids),
            },
            listeners: {
                success: {
                    fn: function () {
                        //noinspection JSUnresolvedFunction
                        this.refresh();
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(_('error'), response.message);
                    }, scope: this
                },
            }
        })
    },
});
Ext.reg('komtet-order-status-grid', miniShop2.grid.Orders);